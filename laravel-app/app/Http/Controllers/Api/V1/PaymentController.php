<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaymentController extends BaseApiController
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['student', 'batch', 'createdBy']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by student
        if ($request->has('student_id') && !empty($request->student_id)) {
            $query->where('student_id', $request->student_id);
        }

        // Filter by payment method
        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by payment type
        if ($request->has('payment_type') && !empty($request->payment_type)) {
            $query->where('payment_type', $request->payment_type);
        }

        // Filter by date range
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        // Filter by amount range
        if ($request->has('amount_min') && !empty($request->amount_min)) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->has('amount_max') && !empty($request->amount_max)) {
            $query->where('amount', '<=', $request->amount_max);
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $payments = $query->paginate($perPage);

        return $this->sendPaginatedResponse($payments, 'Payments retrieved successfully');
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'batch_id' => 'nullable|exists:batches,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:monthly,registration,tournament',
            'payment_method' => 'required|in:cash,card,upi,bank_transfer,cheque,online',
            'status' => 'required|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'due_date' => 'nullable|date',
            'month_year' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $data = $request->all();
        
        // Generate receipt number
        $data['receipt_number'] = $this->generateReceiptNumber();
        $data['created_by'] = $request->user()->id;

        $payment = Payment::create($data);
        $payment->load(['student', 'batch', 'createdBy']);

        return $this->sendResponse($payment, 'Payment created successfully', 201);
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $payment = Payment::with(['student', 'batch', 'createdBy'])->find($id);

        if (!$payment) {
            return $this->sendError('Payment not found');
        }

        return $this->sendResponse($payment, 'Payment retrieved successfully');
    }

    /**
     * Update the specified payment.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return $this->sendError('Payment not found');
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'sometimes|required|exists:students,id',
            'batch_id' => 'sometimes|nullable|exists:batches,id',
            'amount' => 'sometimes|required|numeric|min:0',
            'payment_type' => 'sometimes|required|in:monthly,registration,tournament',
            'payment_method' => 'sometimes|required|in:cash,card,upi,bank_transfer,cheque,online',
            'status' => 'sometimes|required|in:pending,completed,failed,refunded',
            'transaction_id' => 'sometimes|nullable|string|max:255',
            'payment_date' => 'sometimes|required|date',
            'due_date' => 'sometimes|nullable|date',
            'month_year' => 'sometimes|nullable|string|max:50',
            'description' => 'sometimes|nullable|string|max:255',
            'notes' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $payment->update($request->all());
        $payment->load(['student', 'batch', 'createdBy']);

        return $this->sendResponse($payment, 'Payment updated successfully');
    }

    /**
     * Remove the specified payment.
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return $this->sendError('Payment not found');
        }

        $payment->delete();

        return $this->sendResponse([], 'Payment deleted successfully');
    }

    /**
     * Get payment statistics
     */
    public function statistics()
    {
        $stats = [
            'total_payments' => Payment::count(),
            'total_amount' => Payment::sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'completed_payments' => Payment::where('status', 'completed')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'refunded_payments' => Payment::where('status', 'refunded')->count(),
            'this_month_amount' => Payment::whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount'),
            'payments_by_method' => Payment::selectRaw('payment_method, count(*) as count, sum(amount) as total_amount')
                ->groupBy('payment_method')
                ->get(),
            'payments_by_type' => Payment::selectRaw('payment_type, count(*) as count, sum(amount) as total_amount')
                ->groupBy('payment_type')
                ->get(),
            'recent_payments' => Payment::with(['student', 'batch'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];

        return $this->sendResponse($stats, 'Payment statistics retrieved successfully');
    }

    /**
     * Get student payments
     */
    public function studentPayments($studentId)
    {
        $student = Student::find($studentId);

        if (!$student) {
            return $this->sendError('Student not found');
        }

        $payments = Payment::with(['batch', 'createdBy'])
            ->where('student_id', $studentId)
            ->orderBy('payment_date', 'desc')
            ->get();

        $data = [
            'student' => $student,
            'payments' => $payments,
            'total_paid' => $payments->where('status', 'completed')->sum('amount'),
            'pending_amount' => $payments->where('status', 'pending')->sum('amount'),
        ];

        return $this->sendResponse($data, 'Student payments retrieved successfully');
    }

    /**
     * Get payment receipt data
     */
    public function receipt($id)
    {
        $payment = Payment::with(['student', 'batch', 'createdBy'])->find($id);

        if (!$payment) {
            return $this->sendError('Payment not found');
        }

        $receiptData = [
            'payment' => $payment,
            'academy_info' => [
                'name' => 'Parmanand Sports Academy',
                'address' => 'Sports Training & Development Center',
                'email' => 'info@psa-nashik.com',
                'phone' => '+91 98765 43210',
            ],
            'generated_at' => now(),
        ];

        return $this->sendResponse($receiptData, 'Payment receipt retrieved successfully');
    }

    /**
     * Generate receipt number
     */
    private function generateReceiptNumber()
    {
        $prefix = 'PSA' . date('Ymd');
        $lastPayment = Payment::where('receipt_number', 'like', $prefix . '%')
            ->orderBy('receipt_number', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = intval(substr($lastPayment->receipt_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Get students list for dropdown
     */
    public function students()
    {
        $students = Student::select('id', 'name', 'phone', 'student_id')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return $this->sendResponse($students, 'Students retrieved successfully');
    }

    /**
     * Get batches list for dropdown
     */
    public function batches(Request $request)
    {
        $query = Batch::with('sport')->select('id', 'name', 'sport_id');
        
        if ($request->has('sport_id') && !empty($request->sport_id)) {
            $query->where('sport_id', $request->sport_id);
        }
        
        $batches = $query->where('is_active', true)->get();
        return $this->sendResponse($batches, 'Batches retrieved successfully');
    }
}
