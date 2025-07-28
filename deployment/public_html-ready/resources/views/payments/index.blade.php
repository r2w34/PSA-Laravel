@extends('layouts.dashboard')

@section('title', 'Payment Management')
@section('page-title', 'Payment Management')
@section('page-description', 'Manage student payments and fee collections')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 bg-opacity-20 rounded-lg">
                    <i class="fas fa-receipt text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Total Payments</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total_payments'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 bg-opacity-20 rounded-lg">
                    <i class="fas fa-rupee-sign text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Total Amount</p>
                    <p class="text-2xl font-bold text-white">₹{{ number_format($stats['total_amount'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 bg-opacity-20 rounded-lg">
                    <i class="fas fa-clock text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['pending_payments'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 bg-opacity-20 rounded-lg">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Completed</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['completed_payments'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-red-500 bg-opacity-20 rounded-lg">
                    <i class="fas fa-times-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Failed</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['failed_payments'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-purple-500 bg-opacity-20 rounded-lg">
                    <i class="fas fa-calendar-alt text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">This Month</p>
                    <p class="text-2xl font-bold text-white">₹{{ number_format($stats['monthly_revenue'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <form method="GET" action="{{ route('payments.index') }}" class="space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-end lg:space-x-4 space-y-4 lg:space-y-0">
                <!-- Search -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by student name, email, phone, receipt number, or transaction ID..."
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Payment Method Filter -->
                <div class="w-full lg:w-48">
                    <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">Payment Method</label>
                    <select id="payment_method" 
                            name="payment_method"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Methods</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="upi" {{ request('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cheque" {{ request('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="online" {{ request('payment_method') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full lg:w-48">
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="status" 
                            name="status"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- Payment Type Filter -->
                <div class="w-full lg:w-48">
                    <label for="payment_type" class="block text-sm font-medium text-gray-300 mb-2">Payment Type</label>
                    <select id="payment_type" 
                            name="payment_type"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="monthly" {{ request('payment_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="registration" {{ request('payment_type') == 'registration' ? 'selected' : '' }}>Registration</option>
                        <option value="tournament" {{ request('payment_type') == 'tournament' ? 'selected' : '' }}>Tournament</option>
                    </select>
                </div>
            </div>

            <!-- Date Range and Amount Range -->
            <div class="flex flex-col lg:flex-row lg:items-end lg:space-x-4 space-y-4 lg:space-y-0">
                <!-- Date From -->
                <div class="w-full lg:w-48">
                    <label for="date_from" class="block text-sm font-medium text-gray-300 mb-2">Date From</label>
                    <input type="date" 
                           id="date_from" 
                           name="date_from" 
                           value="{{ request('date_from') }}"
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Date To -->
                <div class="w-full lg:w-48">
                    <label for="date_to" class="block text-sm font-medium text-gray-300 mb-2">Date To</label>
                    <input type="date" 
                           id="date_to" 
                           name="date_to" 
                           value="{{ request('date_to') }}"
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Amount Min -->
                <div class="w-full lg:w-48">
                    <label for="amount_min" class="block text-sm font-medium text-gray-300 mb-2">Min Amount</label>
                    <input type="number" 
                           id="amount_min" 
                           name="amount_min" 
                           value="{{ request('amount_min') }}"
                           placeholder="0"
                           step="0.01"
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Amount Max -->
                <div class="w-full lg:w-48">
                    <label for="amount_max" class="block text-sm font-medium text-gray-300 mb-2">Max Amount</label>
                    <input type="number" 
                           id="amount_max" 
                           name="amount_max" 
                           value="{{ request('amount_max') }}"
                           placeholder="10000"
                           step="0.01"
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Filter Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('payments.index') }}" 
                       class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
            <a href="{{ route('payments.export', request()->query()) }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export CSV
            </a>
        </div>
        
        <a href="{{ route('payments.create') }}" 
           class="inline-flex items-center px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Add New Payment
        </a>
    </div>

    <!-- Payments Table -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Receipt & Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Amount & Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Payment Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status & Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">
                                            {{ substr($payment->student->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">{{ $payment->receipt_number }}</div>
                                    <div class="text-sm text-gray-300">{{ $payment->student->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $payment->student->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">₹{{ number_format($payment->amount, 2) }}</div>
                            <div class="text-sm text-gray-300">{{ ucfirst($payment->payment_type) }}</div>
                            @if($payment->month_year)
                            <div class="text-xs text-gray-400">{{ $payment->month_year }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>
                            </div>
                            @if($payment->transaction_id)
                            <div class="text-xs text-gray-400 mt-1">{{ $payment->transaction_id }}</div>
                            @endif
                            @if($payment->batch)
                            <div class="text-xs text-gray-400 mt-1">{{ $payment->batch->name }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1">
                                @if($payment->status == 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Completed
                                </span>
                                @elseif($payment->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                                @elseif($payment->status == 'failed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Failed
                                </span>
                                @elseif($payment->status == 'refunded')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-undo mr-1"></i>Refunded
                                </span>
                                @endif
                                <div class="text-xs text-gray-400">
                                    {{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('payments.show', $payment) }}" 
                                   class="text-purple-400 hover:text-purple-300 transition-colors duration-200"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('payments.receipt', $payment) }}" 
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-200"
                                   title="View Receipt">
                                    <i class="fas fa-receipt"></i>
                                </a>
                                <a href="{{ route('payments.edit', $payment) }}" 
                                   class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200"
                                   title="Edit Payment">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('payments.destroy', $payment) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this payment record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300 transition-colors duration-200"
                                            title="Delete Payment">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-credit-card text-gray-400 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-300 mb-2">No payments found</h3>
                                <p class="text-gray-400 mb-4">Get started by adding your first payment record.</p>
                                <a href="{{ route('payments.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Payment
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($payments->hasPages())
        <div class="bg-gray-900 px-6 py-3 border-t border-gray-700">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection