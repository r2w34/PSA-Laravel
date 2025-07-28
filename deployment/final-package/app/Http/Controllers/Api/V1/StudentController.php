<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Student;
use App\Models\Sport;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StudentController extends BaseApiController
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = Student::with(['sport', 'batch', 'createdBy']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Filter by sport
        if ($request->has('sport_id') && !empty($request->sport_id)) {
            $query->where('sport_id', $request->sport_id);
        }

        // Filter by batch
        if ($request->has('batch_id') && !empty($request->batch_id)) {
            $query->where('batch_id', $request->batch_id);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by gender
        if ($request->has('gender') && !empty($request->gender)) {
            $query->where('gender', $request->gender);
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $students = $query->paginate($perPage);

        return $this->sendPaginatedResponse($students, 'Students retrieved successfully');
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'emergency_contact' => 'required|string|max:20',
            'sport_id' => 'required|exists:sports,id',
            'batch_id' => 'nullable|exists:batches,id',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'medical_conditions' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $data = $request->all();
        
        // Generate student ID
        $data['student_id'] = 'PSA' . date('Y') . str_pad(Student::count() + 1, 6, '0', STR_PAD_LEFT);
        $data['status'] = 'active';
        $data['created_by'] = $request->user()->id;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('students', $filename, 'public');
            $data['photo_url'] = Storage::url($path);
        }

        $student = Student::create($data);
        $student->load(['sport', 'batch', 'createdBy']);

        return $this->sendResponse($student, 'Student created successfully', 201);
    }

    /**
     * Display the specified student.
     */
    public function show($id)
    {
        $student = Student::with(['sport', 'batch', 'createdBy', 'payments', 'attendances'])->find($id);

        if (!$student) {
            return $this->sendError('Student not found');
        }

        return $this->sendResponse($student, 'Student retrieved successfully');
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->sendError('Student not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:students,email,' . $id,
            'phone' => 'sometimes|required|string|max:20',
            'date_of_birth' => 'sometimes|required|date',
            'gender' => 'sometimes|required|in:male,female,other',
            'address' => 'sometimes|required|string',
            'emergency_contact' => 'sometimes|required|string|max:20',
            'sport_id' => 'sometimes|required|exists:sports,id',
            'batch_id' => 'sometimes|nullable|exists:batches,id',
            'guardian_name' => 'sometimes|required|string|max:255',
            'guardian_phone' => 'sometimes|required|string|max:20',
            'medical_conditions' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|in:active,inactive,suspended',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo_url) {
                $oldPath = str_replace('/storage/', '', $student->photo_url);
                Storage::disk('public')->delete($oldPath);
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('students', $filename, 'public');
            $data['photo_url'] = Storage::url($path);
        }

        $student->update($data);
        $student->load(['sport', 'batch', 'createdBy']);

        return $this->sendResponse($student, 'Student updated successfully');
    }

    /**
     * Remove the specified student.
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->sendError('Student not found');
        }

        // Delete photo if exists
        if ($student->photo_url) {
            $path = str_replace('/storage/', '', $student->photo_url);
            Storage::disk('public')->delete($path);
        }

        $student->delete();

        return $this->sendResponse([], 'Student deleted successfully');
    }

    /**
     * Get student statistics
     */
    public function statistics()
    {
        $stats = [
            'total_students' => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'inactive_students' => Student::where('status', 'inactive')->count(),
            'suspended_students' => Student::where('status', 'suspended')->count(),
            'male_students' => Student::where('gender', 'male')->count(),
            'female_students' => Student::where('gender', 'female')->count(),
            'students_by_sport' => Student::with('sport')
                ->selectRaw('sport_id, count(*) as count')
                ->groupBy('sport_id')
                ->get()
                ->map(function ($item) {
                    return [
                        'sport' => $item->sport->name ?? 'Unknown',
                        'count' => $item->count
                    ];
                }),
            'recent_registrations' => Student::with(['sport', 'batch'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];

        return $this->sendResponse($stats, 'Student statistics retrieved successfully');
    }

    /**
     * Get sports list for dropdown
     */
    public function sports()
    {
        $sports = Sport::select('id', 'name', 'description')->where('is_active', true)->get();
        return $this->sendResponse($sports, 'Sports retrieved successfully');
    }

    /**
     * Get batches list for dropdown
     */
    public function batches(Request $request)
    {
        $query = Batch::with('sport')->select('id', 'name', 'sport_id', 'start_time', 'end_time');
        
        if ($request->has('sport_id') && !empty($request->sport_id)) {
            $query->where('sport_id', $request->sport_id);
        }
        
        $batches = $query->where('is_active', true)->get();
        return $this->sendResponse($batches, 'Batches retrieved successfully');
    }
}
