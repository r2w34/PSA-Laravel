@extends('layouts.dashboard')

@section('title', 'Edit Attendance')
@section('page-title', 'Edit Attendance')
@section('page-description', 'Update attendance record')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Edit Attendance</h1>
                    <p class="mt-2 text-gray-400">Update attendance record for {{ $attendance->student->name }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('attendance.show', $attendance) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-eye mr-2"></i>
                        View Details
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
            <!-- Edit Form -->
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('attendance.update', $attendance) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Session Information (Read-only) -->
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <h2 class="text-xl font-semibold text-white mb-6">Session Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Student</label>
                                <div class="flex items-center p-3 bg-gray-700 rounded-lg">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($attendance->student->photo)
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ Storage::url($attendance->student->photo) }}" 
                                                 alt="{{ $attendance->student->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center">
                                                <span class="text-white font-medium text-sm">
                                                    {{ substr($attendance->student->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-white font-medium">{{ $attendance->student->name }}</p>
                                        <p class="text-gray-400 text-sm">{{ $attendance->student->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Batch</label>
                                <div class="p-3 bg-gray-700 rounded-lg">
                                    <p class="text-white font-medium">{{ $attendance->batch->name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $attendance->batch->sport->name }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Date</label>
                                <div class="p-3 bg-gray-700 rounded-lg">
                                    <p class="text-white font-medium">{{ $attendance->date->format('M d, Y') }}</p>
                                    <p class="text-gray-400 text-sm">{{ $attendance->date->format('l') }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Current Status</label>
                                <div class="p-3 bg-gray-700 rounded-lg">
                                    @if($attendance->status === 'present')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Present
                                        </span>
                                    @elseif($attendance->status === 'absent')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Absent
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Late
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Attendance -->
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <h2 class="text-xl font-semibold text-white mb-6">Update Attendance</h2>
                        
                        <div class="space-y-6">
                            <!-- Status Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-4">
                                    Attendance Status <span class="text-red-400">*</span>
                                </label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="status" 
                                               value="present" 
                                               class="sr-only"
                                               {{ old('status', $attendance->status) == 'present' ? 'checked' : '' }}>
                                        <div class="attendance-option present flex items-center px-4 py-3 rounded-lg cursor-pointer transition-colors duration-200">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Present
                                        </div>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="status" 
                                               value="absent" 
                                               class="sr-only"
                                               {{ old('status', $attendance->status) == 'absent' ? 'checked' : '' }}>
                                        <div class="attendance-option absent flex items-center px-4 py-3 rounded-lg cursor-pointer transition-colors duration-200">
                                            <i class="fas fa-times-circle mr-2"></i>
                                            Absent
                                        </div>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="status" 
                                               value="late" 
                                               class="sr-only"
                                               {{ old('status', $attendance->status) == 'late' ? 'checked' : '' }}>
                                        <div class="attendance-option late flex items-center px-4 py-3 rounded-lg cursor-pointer transition-colors duration-200">
                                            <i class="fas fa-clock mr-2"></i>
                                            Late
                                        </div>
                                    </label>
                                </div>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">
                                    Notes (Optional)
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="4"
                                          placeholder="Add any additional notes about this attendance record..."
                                          class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes', $attendance->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('attendance.show', $attendance) }}" 
                           class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200">
                            Update Attendance
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Current Record Info -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Current Record</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Record ID:</span>
                            <span class="text-white">#{{ $attendance->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Originally Marked:</span>
                            <span class="text-white">{{ $attendance->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Last Updated:</span>
                            <span class="text-white">{{ $attendance->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Marked By:</span>
                            <span class="text-white">{{ $attendance->markedBy->name ?? 'System' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('attendance.show', $attendance) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>
                            View Details
                        </a>
                        
                        <a href="{{ route('students.show', $attendance->student) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-user mr-2"></i>
                            View Student
                        </a>
                        
                        <a href="{{ route('batches.show', $attendance->batch) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-users mr-2"></i>
                            View Batch
                        </a>
                    </div>
                </div>

                <!-- Help -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Help</h3>
                    
                    <div class="space-y-3 text-sm text-gray-300">
                        <div>
                            <strong class="text-green-400">Present:</strong> Student attended the session on time
                        </div>
                        <div>
                            <strong class="text-red-400">Absent:</strong> Student did not attend the session
                        </div>
                        <div>
                            <strong class="text-yellow-400">Late:</strong> Student attended but arrived late
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.attendance-option {
    @apply bg-gray-600 text-gray-300 border border-gray-500;
}

.attendance-option.present.selected {
    @apply bg-green-600 text-white border-green-500;
}

.attendance-option.absent.selected {
    @apply bg-red-600 text-white border-red-500;
}

.attendance-option.late.selected {
    @apply bg-yellow-600 text-white border-yellow-500;
}
</style>

<script>
function updateAttendanceOption(radio) {
    const options = document.querySelectorAll('.attendance-option');
    options.forEach(option => option.classList.remove('selected'));
    
    if (radio.checked) {
        const option = radio.nextElementSibling;
        option.classList.add('selected');
    }
}

// Initialize attendance options
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateAttendanceOption(this);
        });
        
        // Set initial state
        if (radio.checked) {
            updateAttendanceOption(radio);
        }
    });
});
</script>
@endsection