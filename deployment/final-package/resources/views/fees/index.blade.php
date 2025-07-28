@extends('layouts.dashboard')

@section('title', 'Fee Management')
@section('page-title', 'Fee Management')
@section('page-description', 'Manage student fees, payments, and outstanding dues')

@section('content')
<div class="p-4 sm:p-6 space-y-6 max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Fee Management</h1>
                <p class="text-gray-400">Manage student fees, payments, and outstanding dues</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <a href="{{ route('fees.export') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors w-full sm:w-auto">
                    <i class="fas fa-file-export"></i>
                    <span>Export Report</span>
                </a>
                <a href="{{ route('fees.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors w-full sm:w-auto">
                    <i class="fas fa-plus"></i>
                    <span>Record Payment</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <!-- Total Collected -->
        <div class="bg-gradient-to-br from-green-600 via-green-700 to-emerald-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-green-100 opacity-90">Total Collected</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">₹{{ number_format($stats['total_collected']) }}</p>
                        <div class="flex items-center">
                            <span class="text-xs text-green-100 opacity-75">All time</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-green-200 transition-all duration-500" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Amount -->
        <div class="bg-gradient-to-br from-orange-600 via-orange-700 to-red-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-orange-100 opacity-90">Pending Amount</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">₹{{ number_format($stats['pending_amount']) }}</p>
                        <div class="flex items-center">
                            <span class="text-xs text-orange-100 opacity-75">{{ $stats['total_students_with_dues'] }} students</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-orange-200 transition-all duration-500" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Month Collection -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-purple-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-blue-100 opacity-90">This Month</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">₹{{ number_format($stats['this_month_collection']) }}</p>
                        <div class="flex items-center">
                            <span class="text-xs text-blue-100 opacity-75">{{ now()->format('M Y') }}</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-blue-200 transition-all duration-500" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collection Rate -->
        <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-purple-100 opacity-90">Collection Rate</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">
                            {{ $stats['total_collected'] + $stats['pending_amount'] > 0 ? round(($stats['total_collected'] / ($stats['total_collected'] + $stats['pending_amount'])) * 100, 1) : 0 }}%
                        </p>
                        <div class="flex items-center">
                            <span class="text-xs text-purple-100 opacity-75">Overall</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-chart-pie text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-purple-200 transition-all duration-500" 
                             style="width: {{ $stats['total_collected'] + $stats['pending_amount'] > 0 ? round(($stats['total_collected'] / ($stats['total_collected'] + $stats['pending_amount'])) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800 rounded-xl shadow-sm border border-gray-700 p-4 sm:p-6 mb-6">
        <form method="GET" action="{{ route('fees.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="sm:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="Search by student name, ID, or email...">
                </div>

                <!-- Status Filter -->
                <div>
                    <select name="status" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Method Filter -->
                <div>
                    <select name="payment_method" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Methods</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method }}" {{ request('payment_method') == $method ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $method)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Batch Filter -->
                <div>
                    <select name="batch_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Batches</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                {{ $batch->name }} ({{ $batch->sport->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div class="flex space-x-2">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-search"></i>
                    <span>Filter</span>
                </button>
                <a href="{{ route('fees.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-times"></i>
                    <span>Clear</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="bg-gray-800 rounded-xl shadow-sm border border-gray-700 overflow-hidden">
        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'payment_date', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-white">
                                    <span>Payment Date</span>
                                    <i class="fas fa-sort text-xs"></i>
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Batch</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'amount', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-white">
                                    <span>Amount</span>
                                    <i class="fas fa-sort text-xs"></i>
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-white">{{ $payment->payment_date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $payment->payment_date->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($payment->student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ $payment->student->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $payment->student->student_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white">{{ $payment->batch ? $payment->batch->name : 'N/A' }}</div>
                                <div class="text-xs text-gray-400">{{ $payment->batch && $payment->batch->sport ? $payment->batch->sport->name : 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white">₹{{ number_format($payment->amount) }}</div>
                                @if($payment->description)
                                    <div class="text-xs text-gray-400">{{ Str::limit($payment->description, 30) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($payment->payment_method === 'cash') bg-green-900/20 text-green-400 border border-green-500/20
                                    @elseif($payment->payment_method === 'card') bg-blue-900/20 text-blue-400 border border-blue-500/20
                                    @elseif($payment->payment_method === 'upi') bg-purple-900/20 text-purple-400 border border-purple-500/20
                                    @else bg-gray-900/20 text-gray-400 border border-gray-500/20
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($payment->status === 'completed')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-900/20 text-green-400 border border-green-500/20">
                                        Completed
                                    </span>
                                @elseif($payment->status === 'pending')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-900/20 text-yellow-400 border border-yellow-500/20">
                                        Pending
                                    </span>
                                @elseif($payment->status === 'failed')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-900/20 text-red-400 border border-red-500/20">
                                        Failed
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-900/20 text-gray-400 border border-gray-500/20">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('fees.show', $payment) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($payment->status === 'pending')
                                        <form method="POST" action="{{ route('fees.mark-completed', $payment) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-400 hover:text-green-300 transition-colors" title="Mark as Completed">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('fees.receipt', $payment) }}" class="text-purple-400 hover:text-purple-300 transition-colors" title="Receipt" target="_blank">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    <a href="{{ route('fees.edit', $payment) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('fees.destroy', $payment) }}" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this payment record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-700">
                {{ $payments->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">No Payments Found</h3>
                <p class="text-gray-400 mb-6">Start by recording your first fee payment.</p>
                <a href="{{ route('fees.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Record Payment
                </a>
            </div>
        @endif
    </div>
</div>
@endsection