@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')
@section('page-description', 'Overview of your sports academy management system')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Students -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Students</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['total_students']) }}</p>
                    <p class="text-green-400 text-sm mt-1">
                        <i class="fas fa-arrow-up"></i>
                        {{ $stats['active_students'] }} active
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Coaches -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Coaches</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['total_coaches']) }}</p>
                    <p class="text-purple-400 text-sm mt-1">
                        <i class="fas fa-user-tie"></i>
                        Professional staff
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tie text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold text-white mt-2">₹{{ number_format($stats['total_revenue']) }}</p>
                    <p class="text-yellow-400 text-sm mt-1">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ $stats['pending_payments'] }} pending
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- New Inquiries -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">New Inquiries</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['recent_inquiries']) }}</p>
                    <p class="text-orange-400 text-sm mt-1">
                        <i class="fas fa-clock"></i>
                        Needs follow-up
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-question-circle text-orange-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Sports & Batches</h3>
                <i class="fas fa-futbol text-purple-400"></i>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-400">Total Sports</span>
                    <span class="text-white font-medium">{{ $stats['total_sports'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Active Batches</span>
                    <span class="text-white font-medium">{{ $stats['total_batches'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Avg. Students/Batch</span>
                    <span class="text-white font-medium">{{ $stats['total_batches'] > 0 ? round($stats['total_students'] / $stats['total_batches'], 1) : 0 }}</span>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Payment Status</h3>
                <i class="fas fa-credit-card text-green-400"></i>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-400">Completed</span>
                    <span class="text-green-400 font-medium">₹{{ number_format($stats['total_revenue']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Pending</span>
                    <span class="text-yellow-400 font-medium">{{ $stats['pending_payments'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Collection Rate</span>
                    <span class="text-white font-medium">{{ $stats['pending_payments'] > 0 ? round(($stats['total_revenue'] / ($stats['total_revenue'] + $stats['pending_payments'])) * 100, 1) : 100 }}%</span>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Quick Actions</h3>
                <i class="fas fa-bolt text-yellow-400"></i>
            </div>
            <div class="space-y-3">
                <button class="w-full btn-primary text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>Add New Student
                </button>
                <button class="w-full bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-calendar-plus mr-2"></i>Schedule Session
                </button>
                <button class="w-full bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-file-invoice mr-2"></i>Generate Report
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Payments -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Recent Activities</h3>
                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View All</a>
            </div>
            
            @if($recentActivities->count() > 0)
                <div class="space-y-4">
                    @foreach($recentActivities->take(5) as $activity)
                    <div class="flex items-start space-x-3 p-3 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="w-8 h-8 bg-purple-500 bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-purple-400 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm">
                                <span class="font-medium">{{ $activity->user->name ?? 'System' }}</span>
                                {{ $activity->description }}
                            </p>
                            <p class="text-gray-400 text-xs mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-history text-gray-500 text-3xl mb-3"></i>
                    <p class="text-gray-400">No recent activities</p>
                </div>
            @endif
        </div>

        <!-- Recent Payments -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Recent Payments</h3>
                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View All</a>
            </div>
            
            @if($recentPayments->count() > 0)
                <div class="space-y-4">
                    @foreach($recentPayments as $payment)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-500 bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="fas fa-rupee-sign text-green-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">{{ $payment->student->name ?? 'Unknown Student' }}</p>
                                <p class="text-gray-400 text-xs">{{ $payment->batch->name ?? 'General' }} - {{ $payment->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-medium">₹{{ number_format($payment->amount) }}</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($payment->status === 'completed') bg-green-800 text-green-100
                                @elseif($payment->status === 'pending') bg-yellow-800 text-yellow-100
                                @else bg-red-800 text-red-100 @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-credit-card text-gray-500 text-3xl mb-3"></i>
                    <p class="text-gray-400">No recent payments</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Performance Chart Placeholder -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-white">Academy Performance</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 bg-purple-600 text-white rounded-lg text-sm">7 Days</button>
                <button class="px-3 py-1 bg-slate-700 text-gray-300 rounded-lg text-sm">30 Days</button>
                <button class="px-3 py-1 bg-slate-700 text-gray-300 rounded-lg text-sm">90 Days</button>
            </div>
        </div>
        
        <div class="h-64 bg-slate-700 bg-opacity-30 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-chart-line text-gray-500 text-4xl mb-4"></i>
                <p class="text-gray-400 text-lg">Performance Chart</p>
                <p class="text-gray-500 text-sm">Chart integration coming soon</p>
            </div>
        </div>
    </div>
</div>
@endsection