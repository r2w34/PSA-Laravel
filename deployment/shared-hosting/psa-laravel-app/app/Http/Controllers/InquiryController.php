<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Sport;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InquiryController extends Controller
{
    /**
     * Display a listing of inquiries
     */
    public function index(Request $request)
    {
        $query = Inquiry::with(['sport', 'batch', 'assignedTo', 'student']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Filter by sport
        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by latest first
        $inquiries = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get filter options
        $sports = Sport::orderBy('name')->get();
        $batches = Batch::with('sport')->orderBy('name')->get();

        // Statistics
        $stats = [
            'total' => Inquiry::count(),
            'new' => Inquiry::where('status', 'new')->count(),
            'in_progress' => Inquiry::where('status', 'in_progress')->count(),
            'converted' => Inquiry::where('status', 'converted')->count(),
            'closed' => Inquiry::where('status', 'closed')->count(),
            'high_priority' => Inquiry::where('priority', 'high')->count(),
        ];

        return view('inquiries.index', compact('inquiries', 'sports', 'batches', 'stats'));
    }

    /**
     * Show the form for creating a new inquiry
     */
    public function create()
    {
        $sports = Sport::orderBy('name')->get();
        $batches = Batch::with('sport')->orderBy('name')->get();
        
        return view('inquiries.create', compact('sports', 'batches'));
    }

    /**
     * Store a newly created inquiry
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'sport_id' => 'required|exists:sports,id',
            'batch_id' => 'nullable|exists:batches,id',
            'age' => 'nullable|integer|min:3|max:50',
            'gender' => 'nullable|in:male,female,other',
            'priority' => 'required|in:low,medium,high',
            'source' => 'required|in:website,phone,walk_in,referral,social_media,advertisement',
            'notes' => 'nullable|string|max:1000',
            'follow_up_date' => 'nullable|date|after:today'
        ]);

        $inquiry = Inquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'sport_id' => $request->sport_id,
            'batch_id' => $request->batch_id,
            'age' => $request->age,
            'gender' => $request->gender,
            'priority' => $request->priority,
            'source' => $request->source,
            'status' => 'new',
            'notes' => $request->notes,
            'follow_up_date' => $request->follow_up_date,
            'assigned_to' => Auth::id(),
            'created_by' => Auth::id()
        ]);

        return redirect()->route('inquiries.index')
                        ->with('success', 'Inquiry created successfully!');
    }

    /**
     * Display the specified inquiry
     */
    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['sport', 'batch', 'assignedTo', 'createdBy', 'student']);
        
        return view('inquiries.show', compact('inquiry'));
    }

    /**
     * Show the form for editing the specified inquiry
     */
    public function edit(Inquiry $inquiry)
    {
        $sports = Sport::orderBy('name')->get();
        $batches = Batch::with('sport')->orderBy('name')->get();
        $students = Student::orderBy('name')->get();
        
        return view('inquiries.edit', compact('inquiry', 'sports', 'batches', 'students'));
    }

    /**
     * Update the specified inquiry
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'sport_id' => 'required|exists:sports,id',
            'batch_id' => 'nullable|exists:batches,id',
            'age' => 'nullable|integer|min:3|max:50',
            'gender' => 'nullable|in:male,female,other',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:new,in_progress,converted,closed',
            'source' => 'required|in:website,phone,walk_in,referral,social_media,advertisement',
            'notes' => 'nullable|string|max:1000',
            'follow_up_date' => 'nullable|date',
            'student_id' => 'nullable|exists:students,id'
        ]);

        $inquiry->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'sport_id' => $request->sport_id,
            'batch_id' => $request->batch_id,
            'age' => $request->age,
            'gender' => $request->gender,
            'priority' => $request->priority,
            'status' => $request->status,
            'source' => $request->source,
            'notes' => $request->notes,
            'follow_up_date' => $request->follow_up_date,
            'student_id' => $request->student_id,
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('inquiries.index')
                        ->with('success', 'Inquiry updated successfully!');
    }

    /**
     * Remove the specified inquiry
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiryName = $inquiry->name;
        $inquiry->delete();

        return redirect()->route('inquiries.index')
                        ->with('success', "Inquiry for {$inquiryName} deleted successfully!");
    }

    /**
     * Convert inquiry to student
     */
    public function convertToStudent(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'student_id' => 'required|string|max:20|unique:students,student_id',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'emergency_contact' => 'required|array',
            'emergency_contact.name' => 'required|string|max:255',
            'emergency_contact.phone' => 'required|string|max:20',
            'emergency_contact.relationship' => 'required|string|max:100',
            'medical_conditions' => 'nullable|string|max:1000'
        ]);

        // Create student from inquiry
        $student = Student::create([
            'student_id' => $request->student_id,
            'name' => $inquiry->name,
            'email' => $inquiry->email,
            'phone' => $inquiry->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $inquiry->gender,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'medical_conditions' => $request->medical_conditions,
            'status' => 'active',
            'created_by' => Auth::id()
        ]);

        // Update inquiry status
        $inquiry->update([
            'status' => 'converted',
            'student_id' => $student->id,
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('inquiries.show', $inquiry)
                        ->with('success', 'Inquiry converted to student successfully!');
    }

    /**
     * Export inquiries to CSV
     */
    public function export(Request $request)
    {
        $query = Inquiry::with(['sport', 'batch', 'assignedTo', 'student']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->get();

        $filename = 'inquiries_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($inquiries) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Date', 'Name', 'Email', 'Phone', 'Sport', 'Batch', 'Age', 'Gender',
                'Priority', 'Status', 'Source', 'Follow Up Date', 'Assigned To', 'Notes'
            ]);

            // CSV data
            foreach ($inquiries as $inquiry) {
                fputcsv($file, [
                    $inquiry->created_at->format('Y-m-d'),
                    $inquiry->name,
                    $inquiry->email,
                    $inquiry->phone,
                    $inquiry->sport->name ?? '',
                    $inquiry->batch->name ?? '',
                    $inquiry->age ?? '',
                    $inquiry->gender ?? '',
                    ucfirst($inquiry->priority),
                    ucfirst(str_replace('_', ' ', $inquiry->status)),
                    ucfirst(str_replace('_', ' ', $inquiry->source)),
                    $inquiry->follow_up_date ? $inquiry->follow_up_date->format('Y-m-d') : '',
                    $inquiry->assignedTo->name ?? '',
                    $inquiry->notes ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Update inquiry status
     */
    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,converted,closed',
            'notes' => 'nullable|string|max:1000'
        ]);

        $inquiry->update([
            'status' => $request->status,
            'notes' => $request->notes ? $inquiry->notes . "\n\n" . date('Y-m-d H:i:s') . " - " . $request->notes : $inquiry->notes,
            'updated_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Inquiry status updated successfully!');
    }
}