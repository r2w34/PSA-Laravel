@extends('layouts.dashboard')

@section('title', 'Mark Attendance')
@section('page-title', 'Mark Attendance')
@section('page-description', 'Record student attendance for batch sessions')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Mark Attendance</h1>
                    <p class="mt-2 text-gray-400">Record student attendance for batch sessions</p>
                </div>
                <a href="{{ route('attendance.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Attendance
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('attendance.store') }}" class="space-y-8">
            @csrf

            <!-- Batch and Date Selection -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <h2 class="text-xl font-semibold text-white mb-6">Session Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-300 mb-2">
                            Select Batch <span class="text-red-400">*</span>
                        </label>
                        <select id="batch_id" 
                                name="batch_id" 
                                required
                                onchange="loadStudents()"
                                class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('batch_id') border-red-500 @enderror">
                            <option value="">Choose a batch...</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" 
                                        {{ (old('batch_id', request('batch_id')) == $batch->id) ? 'selected' : '' }}>
                                    {{ $batch->name }} - {{ $batch->sport->name }} ({{ $batch->students->count() }} students)
                                </option>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-300 mb-2">
                            Date <span class="text-red-400">*</span>
                        </label>
                        <input type="date" 
                               id="date" 
                               name="date" 
                               value="{{ old('date', $date) }}"
                               required
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('date') border-red-500 @enderror">
                        @error('date')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Students List -->
            <div id="students-section" class="bg-gray-800 rounded-xl p-6 border border-gray-700" style="{{ $students->isEmpty() ? 'display: none;' : '' }}">
                <h2 class="text-xl font-semibold text-white mb-6">Mark Attendance</h2>
                
                <div id="students-list">
                    @if($students->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($students as $student)
                                <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg border border-gray-600">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if($student->photo)
                                                <img class="h-12 w-12 rounded-full object-cover" 
                                                     src="{{ Storage::url($student->photo) }}" 
                                                     alt="{{ $student->name }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-purple-600 flex items-center justify-center">
                                                    <span class="text-white font-medium">
                                                        {{ substr($student->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-white font-medium">{{ $student->name }}</div>
                                            <div class="text-gray-400 text-sm">{{ $student->email }}</div>
                                            <div class="text-gray-400 text-sm">{{ $student->phone }}</div>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-6">
                                        <!-- Attendance Status -->
                                        <div class="flex items-center space-x-4">
                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="attendance[{{ $student->id }}]" 
                                                       value="present" 
                                                       class="sr-only"
                                                       {{ old("attendance.{$student->id}") == 'present' ? 'checked' : '' }}>
                                                <div class="attendance-option present flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors duration-200">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    Present
                                                </div>
                                            </label>

                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="attendance[{{ $student->id }}]" 
                                                       value="absent" 
                                                       class="sr-only"
                                                       {{ old("attendance.{$student->id}") == 'absent' ? 'checked' : '' }}>
                                                <div class="attendance-option absent flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors duration-200">
                                                    <i class="fas fa-times-circle mr-2"></i>
                                                    Absent
                                                </div>
                                            </label>

                                            <label class="flex items-center">
                                                <input type="radio" 
                                                       name="attendance[{{ $student->id }}]" 
                                                       value="late" 
                                                       class="sr-only"
                                                       {{ old("attendance.{$student->id}") == 'late' ? 'checked' : '' }}>
                                                <div class="attendance-option late flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors duration-200">
                                                    <i class="fas fa-clock mr-2"></i>
                                                    Late
                                                </div>
                                            </label>
                                        </div>

                                        <!-- Notes -->
                                        <div class="w-48">
                                            <input type="text" 
                                                   name="notes[{{ $student->id }}]" 
                                                   placeholder="Notes (optional)"
                                                   value="{{ old("notes.{$student->id}") }}"
                                                   class="w-full px-3 py-2 bg-gray-600 border border-gray-500 rounded-lg text-white text-sm placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Bulk Actions -->
                        <div class="mt-6 p-4 bg-gray-700 rounded-lg border border-gray-600">
                            <h3 class="text-white font-medium mb-3">Quick Actions</h3>
                            <div class="flex space-x-4">
                                <button type="button" 
                                        onclick="markAll('present')"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Mark All Present
                                </button>
                                <button type="button" 
                                        onclick="markAll('absent')"
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Mark All Absent
                                </button>
                                <button type="button" 
                                        onclick="clearAll()"
                                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Clear All
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('attendance.index') }}" 
                               class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200">
                                Save Attendance
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </form>
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
function loadStudents() {
    const batchId = document.getElementById('batch_id').value;
    const date = document.getElementById('date').value;
    
    if (batchId) {
        window.location.href = `{{ route('attendance.create') }}?batch_id=${batchId}&date=${date}`;
    } else {
        document.getElementById('students-section').style.display = 'none';
    }
}

function markAll(status) {
    const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
    radios.forEach(radio => {
        radio.checked = true;
        updateAttendanceOption(radio);
    });
}

function clearAll() {
    const radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        radio.checked = false;
        updateAttendanceOption(radio);
    });
}

function updateAttendanceOption(radio) {
    const options = radio.closest('.flex').querySelectorAll('.attendance-option');
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