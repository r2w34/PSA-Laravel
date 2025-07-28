<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FeeController extends Controller
{
    /**
     * Display a listing of fees/payments
     */
    public function index(Request $request)
    {
        $query = Payment::with(['student', 'batch']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by batch
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'payment_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $payments = $query->paginate(15);

        // Get filter options
        $batches = Batch::with('sport')->get();
        $paymentMethods = ['cash', 'card', 'upi', 'bank_transfer', 'cheque'];
        $statuses = ['pending', 'completed', 'failed', 'refunded'];

        // Calculate statistics
        $stats = [
            'total_collected' => Payment::where('status', 'completed')->sum('amount'),
            'pending_amount' => Payment::where('status', 'pending')->sum('amount'),
            'this_month_collection' => Payment::where('status', 'completed')
                ->whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount'),
            'total_students_with_dues' => Payment::where('status', 'pending')->distinct('student_id')->count(),
        ];

        return view('fees.index', compact('payments', 'batches', 'paymentMethods', 'statuses', 'stats'));
    }

    /**
     * Show the form for creating a new fee payment
     */
    public function create(Request $request)
    {
        $students = Student::with(['sport', 'batch'])->where('is_active', true)->get();
        $batches = Batch::with('sport')->get();
        
        // If student_id is provided, pre-select the student
        $selectedStudent = null;
        if ($request->filled('student_id')) {
            $selectedStudent = Student::find($request->student_id);
        }

        return view('fees.create', compact('students', 'batches', 'selectedStudent'));
    }

    /**
     * Store a newly created fee payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'batch_id' => 'required|exists:batches,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,card,upi,bank_transfer,cheque',
            'payment_date' => 'required|date',
            'due_date' => 'nullable|date|after:payment_date',
            'description' => 'nullable|string|max:500',
            'transaction_id' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $payment = Payment::create([
                'student_id' => $request->student_id,
                'batch_id' => $request->batch_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
                'due_date' => $request->due_date,
                'status' => $request->payment_method === 'cash' ? 'completed' : 'pending',
                'description' => $request->description,
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            // Log activity
            activity()
                ->performedOn($payment)
                ->causedBy(auth()->user())
                ->log('Fee payment recorded');

            DB::commit();

            return redirect()->route('fees.index')
                ->with('success', 'Fee payment recorded successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Fee payment creation failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Failed to record fee payment. Please try again.');
        }
    }

    /**
     * Display the specified fee payment
     */
    public function show(Payment $fee)
    {
        $fee->load(['student', 'batch.sport', 'createdBy']);
        
        // Get payment history for this student
        $paymentHistory = Payment::where('student_id', $fee->student_id)
            ->with(['batch'])
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('fees.show', compact('fee', 'paymentHistory'));
    }

    /**
     * Show the form for editing the specified fee payment
     */
    public function edit(Payment $fee)
    {
        $students = Student::with(['sport', 'batch'])->where('is_active', true)->get();
        $batches = Batch::with('sport')->get();

        return view('fees.edit', compact('fee', 'students', 'batches'));
    }

    /**
     * Update the specified fee payment
     */
    public function update(Request $request, Payment $fee)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'batch_id' => 'required|exists:batches,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,card,upi,bank_transfer,cheque',
            'payment_date' => 'required|date',
            'due_date' => 'nullable|date|after:payment_date',
            'status' => 'required|in:pending,completed,failed,refunded',
            'description' => 'nullable|string|max:500',
            'transaction_id' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $fee->update([
                'student_id' => $request->student_id,
                'batch_id' => $request->batch_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'description' => $request->description,
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes,
            ]);

            // Log activity
            activity()
                ->performedOn($fee)
                ->causedBy(auth()->user())
                ->log('Fee payment updated');

            DB::commit();

            return redirect()->route('fees.index')
                ->with('success', 'Fee payment updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Fee payment update failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Failed to update fee payment. Please try again.');
        }
    }

    /**
     * Remove the specified fee payment
     */
    public function destroy(Payment $fee)
    {
        try {
            DB::beginTransaction();

            // Log activity before deletion
            activity()
                ->performedOn($fee)
                ->causedBy(auth()->user())
                ->log('Fee payment deleted');

            $fee->delete();

            DB::commit();

            return redirect()->route('fees.index')
                ->with('success', 'Fee payment deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Fee payment deletion failed: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Failed to delete fee payment. Please try again.');
        }
    }

    /**
     * Mark payment as completed
     */
    public function markCompleted(Payment $fee)
    {
        try {
            $fee->update([
                'status' => 'completed',
                'payment_date' => now(),
            ]);

            activity()
                ->performedOn($fee)
                ->causedBy(auth()->user())
                ->log('Fee payment marked as completed');

            return back()->with('success', 'Payment marked as completed!');

        } catch (\Exception $e) {
            Log::error('Failed to mark payment as completed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update payment status.');
        }
    }

    /**
     * Generate fee receipt
     */
    public function receipt(Payment $fee)
    {
        $fee->load(['student', 'batch.sport', 'createdBy']);
        
        return view('fees.receipt', compact('fee'));
    }

    /**
     * Export fees data
     */
    public function export(Request $request)
    {
        // This will be implemented with Excel export functionality
        return back()->with('info', 'Export functionality will be implemented soon.');
    }

    /**
     * Get outstanding fees for a student
     */
    public function getStudentOutstanding(Request $request)
    {
        $studentId = $request->get('student_id');
        
        if (!$studentId) {
            return response()->json(['error' => 'Student ID required'], 400);
        }

        $student = Student::with(['batch', 'payments'])->find($studentId);
        
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $totalPaid = $student->payments()->where('status', 'completed')->sum('amount');
        $pendingAmount = $student->payments()->where('status', 'pending')->sum('amount');

        return response()->json([
            'student' => $student,
            'total_paid' => $totalPaid,
            'pending_amount' => $pendingAmount,
            'last_payment' => $student->payments()->latest('payment_date')->first(),
        ]);
    }
}
