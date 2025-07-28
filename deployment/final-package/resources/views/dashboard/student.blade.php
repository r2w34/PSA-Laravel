@extends('layouts.dashboard')

@section('title', 'Student Dashboard')
@section('page-title', 'Student Dashboard')
@section('page-description', 'Track your progress and manage your training')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="card-gradient card p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Welcome back, {{ $student->name }}!</h2>
                <p class="text-purple-100">Ready for your next training session?</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-dumbbell text-6xl text-purple-200 opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- My Batch -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">My Batch</p>
                    <p class="text-xl font-bold text-white mt-2">{{ $stats['my_batch'] }}</p>
                    <p class="text-blue-400 text-sm mt-1">
                        <i class="fas fa-users"></i>
                        Training group
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-layer-group text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Sport -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Sport</p>
                    <p class="text-xl font-bold text-white mt-2">{{ $stats['sport'] }}</p>
                    <p class="text-green-400 text-sm mt-1">
                        <i class="fas fa-futbol"></i>
                        Specialization
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-medal text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Attendance Rate -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Attendance Rate</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $stats['attendance_rate'] }}%</p>
                    <p class="text-purple-400 text-sm mt-1">
                        <i class="fas fa-chart-line"></i>
                        Performance
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-percentage text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Fees -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Pending Fees</p>
                    <p class="text-2xl font-bold text-white mt-2">₹{{ number_format($stats['pending_fees']) }}</p>
                    <p class="text-yellow-400 text-sm mt-1">
                        <i class="fas fa-exclamation-triangle"></i>
                        Due amount
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-yellow-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Training Info & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Training Information -->
        <div class="lg:col-span-2 card p-6">
            <h3 class="text-xl font-semibold text-white mb-6">Training Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="p-4 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="flex items-center space-x-3 mb-3">
                            <i class="fas fa-user-tie text-purple-400"></i>
                            <h4 class="text-white font-medium">Coach Details</h4>
                        </div>
                        <p class="text-gray-300">{{ $stats['coach'] }}</p>
                        <p class="text-gray-400 text-sm mt-1">Your training instructor</p>
                    </div>
                    
                    <div class="p-4 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="flex items-center space-x-3 mb-3">
                            <i class="fas fa-calendar text-blue-400"></i>
                            <h4 class="text-white font-medium">Schedule</h4>
                        </div>
                        <p class="text-gray-300">{{ $student->batch->schedule_day ?? 'Not set' }}</p>
                        <p class="text-gray-400 text-sm mt-1">{{ $student->batch->schedule_time ?? 'Time not set' }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="p-4 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="flex items-center space-x-3 mb-3">
                            <i class="fas fa-id-card text-green-400"></i>
                            <h4 class="text-white font-medium">Student ID</h4>
                        </div>
                        <p class="text-gray-300 font-mono">{{ $student->student_id }}</p>
                        <p class="text-gray-400 text-sm mt-1">Your unique identifier</p>
                    </div>
                    
                    <div class="p-4 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="flex items-center space-x-3 mb-3">
                            <i class="fas fa-info-circle text-yellow-400"></i>
                            <h4 class="text-white font-medium">Status</h4>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($student->status === 'active') bg-green-800 text-green-100
                            @elseif($student->status === 'inactive') bg-red-800 text-red-100
                            @else bg-yellow-800 text-yellow-100 @endif">
                            {{ ucfirst($student->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card p-6">
            <h3 class="text-xl font-semibold text-white mb-6">Quick Actions</h3>
            <div class="space-y-3">
                <button class="w-full btn-primary text-white px-4 py-3 rounded-lg font-medium flex items-center justify-center space-x-2">
                    <i class="fas fa-credit-card"></i>
                    <span>Pay Fees</span>
                </button>
                <button class="w-full bg-slate-700 hover:bg-slate-600 text-white px-4 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-calendar-check"></i>
                    <span>View Attendance</span>
                </button>
                <button class="w-full bg-slate-700 hover:bg-slate-600 text-white px-4 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-chart-line"></i>
                    <span>Progress Report</span>
                </button>
                <button class="w-full bg-slate-700 hover:bg-slate-600 text-white px-4 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-certificate"></i>
                    <span>Certificates</span>
                </button>
                <button class="w-full bg-slate-700 hover:bg-slate-600 text-white px-4 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-phone"></i>
                    <span>Contact Coach</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Attendance & Payment History -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Attendance -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Recent Attendance</h3>
                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View All</a>
            </div>
            
            @if($recentAttendance->count() > 0)
                <div class="space-y-3">
                    @foreach($recentAttendance as $attendance)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                @if($attendance->status === 'present') bg-green-500 bg-opacity-20
                                @elseif($attendance->status === 'absent') bg-red-500 bg-opacity-20
                                @else bg-yellow-500 bg-opacity-20 @endif">
                                <i class="fas 
                                    @if($attendance->status === 'present') fa-check text-green-400
                                    @elseif($attendance->status === 'absent') fa-times text-red-400
                                    @else fa-clock text-yellow-400 @endif text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">{{ $attendance->date->format('M d, Y') }}</p>
                                <p class="text-gray-400 text-xs">{{ $attendance->batch->name ?? 'General Session' }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($attendance->status === 'present') bg-green-800 text-green-100
                            @elseif($attendance->status === 'absent') bg-red-800 text-red-100
                            @else bg-yellow-800 text-yellow-100 @endif">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-calendar-times text-gray-500 text-3xl mb-3"></i>
                    <p class="text-gray-400">No attendance records</p>
                    <p class="text-gray-500 text-sm">Attendance will appear here after sessions</p>
                </div>
            @endif
        </div>

        <!-- Payment History -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Payment History</h3>
                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View All</a>
            </div>
            
            @if($payments->count() > 0)
                <div class="space-y-3">
                    @foreach($payments as $payment)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-500 bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="fas fa-rupee-sign text-green-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">₹{{ number_format($payment->amount) }}</p>
                                <p class="text-gray-400 text-xs">{{ $payment->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($payment->status === 'completed') bg-green-800 text-green-100
                                @elseif($payment->status === 'pending') bg-yellow-800 text-yellow-100
                                @else bg-red-800 text-red-100 @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                            <p class="text-gray-400 text-xs mt-1">{{ $payment->payment_method ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-credit-card text-gray-500 text-3xl mb-3"></i>
                    <p class="text-gray-400">No payment history</p>
                    <p class="text-gray-500 text-sm">Payment records will appear here</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Progress Chart -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-white">My Progress</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 bg-purple-600 text-white rounded-lg text-sm">Attendance</button>
                <button class="px-3 py-1 bg-slate-700 text-gray-300 rounded-lg text-sm">Performance</button>
            </div>
        </div>
        
        <div class="h-48 bg-slate-700 bg-opacity-30 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl font-bold">{{ $stats['attendance_rate'] }}%</span>
                </div>
                <p class="text-gray-400 text-lg">Attendance Rate</p>
                <p class="text-gray-500 text-sm">Keep up the great work!</p>
            </div>
        </div>
    </div>
</div>
@endsection