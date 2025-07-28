@extends('layouts.dashboard')

@section('title', 'Coach Dashboard')
@section('page-title', 'Coach Dashboard')
@section('page-description', 'Manage your batches and track student progress')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- My Batches -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">My Batches</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['my_batches']) }}</p>
                    <p class="text-blue-400 text-sm mt-1">
                        <i class="fas fa-users"></i>
                        Active groups
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-layer-group text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- My Students -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">My Students</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['my_students']) }}</p>
                    <p class="text-green-400 text-sm mt-1">
                        <i class="fas fa-arrow-up"></i>
                        Under training
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Today's Sessions -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Today's Sessions</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['todays_sessions']) }}</p>
                    <p class="text-purple-400 text-sm mt-1">
                        <i class="fas fa-calendar"></i>
                        Scheduled
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-day text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Attendance Today -->
        <div class="stat-card card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Attendance Today</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['attendance_today']) }}</p>
                    <p class="text-yellow-400 text-sm mt-1">
                        <i class="fas fa-check-circle"></i>
                        Marked
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-yellow-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card p-6">
        <h3 class="text-xl font-semibold text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button class="btn-primary text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2">
                <i class="fas fa-clipboard-check"></i>
                <span>Mark Attendance</span>
            </button>
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Add Session Notes</span>
            </button>
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-chart-line"></i>
                <span>Student Progress</span>
            </button>
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-calendar-plus"></i>
                <span>Schedule Makeup</span>
            </button>
        </div>
    </div>

    <!-- My Batches & Students -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- My Batches -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">My Batches</h3>
                <span class="text-purple-400 text-sm">{{ $batches->count() }} total</span>
            </div>
            
            @if($batches->count() > 0)
                <div class="space-y-4">
                    @foreach($batches as $batch)
                    <div class="p-4 rounded-lg bg-slate-700 bg-opacity-50 border-l-4 border-purple-500">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-white font-medium">{{ $batch->name }}</h4>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-800 text-green-100">
                                {{ $batch->students->count() }} students
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-400">Sport</p>
                                <p class="text-white">{{ $batch->sport->name ?? 'Not assigned' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Schedule</p>
                                <p class="text-white">{{ $batch->schedule_day ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Time</p>
                                <p class="text-white">{{ $batch->schedule_time ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Status</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($batch->status === 'active') bg-green-800 text-green-100
                                    @else bg-gray-800 text-gray-100 @endif">
                                    {{ ucfirst($batch->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-3 flex space-x-2">
                            <button class="text-purple-400 hover:text-purple-300 text-sm font-medium">View Details</button>
                            <button class="text-blue-400 hover:text-blue-300 text-sm font-medium">Mark Attendance</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-layer-group text-gray-500 text-3xl mb-3"></i>
                    <p class="text-gray-400">No batches assigned</p>
                    <p class="text-gray-500 text-sm">Contact admin to get batch assignments</p>
                </div>
            @endif
        </div>

        <!-- Recent Students -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">My Students</h3>
                <span class="text-green-400 text-sm">{{ $students->count() }} total</span>
            </div>
            
            @if($students->count() > 0)
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach($students->take(8) as $student)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-700 bg-opacity-50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ substr($student->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $student->name }}</p>
                                <p class="text-gray-400 text-sm">{{ $student->batch->name ?? 'No batch' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($student->status === 'active') bg-green-800 text-green-100
                                @elseif($student->status === 'inactive') bg-red-800 text-red-100
                                @else bg-yellow-800 text-yellow-100 @endif">
                                {{ ucfirst($student->status) }}
                            </span>
                            <p class="text-gray-400 text-xs mt-1">ID: {{ $student->student_id }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($students->count() > 8)
                    <div class="text-center pt-4">
                        <button class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                            View All Students ({{ $students->count() - 8 }} more)
                        </button>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-500 text-3xl mb-3"></i>
                    <p class="text-gray-400">No students assigned</p>
                    <p class="text-gray-500 text-sm">Students will appear here once batches are assigned</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-white">Today's Schedule</h3>
            <span class="text-purple-400 text-sm">{{ now()->format('l, F j, Y') }}</span>
        </div>
        
        @php
            $todaysBatches = $batches->where('schedule_day', now()->format('l'));
        @endphp
        
        @if($todaysBatches->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($todaysBatches as $batch)
                <div class="p-4 rounded-lg bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold">{{ $batch->name }}</h4>
                        <i class="fas fa-clock text-purple-200"></i>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-purple-200">Time:</span>
                            <span>{{ $batch->schedule_time ?? 'Not set' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-purple-200">Students:</span>
                            <span>{{ $batch->students->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-purple-200">Sport:</span>
                            <span>{{ $batch->sport->name ?? 'General' }}</span>
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-2">
                        <button class="flex-1 bg-white bg-opacity-20 hover:bg-opacity-30 px-3 py-2 rounded text-sm font-medium transition-colors">
                            Mark Attendance
                        </button>
                        <button class="px-3 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded text-sm transition-colors">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-gray-500 text-4xl mb-4"></i>
                <p class="text-gray-400 text-lg">No sessions scheduled for today</p>
                <p class="text-gray-500 text-sm">Enjoy your day off!</p>
            </div>
        @endif
    </div>
</div>
@endsection