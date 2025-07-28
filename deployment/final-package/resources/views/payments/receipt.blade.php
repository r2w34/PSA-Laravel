@extends('layouts.dashboard')

@section('title', 'Payment Receipt')
@section('page-title', 'Payment Receipt')
@section('page-description', 'Official payment receipt')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Print Button -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('payments.show', $payment) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Payment Details
        </a>
        <button onclick="window.print()" 
                class="inline-flex items-center px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-print mr-2"></i>
            Print Receipt
        </button>
    </div>

    <!-- Receipt -->
    <div id="receipt" class="bg-white text-gray-900 rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-purple-600 text-white p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 11 5.16-1.26 9-5.45 9-11V7l-10-5z"/>
                            <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Parmanand Sports Academy</h1>
                        <p class="text-purple-100">Official Payment Receipt</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-semibold">Receipt #{{ $payment->receipt_number }}</p>
                    <p class="text-purple-100">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Receipt Body -->
        <div class="p-8">
            <!-- Academy Information -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Academy Information</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium">Parmanand Sports Academy</p>
                    <p class="text-gray-600">Sports Training & Development Center</p>
                    <p class="text-gray-600">Email: info@psa-nashik.com</p>
                    <p class="text-gray-600">Phone: +91 98765 43210</p>
                </div>
            </div>

            <!-- Student Information -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Student Information</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Student Name</p>
                            <p class="font-medium">{{ $payment->student->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $payment->student->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="font-medium">{{ $payment->student->phone }}</p>
                        </div>
                        @if($payment->batch)
                        <div>
                            <p class="text-sm text-gray-600">Batch</p>
                            <p class="font-medium">{{ $payment->batch->name }} ({{ $payment->batch->sport->name }})</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Payment Details</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600">Payment Type</p>
                            <p class="font-medium">{{ ucfirst($payment->payment_type) }} Fee</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Payment Method</p>
                            <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Payment Date</p>
                            <p class="font-medium">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-medium">
                                @if($payment->status == 'completed')
                                <span class="text-green-600">✓ Completed</span>
                                @elseif($payment->status == 'pending')
                                <span class="text-yellow-600">⏳ Pending</span>
                                @elseif($payment->status == 'failed')
                                <span class="text-red-600">✗ Failed</span>
                                @elseif($payment->status == 'refunded')
                                <span class="text-gray-600">↩ Refunded</span>
                                @endif
                            </p>
                        </div>
                        @if($payment->transaction_id)
                        <div>
                            <p class="text-sm text-gray-600">Transaction ID</p>
                            <p class="font-medium font-mono">{{ $payment->transaction_id }}</p>
                        </div>
                        @endif
                        @if($payment->month_year)
                        <div>
                            <p class="text-sm text-gray-600">Period</p>
                            <p class="font-medium">{{ $payment->month_year }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Amount Breakdown -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Amount Details</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span>{{ ucfirst($payment->payment_type) }} Fee</span>
                            <span>₹{{ number_format($payment->amount, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-300 pt-2">
                            <div class="flex justify-between items-center font-bold text-lg">
                                <span>Total Amount</span>
                                <span class="text-green-600">₹{{ number_format($payment->amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($payment->description || $payment->notes)
            <!-- Additional Information -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Additional Information</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    @if($payment->description)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600">Description</p>
                        <p class="font-medium">{{ $payment->description }}</p>
                    </div>
                    @endif
                    @if($payment->notes)
                    <div>
                        <p class="text-sm text-gray-600">Notes</p>
                        <p class="font-medium">{{ $payment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Footer -->
            <div class="border-t border-gray-300 pt-6">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div>
                        <p>Generated by: {{ $payment->createdBy ? $payment->createdBy->name : 'System' }}</p>
                        <p>Generated on: {{ now()->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">Thank you for your payment!</p>
                        <p>For queries, contact: info@psa-nashik.com</p>
                    </div>
                </div>
            </div>

            <!-- Signature Section -->
            <div class="mt-8 pt-6 border-t border-gray-300">
                <div class="flex justify-between items-end">
                    <div class="text-center">
                        <div class="w-48 border-b border-gray-400 mb-2"></div>
                        <p class="text-sm text-gray-600">Student Signature</p>
                    </div>
                    <div class="text-center">
                        <div class="w-48 border-b border-gray-400 mb-2"></div>
                        <p class="text-sm text-gray-600">Authorized Signature</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #receipt, #receipt * {
        visibility: visible;
    }
    #receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endsection