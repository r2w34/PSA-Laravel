@extends('layouts.dashboard')

@section('title', $batch->name . ' - Batch Details')
@section('page-title', $batch->name)
@section('page-description', 'View batch details, student enrollment, and manage training sessions')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $batch->name }}</h1>
            <p class="text-gray-400">{{ $batch->sport->name }} batch management</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('batches.edit', $batch) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-edit"></i>
                <span>Edit Batch</span>
            </a>
            <a href="{{ route('batches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Batches</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Enrolled Students -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Enrolled Students</p>
                    <p class="text-3xl font-bold">{{ $batch->current_students }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Available Spots -->
        <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Available Spots</p>
                    <p class="text-3xl font-bold">{{ $batch->max_capacity - $batch->current_students }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Capacity Utilization -->
        <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Capacity</p>
                    <p class="text-3xl font-bold">{{ $batch->max_capacity > 0 ? round(($batch->current_students / $batch->max_capacity) * 100) : 0 }}%</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-gradient-to-br from-{{ $batch->is_active ? 'green' : 'red' }}-600 to-{{ $batch->is_active ? 'green' : 'red' }}-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-{{ $batch->is_active ? 'green' : 'red' }}-100 text-sm font-medium">Status</p>
                    <p class="text-2xl font-bold">{{ $batch->is_active ? 'Active' : 'Inactive' }}</p>
                </div>
                <div class="w-12 h-12 bg-{{ $batch->is_active ? 'green' : 'red' }}-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-{{ $batch->is_active ? 'check-circle' : 'times-circle' }} text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Batch Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Batch Information</h2>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Batch Name</label>
                            <p class="text-white text-lg font-medium">{{ $batch->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Sport</label>
                            <p class="text-white text-lg font-medium">{{ $batch->sport->name }}</p>
                        </div>
                    </div>

                    @if($batch->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                        <p class="text-gray-300 leading-relaxed">{{ $batch->description }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Coach</label>
                            @if($batch->coach)
                                <p class="text-white">{{ $batch->coach->name }}</p>
                                <p class="text-gray-400 text-sm">{{ $batch->coach->specialization }}</p>
                            @else
                                <p class="text-gray-500">No coach assigned</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Capacity</label>
                            <p class="text-white">{{ $batch->current_students }} / {{ $batch->max_capacity }} students</p>
                            <div class="w-full bg-gray-600 rounded-full h-2 mt-1">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $batch->max_capacity > 0 ? ($batch->current_students / $batch->max_capacity) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>

                    @if($batch->schedule || ($batch->start_time && $batch->end_time))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($batch->schedule)
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Schedule</label>
                            <p class="text-white">{{ $batch->schedule }}</p>
                        </div>
                        @endif
                        @if($batch->start_time && $batch->end_time)
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Timing</label>
                            <p class="text-white">
                                {{ \Carbon\Carbon::parse($batch->start_time)->format('g:i A') }} - 
                                {{ \Carbon\Carbon::parse($batch->end_time)->format('g:i A') }}
                            </p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Created Date</label>
                            <p class="text-gray-300">{{ $batch->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Last Updated</label>
                            <p class="text-gray-300">{{ $batch->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Students -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Enrolled Students</h2>
                    </div>
                    <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View All</a>
                </div>

                @if($batch->students->count() > 0)
                <div class="space-y-3">
                    @foreach($batch->students->take(5) as $student)
                    <div class="bg-gray-700 border border-gray-600 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                @if($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr($student->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-white font-medium">{{ $student->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $student->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $student->is_active ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $student->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <a href="{{ route('students.show', $student) }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($batch->students->count() > 5)
                    <div class="text-center pt-4">
                        <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                            View {{ $batch->students->count() - 5 }} more students
                        </a>
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-500 text-4xl mb-4"></i>
                    <p class="text-gray-400">No students enrolled yet</p>
                    <p class="text-gray-500 text-sm">Students will appear here once they enroll in this batch</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Quick Actions</h2>
                </div>

                <div class="space-y-3">
                    <a href="#" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors">
                        <i class="fas fa-user-plus"></i>
                        <span>Enroll Student</span>
                    </a>
                    <a href="{{ route('batches.edit', $batch) }}" class="w-full bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors">
                        <i class="fas fa-edit"></i>
                        <span>Edit Batch Details</span>
                    </a>
                    <a href="#" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors">
                        <i class="fas fa-calendar-check"></i>
                        <span>Mark Attendance</span>
                    </a>
                    <button onclick="toggleStatus({{ $batch->id }})" class="w-full bg-{{ $batch->is_active ? 'red' : 'green' }}-600 hover:bg-{{ $batch->is_active ? 'red' : 'green' }}-700 text-white px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors">
                        <i class="fas fa-{{ $batch->is_active ? 'pause' : 'play' }}"></i>
                        <span>{{ $batch->is_active ? 'Deactivate' : 'Activate' }} Batch</span>
                    </button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Recent Activity</h2>
                </div>

                <div class="space-y-3">
                    <div class="text-center py-8">
                        <i class="fas fa-clock text-gray-500 text-4xl mb-4"></i>
                        <p class="text-gray-400">No recent activity</p>
                        <p class="text-gray-500 text-sm">Activity will appear here as students interact with the batch</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStatus(batchId) {
    if (confirm('Are you sure you want to change the batch status?')) {
        fetch(`/batches/${batchId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating status');
        });
    }
}
</script>
@endsection