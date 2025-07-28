@extends('layouts.dashboard')

@section('title', 'Attendance Details')
@section('page-title', 'Attendance Details')
@section('page-description', 'View attendance record information')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Attendance Details</h1>
                    <p class="mt-2 text-gray-400">View attendance record information</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('attendance.edit', $attendance) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('attendance.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Information -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Student Information -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h2 class="text-xl font-semibold text-white mb-6">Student Information</h2>
                    
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-16 w-16">
                            @if($attendance->student->photo)
                                <img class="h-16 w-16 rounded-full object-cover" 
                                     src="{{ Storage::url($attendance->student->photo) }}" 
                                     alt="{{ $attendance->student->name }}">
                            @else
                                <div class="h-16 w-16 rounded-full bg-purple-600 flex items-center justify-center">
                                    <span class="text-white font-medium text-xl">
                                        {{ substr($attendance->student->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-white">{{ $attendance->student->name }}</h3>
                            <p class="text-gray-400">{{ $attendance->student->email }}</p>
                            <p class="text-gray-400">{{ $attendance->student->phone }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Student ID</label>
                            <p class="text-white">{{ $attendance->student->student_id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Date of Birth</label>
                            <p class="text-white">{{ $attendance->student->date_of_birth ? $attendance->student->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Gender</label>
                            <p class="text-white">{{ $attendance->student->gender ? ucfirst($attendance->student->gender) : 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Emergency Contact</label>
                            <p class="text-white">
                                @if($attendance->student->emergency_contact && is_array($attendance->student->emergency_contact))
                                    {{ $attendance->student->emergency_contact['name'] ?? 'Not provided' }}
                                    @if(isset($attendance->student->emergency_contact['phone']))
                                        <br><span class="text-gray-400 text-sm">{{ $attendance->student->emergency_contact['phone'] }}</span>
                                    @endif
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Batch Information -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h2 class="text-xl font-semibold text-white mb-6">Batch Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Batch Name</label>
                            <p class="text-white font-medium">{{ $attendance->batch->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Sport</label>
                            <p class="text-white">{{ $attendance->batch->sport->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Schedule</label>
                            <p class="text-white">{{ $attendance->batch->schedule }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Capacity</label>
                            <p class="text-white">{{ $attendance->batch->current_students }}/{{ $attendance->batch->max_capacity }}</p>
                        </div>
                    </div>

                    @if($attendance->batch->description)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                            <p class="text-gray-300">{{ $attendance->batch->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Notes -->
                @if($attendance->notes)
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <h2 class="text-xl font-semibold text-white mb-4">Notes</h2>
                        <div class="bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-300">{{ $attendance->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Attendance Status -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Attendance Status</h3>
                    
                    <div class="text-center mb-6">
                        @if($attendance->status === 'present')
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-3">
                                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                            </div>
                            <p class="text-green-400 font-semibold text-lg">Present</p>
                        @elseif($attendance->status === 'absent')
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-3">
                                <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                            </div>
                            <p class="text-red-400 font-semibold text-lg">Absent</p>
                        @else
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-3">
                                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                            </div>
                            <p class="text-yellow-400 font-semibold text-lg">Late</p>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Date</label>
                            <p class="text-white">{{ $attendance->date->format('M d, Y') }}</p>
                            <p class="text-gray-400 text-sm">{{ $attendance->date->format('l') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Marked By</label>
                            <p class="text-white">{{ $attendance->markedBy->name ?? 'System' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Marked At</label>
                            <p class="text-white">{{ $attendance->marked_at ? $attendance->marked_at->format('M d, Y') : 'Not recorded' }}</p>
                            <p class="text-gray-400 text-sm">{{ $attendance->marked_at ? $attendance->marked_at->format('H:i:s') : '' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('attendance.edit', $attendance) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Attendance
                        </a>
                        
                        <a href="{{ route('students.show', $attendance->student) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-user mr-2"></i>
                            View Student
                        </a>
                        
                        <a href="{{ route('batches.show', $attendance->batch) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-users mr-2"></i>
                            View Batch
                        </a>
                        
                        <form action="{{ route('attendance.destroy', $attendance) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-trash mr-2"></i>
                                Delete Record
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Record Information -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Record Information</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Created:</span>
                            <span class="text-white">{{ $attendance->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Updated:</span>
                            <span class="text-white">{{ $attendance->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Record ID:</span>
                            <span class="text-white">#{{ $attendance->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection