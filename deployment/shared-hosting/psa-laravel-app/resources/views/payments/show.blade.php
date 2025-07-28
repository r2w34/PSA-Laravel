@extends('layouts.dashboard')

@section('title', 'Payment Details')
@section('page-title', 'Payment Details')
@section('page-description', 'View payment information and receipt')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-800 border border-green-600 text-green-200 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Payment Details Card -->
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Payment Receipt</h2>
                <p class="text-gray-400">Receipt #{{ $payment->receipt_number }}</p>
            </div>
            <div class="flex items-center space-x-2">
                @if($payment->status == 'completed')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-1"></i>Completed
                </span>
                @elseif($payment->status == 'pending')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <i class="fas fa-clock mr-1"></i>Pending
                </span>
                @elseif($payment->status == 'failed')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    <i class="fas fa-times-circle mr-1"></i>Failed
                </span>
                @elseif($payment->status == 'refunded')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                    <i class="fas fa-undo mr-1"></i>Refunded
                </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Student Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2">Student Information</h3>
                
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-12 w-12">
                        <div class="h-12 w-12 rounded-full bg-purple-500 flex items-center justify-center">
                            <span class="text-lg font-medium text-white">
                                {{ substr($payment->student->name, 0, 1) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <p class="text-lg font-medium text-white">{{ $payment->student->name }}</p>
                        <p class="text-sm text-gray-400">{{ $payment->student->email }}</p>
                        <p class="text-sm text-gray-400">{{ $payment->student->phone }}</p>
                    </div>
                </div>

                @if($payment->batch)
                <div>
                    <p class="text-sm font-medium text-gray-300">Batch</p>
                    <p class="text-white">{{ $payment->batch->name }}</p>
                    <p class="text-sm text-gray-400">{{ $payment->batch->sport->name }}</p>
                </div>
                @endif
            </div>

            <!-- Payment Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2">Payment Information</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-300">Amount</p>
                        <p class="text-2xl font-bold text-green-400">₹{{ number_format($payment->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-300">Payment Type</p>
                        <p class="text-white">{{ ucfirst($payment->payment_type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-300">Payment Method</p>
                        <p class="text-white">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-300">Payment Date</p>
                        <p class="text-white">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                </div>

                @if($payment->transaction_id)
                <div>
                    <p class="text-sm font-medium text-gray-300">Transaction ID</p>
                    <p class="text-white font-mono">{{ $payment->transaction_id }}</p>
                </div>
                @endif

                @if($payment->due_date)
                <div>
                    <p class="text-sm font-medium text-gray-300">Due Date</p>
                    <p class="text-white">{{ $payment->due_date->format('M d, Y H:i') }}</p>
                </div>
                @endif

                @if($payment->month_year)
                <div>
                    <p class="text-sm font-medium text-gray-300">Month/Year</p>
                    <p class="text-white">{{ $payment->month_year }}</p>
                </div>
                @endif
            </div>
        </div>

        @if($payment->description || $payment->notes)
        <div class="mt-6 pt-6 border-t border-gray-600">
            @if($payment->description)
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-300">Description</p>
                <p class="text-white">{{ $payment->description }}</p>
            </div>
            @endif

            @if($payment->notes)
            <div>
                <p class="text-sm font-medium text-gray-300">Notes</p>
                <p class="text-white">{{ $payment->notes }}</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Created By Information -->
        <div class="mt-6 pt-6 border-t border-gray-600">
            <div class="flex items-center justify-between text-sm text-gray-400">
                <div>
                    <span>Created by: {{ $payment->createdBy ? $payment->createdBy->name : 'N/A' }}</span>
                </div>
                <div>
                    <span>Created on: {{ $payment->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
            <a href="{{ route('payments.index') }}" 
               class="inline-flex items-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Payments
            </a>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('payments.receipt', $payment) }}" 
               class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-receipt mr-2"></i>
                View Receipt
            </a>
            <a href="{{ route('payments.edit', $payment) }}" 
               class="inline-flex items-center px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Payment
            </a>
            <form action="{{ route('payments.destroy', $payment) }}" 
                  method="POST" 
                  class="inline"
                  onsubmit="return confirm('Are you sure you want to delete this payment record? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Payment
                </button>
            </form>
        </div>
    </div>

    <!-- Payment History (if needed) -->
    @if($payment->student->payments->count() > 1)
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <h3 class="text-lg font-semibold text-white mb-4">Other Payments by {{ $payment->student->name }}</h3>
        <div class="space-y-3">
            @foreach($payment->student->payments->where('id', '!=', $payment->id)->take(5) as $otherPayment)
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="text-sm">
                        <p class="text-white font-medium">{{ $otherPayment->receipt_number }}</p>
                        <p class="text-gray-400">{{ ucfirst($otherPayment->payment_type) }} - {{ $otherPayment->payment_date ? $otherPayment->payment_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-green-400 font-medium">₹{{ number_format($otherPayment->amount, 2) }}</span>
                    <a href="{{ route('payments.show', $otherPayment) }}" 
                       class="text-purple-400 hover:text-purple-300 transition-colors duration-200">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection