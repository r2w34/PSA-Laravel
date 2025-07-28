<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['student', 'batch', 'createdBy']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })->orWhere('receipt_number', 'like', "%{$search}%")
              ->orWhere('transaction_id', 'like', "%{$search}%");
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment type
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        // Filter by amount range
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        $payments = $query->orderBy('payment_date', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total_payments' => Payment::count(),
            'total_amount' => Payment::where('status', 'completed')->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'completed_payments' => Payment::where('status', 'completed')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'monthly_revenue' => Payment::where('status', 'completed')
                ->whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount'),
        ];

        return view('payments.index', compact('payments', 'stats'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        $batches = Batch::with('sport')->orderBy('name')->get();
        
        return view('payments.create', compact('students', 'batches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'batch_id' => 'nullable|exists:batches,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:monthly,registration,tournament',
            'payment_method' => 'required|in:cash,card,upi,bank_transfer,cheque,online',
            'status' => 'required|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'due_date' => 'nullable|date',
            'month_year' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ]);

        // Generate receipt number
        $validated['receipt_number'] = $this->generateReceiptNumber();
        $validated['created_by'] = Auth::id();

        $payment = Payment::create($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment record created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['student', 'batch.sport', 'createdBy']);
        
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $students = Student::orderBy('name')->get();
        $batches = Batch::with('sport')->orderBy('name')->get();
        
        return view('payments.edit', compact('payment', 'students', 'batches'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'batch_id' => 'nullable|exists:batches,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:monthly,registration,tournament',
            'payment_method' => 'required|in:cash,card,upi,bank_transfer,cheque,online',
            'status' => 'required|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'due_date' => 'nullable|date',
            'month_year' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment record updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment record deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Payment::with(['student', 'batch']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })->orWhere('receipt_number', 'like', "%{$search}%")
              ->orWhere('transaction_id', 'like', "%{$search}%");
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $payments = $query->orderBy('payment_date', 'desc')->get();

        $filename = 'payments_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Receipt Number',
                'Student Name',
                'Student Email',
                'Student Phone',
                'Batch',
                'Amount',
                'Payment Type',
                'Payment Method',
                'Status',
                'Transaction ID',
                'Payment Date',
                'Due Date',
                'Month/Year',
                'Description',
                'Notes',
                'Created By',
                'Created At'
            ]);

            // CSV data
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->receipt_number,
                    $payment->student->name,
                    $payment->student->email,
                    $payment->student->phone,
                    $payment->batch ? $payment->batch->name : 'N/A',
                    $payment->amount,
                    ucfirst($payment->payment_type),
                    ucfirst(str_replace('_', ' ', $payment->payment_method)),
                    ucfirst($payment->status),
                    $payment->transaction_id,
                    $payment->payment_date ? $payment->payment_date->format('Y-m-d H:i:s') : '',
                    $payment->due_date ? $payment->due_date->format('Y-m-d H:i:s') : '',
                    $payment->month_year,
                    $payment->description,
                    $payment->notes,
                    $payment->createdBy ? $payment->createdBy->name : 'N/A',
                    $payment->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['student', 'batch.sport', 'createdBy']);
        
        return view('payments.receipt', compact('payment'));
    }

    private function generateReceiptNumber()
    {
        $prefix = 'PSA';
        $year = now()->format('Y');
        $month = now()->format('m');
        
        // Get the last receipt number for this month
        $lastPayment = Payment::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('receipt_number')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastPayment && $lastPayment->receipt_number) {
            // Extract the sequence number from the last receipt
            $lastNumber = (int) substr($lastPayment->receipt_number, -4);
            $sequence = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $sequence = '0001';
        }

        return $prefix . $year . $month . $sequence;
    }
}