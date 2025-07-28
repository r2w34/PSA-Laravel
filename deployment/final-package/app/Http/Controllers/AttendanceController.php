<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{

    /**
     * Display a listing of attendance records
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'batch', 'markedBy']);

        // Apply filters
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $attendances = $query->orderBy('date', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        // Get filter options
        $batches = Batch::with('sport')->where('is_active', true)->get();
        
        // Calculate statistics
        $stats = [
            'total_records' => Attendance::count(),
            'present_today' => Attendance::whereDate('date', today())->where('status', 'present')->count(),
            'absent_today' => Attendance::whereDate('date', today())->where('status', 'absent')->count(),
            'late_today' => Attendance::whereDate('date', today())->where('status', 'late')->count(),
        ];

        return view('attendance.index', compact('attendances', 'batches', 'stats'));
    }

    /**
     * Show the form for creating new attendance records
     */
    public function create(Request $request)
    {
        $batches = Batch::with(['sport', 'students'])->where('is_active', true)->get();
        $selectedBatch = null;
        $students = collect();

        if ($request->filled('batch_id')) {
            $selectedBatch = Batch::with(['sport', 'students'])->find($request->batch_id);
            if ($selectedBatch) {
                $students = $selectedBatch->students;
            }
        }

        $date = $request->filled('date') ? $request->date : today()->format('Y-m-d');

        return view('attendance.create', compact('batches', 'selectedBatch', 'students', 'date'));
    }

    /**
     * Store attendance records in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500'
        ]);

        $batch = Batch::findOrFail($request->batch_id);
        $date = Carbon::parse($request->date);

        // Check if attendance already exists for this batch and date
        $existingCount = Attendance::where('batch_id', $request->batch_id)
                                  ->whereDate('date', $date)
                                  ->count();

        if ($existingCount > 0) {
            return redirect()->back()
                           ->withErrors(['date' => 'Attendance for this batch and date already exists.'])
                           ->withInput();
        }

        $created = 0;
        foreach ($request->attendance as $studentId => $status) {
            Attendance::create([
                'student_id' => $studentId,
                'batch_id' => $request->batch_id,
                'date' => $date,
                'status' => $status,
                'notes' => $request->notes[$studentId] ?? null,
                'marked_by' => Auth::id(),
                'marked_at' => now()
            ]);
            $created++;
        }

        return redirect()->route('attendance.index')
                        ->with('success', "Attendance marked for {$created} students in {$batch->name} on {$date->format('M d, Y')}");
    }

    /**
     * Display the specified attendance record
     */
    public function show(Attendance $attendance)
    {
        $attendance->load(['student', 'batch.sport', 'markedBy']);
        
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing attendance
     */
    public function edit(Attendance $attendance)
    {
        $attendance->load(['student', 'batch.sport']);
        
        return view('attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified attendance record
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
            'notes' => 'nullable|string|max:500'
        ]);

        $attendance->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'marked_by' => Auth::id(),
            'marked_at' => now()
        ]);

        return redirect()->route('attendance.index')
                        ->with('success', 'Attendance record updated successfully!');
    }

    /**
     * Remove the specified attendance record
     */
    public function destroy(Attendance $attendance)
    {
        $studentName = $attendance->student->name;
        $batchName = $attendance->batch->name;
        $date = $attendance->date->format('M d, Y');
        
        $attendance->delete();

        return redirect()->route('attendance.index')
                        ->with('success', "Attendance record for {$studentName} in {$batchName} on {$date} deleted successfully!");
    }

    /**
     * Mark attendance for a specific batch and date
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'date' => 'required|date'
        ]);

        $batch = Batch::with(['sport', 'students'])->findOrFail($request->batch_id);
        $date = Carbon::parse($request->date);

        // Check if attendance already exists
        $existingAttendance = Attendance::where('batch_id', $request->batch_id)
                                       ->whereDate('date', $date)
                                       ->with('student')
                                       ->get()
                                       ->keyBy('student_id');

        return view('attendance.mark', compact('batch', 'date', 'existingAttendance'));
    }

    /**
     * Update bulk attendance
     */
    public function updateBulk(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500'
        ]);

        $batch = Batch::findOrFail($request->batch_id);
        $date = Carbon::parse($request->date);

        $updated = 0;
        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'batch_id' => $request->batch_id,
                    'date' => $date
                ],
                [
                    'status' => $status,
                    'notes' => $request->notes[$studentId] ?? null,
                    'marked_by' => Auth::id(),
                    'marked_at' => now()
                ]
            );
            $updated++;
        }

        return redirect()->route('attendance.index')
                        ->with('success', "Attendance updated for {$updated} students in {$batch->name} on {$date->format('M d, Y')}");
    }

    /**
     * Export attendance data
     */
    public function export(Request $request)
    {
        $query = Attendance::with(['student', 'batch.sport', 'markedBy']);

        // Apply same filters as index
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        $filename = 'attendance_records_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Date', 'Student Name', 'Student Email', 'Batch', 'Sport', 
                'Status', 'Notes', 'Marked By', 'Marked At'
            ]);

            // CSV data
            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->date->format('Y-m-d'),
                    $attendance->student->name,
                    $attendance->student->email,
                    $attendance->batch->name,
                    $attendance->batch->sport->name,
                    ucfirst($attendance->status),
                    $attendance->notes,
                    $attendance->markedBy->name ?? 'System',
                    $attendance->marked_at ? $attendance->marked_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
