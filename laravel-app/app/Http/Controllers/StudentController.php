<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Sport;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::with(['sport', 'batch', 'payments']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Filter by sport
        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        // Filter by batch
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $students = $query->paginate(15)->withQueryString();
        
        // Get filter options
        $sports = Sport::all();
        $batches = Batch::all();

        return view('students.index', compact('students', 'sports', 'batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sports = Sport::all();
        $batches = Batch::all();
        
        return view('students.create', compact('sports', 'batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:students,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'sport_id' => 'required|exists:sports,id',
            'batch_id' => 'nullable|exists:batches,id',
            'fee_amount' => 'required|numeric|min:0',
            'medical_conditions' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        // Transform data to match database schema
        $studentData = [
            'student_id' => $this->generateStudentId(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'emergency_contact' => [
                'name' => $validated['emergency_contact_name'],
                'phone' => $validated['emergency_contact_phone']
            ],
            'medical_notes' => $validated['medical_conditions'],
            'sport_id' => $validated['sport_id'],
            'batch_id' => $validated['batch_id'],
            'skill_level' => 'beginner', // Default skill level
            'is_active' => $validated['status'] === 'active'
        ];

        DB::beginTransaction();
        try {
            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $studentData['profile_image_url'] = $request->file('profile_photo')->store('students/profiles', 'public');
            }

            $student = Student::create($studentData);

            // Log activity
            activity()
                ->performedOn($student)
                ->causedBy(auth()->user())
                ->log("Student {$student->name} was registered");

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', 'Student registered successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Student registration failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to register student. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['sport', 'batch', 'payments', 'attendances']);
        
        // Get payment statistics
        $paymentStats = [
            'total_paid' => $student->payments()->where('status', 'completed')->sum('amount'),
            'total_pending' => $student->payments()->where('status', 'pending')->sum('amount'),
            'last_payment' => $student->payments()->where('status', 'completed')->latest()->first(),
        ];

        // Get attendance statistics
        $attendanceStats = [
            'total_sessions' => $student->attendances()->count(),
            'present_sessions' => $student->attendances()->where('status', 'present')->count(),
            'absent_sessions' => $student->attendances()->where('status', 'absent')->count(),
        ];

        return view('students.show', compact('student', 'paymentStats', 'attendanceStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $sports = Sport::all();
        $batches = Batch::all();
        
        return view('students.edit', compact('student', 'sports', 'batches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('students')->ignore($student->id)],
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'sport_id' => 'required|exists:sports,id',
            'batch_id' => 'nullable|exists:batches,id',
            'fee_amount' => 'required|numeric|min:0',
            'medical_conditions' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        DB::beginTransaction();
        try {
            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo if exists
                if ($student->profile_photo) {
                    Storage::disk('public')->delete($student->profile_photo);
                }
                $validated['profile_photo'] = $request->file('profile_photo')->store('students/profiles', 'public');
            }

            $student->update($validated);

            // Log activity
            activity()
                ->performedOn($student)
                ->causedBy(auth()->user())
                ->log("Student {$student->name} was updated");

            DB::commit();

            return redirect()->route('students.show', $student)
                ->with('success', 'Student updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Failed to update student. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        DB::beginTransaction();
        try {
            // Delete profile photo if exists
            if ($student->profile_photo) {
                Storage::disk('public')->delete($student->profile_photo);
            }

            $studentName = $student->name;
            $student->delete();

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->log("Student {$studentName} was deleted");

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', 'Student deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to delete student. Please try again.');
        }
    }

    /**
     * Generate unique registration number
     */
    private function generateStudentId()
    {
        $prefix = 'STU';
        
        $lastStudent = Student::where('student_id', 'like', $prefix . '%')
            ->orderBy('student_id', 'desc')
            ->first();

        if ($lastStudent) {
            $lastNumber = intval(substr($lastStudent->student_id, -3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Export students data
     */
    public function export(Request $request)
    {
        // This will be implemented later with Excel export
        return back()->with('info', 'Export functionality coming soon!');
    }
}
