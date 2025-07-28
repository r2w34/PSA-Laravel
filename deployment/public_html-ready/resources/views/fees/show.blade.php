@extends('layouts.dashboard')

@section('title', 'Fee Payment Details')
@section('page-title', 'Fee Payment Details')
@section('page-description', 'View complete payment information and history')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Payment Details</h1>
            <p class="text-gray-400">Payment ID: #{{ $fee->id }}</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('fees.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Fees</span>
            </a>
            @if($fee->status !== 'completed')
            <a href="{{ route('fees.edit', $fee) }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-edit"></i>
                <span>Edit Payment</span>
            </a>
            @endif
            <a href="{{ route('fees.receipt', $fee) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-receipt"></i>
                <span>Print Receipt</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Payment Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Details -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Payment Information</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $fee->status === 'completed' ? 'bg-green-100 text-green-800' : 
                           ($fee->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        <i class="fas fa-circle w-2 h-2 mr-2"></i>
                        {{ ucfirst($fee->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Amount</label>
                        <p class="text-2xl font-bold text-white bg-gray-700 px-4 py-3 rounded-lg">₹{{ number_format($fee->amount) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Payment Date</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->payment_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Payment Method</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ ucfirst(str_replace('_', ' ', $fee->payment_method)) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Fee Type</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ ucfirst(str_replace('_', ' ', $fee->fee_type)) }}</p>
                    </div>
                    @if($fee->transaction_id)
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Transaction ID</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg font-mono">{{ $fee->transaction_id }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Due Date</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->due_date ? $fee->due_date->format('M d, Y') : 'Not set' }}</p>
                    </div>
                    @if($fee->notes)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Notes</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Student Information -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Student Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Student Name</label>
                        <div class="flex items-center space-x-3">
                            <p class="text-white bg-gray-700 px-4 py-2 rounded-lg flex-1">{{ $fee->student->name }}</p>
                            <a href="{{ route('students.show', $fee->student) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Student ID</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->student->student_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Phone</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->student->phone }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->student->email ?: 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Batch Information -->
            @if($fee->batch)
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-futbol text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Batch Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Batch Name</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->batch->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Sport</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->batch->sport->name ?? 'Not assigned' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Timing</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->batch->start_time }} - {{ $fee->batch->end_time }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Days</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $fee->batch->days }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Payment History -->
            @if($paymentHistory->count() > 1)
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Payment History</h2>
                </div>

                <div class="space-y-4">
                    @foreach($paymentHistory as $payment)
                    <div class="bg-gray-700 rounded-lg p-4 {{ $payment->id === $fee->id ? 'ring-2 ring-purple-500' : '' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-receipt text-white text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-white font-medium">₹{{ number_format($payment->amount) }}</p>
                                    <p class="text-gray-400 text-sm">{{ $payment->payment_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                                @if($payment->id !== $fee->id)
                                <a href="{{ route('fees.show', $payment) }}" class="text-purple-400 hover:text-purple-300">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @else
                                <span class="text-purple-400">
                                    <i class="fas fa-eye"></i>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Actions Sidebar -->
        <div class="space-y-6">
            <!-- Payment Status -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Status</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white mb-2">₹{{ number_format($fee->amount) }}</div>
                            <div class="text-gray-300 text-sm">Payment Amount</div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Status</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $fee->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($fee->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($fee->status) }}
                            </span>
                        </div>
                    </div>

                    @if($fee->due_date)
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Due Date</span>
                            <span class="text-white font-medium">{{ $fee->due_date->format('M d, Y') }}</span>
                        </div>
                    </div>
                    @endif

                    @if($fee->createdBy)
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="text-gray-300 text-sm mb-1">Created By</div>
                        <div class="text-white font-medium">{{ $fee->createdBy->name }}</div>
                        <div class="text-gray-400 text-xs">{{ $fee->created_at->format('M d, Y g:i A') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    @if($fee->status !== 'completed')
                    <form action="{{ route('fees.mark-completed', $fee) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <i class="fas fa-check"></i>
                            <span>Mark as Paid</span>
                        </button>
                    </form>
                    @endif
                    
                    <a href="{{ route('fees.receipt', $fee) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-receipt"></i>
                        <span>Print Receipt</span>
                    </a>
                    
                    <a href="{{ route('fees.create', ['student_id' => $fee->student_id]) }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Add New Payment</span>
                    </a>
                    
                    <a href="{{ route('students.show', $fee->student) }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-user"></i>
                        <span>View Student</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection