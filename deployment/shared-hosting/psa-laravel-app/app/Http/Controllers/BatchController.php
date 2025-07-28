<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Sport;
use App\Models\Coach;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BatchController extends Controller
{
    /**
     * Display a listing of batches with search and filtering
     */
    public function index(Request $request)
    {
        $query = Batch::with(['sport', 'coach']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('skill_level', 'like', "%{$search}%")
                  ->orWhereHas('sport', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('coach', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by sport
        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        // Filter by coach
        if ($request->filled('coach_id')) {
            $query->where('coach_id', $request->coach_id);
        }

        // Filter by skill level
        if ($request->filled('skill_level')) {
            $query->where('skill_level', $request->skill_level);
        }

        // Filter by capacity
        if ($request->filled('capacity_status')) {
            if ($request->capacity_status === 'available') {
                $query->whereColumn('current_capacity', '<', 'max_capacity');
            } elseif ($request->capacity_status === 'full') {
                $query->whereColumn('current_capacity', '>=', 'max_capacity');
            }
        }

        // Get batches with student count
        $batches = $query->withCount('students')
                        ->orderBy('name')
                        ->paginate(10)
                        ->withQueryString();

        // Get filter options
        $sports = Sport::active()->orderBy('name')->get();
        $coaches = Coach::active()->orderBy('name')->get();
        $skillLevels = Batch::distinct()->pluck('skill_level')->filter()->sort()->values();

        // Statistics
        $stats = [
            'total_batches' => Batch::count(),
            'active_batches' => Batch::where('is_active', true)->count(),
            'inactive_batches' => Batch::where('is_active', false)->count(),
            'total_students' => \DB::table('students')->whereNotNull('batch_id')->count(),
            'available_spots' => Batch::sum('max_capacity') - \DB::table('students')->whereNotNull('batch_id')->count(),
        ];

        return view('batches.index', compact('batches', 'sports', 'coaches', 'skillLevels', 'stats'));
    }

    /**
     * Show the form for creating a new batch
     */
    public function create()
    {
        $sports = Sport::active()->orderBy('name')->get();
        $coaches = Coach::active()->orderBy('name')->get();
        
        return view('batches.create', compact('sports', 'coaches'));
    }

    /**
     * Store a newly created batch in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:batches,name',
            'sport_id' => 'required|exists:sports,id',
            'coach_id' => 'nullable|exists:coaches,id',
            'description' => 'nullable|string|max:1000',
            'schedule' => 'nullable|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'max_capacity' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['current_students'] = 0;

        $batch = Batch::create($validated);

        return redirect()
            ->route('batches.show', $batch)
            ->with('success', 'Batch created successfully!');
    }

    /**
     * Display the specified batch with detailed information
     */
    public function show(Batch $batch)
    {
        $batch->load(['sport', 'coach', 'students.payments']);
        
        // Get batch statistics
        $stats = [
            'total_students' => $batch->students->count(),
            'capacity_utilization' => $batch->max_capacity > 0 ? round(($batch->students->count() / $batch->max_capacity) * 100, 1) : 0,
            'available_spots' => max(0, $batch->max_capacity - $batch->students->count()),
            'total_revenue' => $batch->students->sum(function ($student) {
                return $student->payments->where('status', 'completed')->sum('amount');
            }),
        ];

        // Get recent students
        $recentStudents = $batch->students()
                               ->with(['payments'])
                               ->orderBy('created_at', 'desc')
                               ->limit(5)
                               ->get();

        // Format schedule for display
        $schedule = $batch->schedule;
        $scheduleText = '';
        if (isset($schedule['days']) && isset($schedule['start_time']) && isset($schedule['end_time'])) {
            $days = is_array($schedule['days']) ? implode(', ', $schedule['days']) : $schedule['days'];
            $scheduleText = "{$days} ({$schedule['start_time']} - {$schedule['end_time']})";
        }

        return view('batches.show', compact('batch', 'stats', 'recentStudents', 'scheduleText'));
    }

    /**
     * Show the form for editing the specified batch
     */
    public function edit(Batch $batch)
    {
        $sports = Sport::active()->orderBy('name')->get();
        $coaches = Coach::active()->orderBy('name')->get();
        
        return view('batches.edit', compact('batch', 'sports', 'coaches'));
    }

    /**
     * Update the specified batch in storage
     */
    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('batches', 'name')->ignore($batch->id)
            ],
            'sport_id' => 'required|exists:sports,id',
            'coach_id' => 'nullable|exists:coaches,id',
            'description' => 'nullable|string|max:1000',
            'schedule' => 'nullable|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'max_capacity' => 'required|integer|min:' . $batch->current_students . '|max:100',
            'is_active' => 'boolean',
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');

        $batch->update($validated);

        return redirect()
            ->route('batches.show', $batch)
            ->with('success', 'Batch updated successfully!');
    }

    /**
     * Remove the specified batch from storage
     */
    public function destroy(Batch $batch)
    {
        // Check if batch has students
        $totalStudents = $batch->students()->count();
        
        if ($totalStudents > 0) {
            return redirect()
                ->route('batches.index')
                ->with('error', 'Cannot delete batch with enrolled students. Please transfer students first.');
        }

        $batchName = $batch->name;
        $batch->delete();

        return redirect()
            ->route('batches.index')
            ->with('success', "Batch '{$batchName}' deleted successfully!");
    }

    /**
     * Export batches data
     */
    public function export(Request $request)
    {
        $query = Batch::with(['sport', 'coach']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('skill_level', 'like', "%{$search}%")
                  ->orWhereHas('sport', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('coach', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        if ($request->filled('coach_id')) {
            $query->where('coach_id', $request->coach_id);
        }

        $batches = $query->withCount('students')->orderBy('name')->get();

        $filename = 'batches_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($batches) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Sport',
                'Coach',
                'Schedule Days',
                'Start Time',
                'End Time',
                'Skill Level',
                'Max Capacity',
                'Current Students',
                'Available Spots',
                'Status',
                'Created Date'
            ]);

            // CSV data
            foreach ($batches as $batch) {
                $schedule = $batch->schedule ?? [];
                $days = isset($schedule['days']) ? (is_array($schedule['days']) ? implode(', ', $schedule['days']) : $schedule['days']) : 'N/A';
                $availableSpots = max(0, $batch->max_capacity - $batch->students_count);
                
                fputcsv($file, [
                    $batch->id,
                    $batch->name,
                    $batch->sport->name ?? 'N/A',
                    $batch->coach->name ?? 'N/A',
                    $days,
                    $schedule['start_time'] ?? 'N/A',
                    $schedule['end_time'] ?? 'N/A',
                    $batch->skill_level,
                    $batch->max_capacity,
                    $batch->students_count,
                    $availableSpots,
                    $batch->is_active ? 'Active' : 'Inactive',
                    $batch->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Toggle batch active status
     */
    public function toggleStatus(Batch $batch)
    {
        $batch->update(['is_active' => !$batch->is_active]);
        
        $status = $batch->is_active ? 'activated' : 'deactivated';
        
        return redirect()
            ->back()
            ->with('success', "Batch {$status} successfully!");
    }
}