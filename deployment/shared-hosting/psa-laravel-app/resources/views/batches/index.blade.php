@extends('layouts.dashboard')

@section('title', 'Batches Management')
@section('page-title', 'Batches Management')
@section('page-description', 'Manage training batches, schedules, and student enrollments')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Batches Management</h1>
            <p class="text-gray-400">Manage training batches and student enrollments</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('batches.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-download"></i>
                <span>Export</span>
            </a>
            <a href="{{ route('batches.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Add Batch</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Batches -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Batches</p>
                    <p class="text-3xl font-bold">{{ $stats['total_batches'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-layer-group text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Batches -->
        <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Batches</p>
                    <p class="text-3xl font-bold">{{ $stats['active_batches'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-play-circle text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Students</p>
                    <p class="text-3xl font-bold">{{ $stats['total_students'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Available Spots -->
        <div class="bg-gradient-to-br from-orange-600 to-orange-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Available Spots</p>
                    <p class="text-3xl font-bold">{{ $stats['available_spots'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
        <form method="GET" action="{{ route('batches.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Batches</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="Search by name or description...">
                </div>

                <!-- Sport Filter -->
                <div>
                    <label for="sport_id" class="block text-sm font-medium text-gray-300 mb-2">Sport</label>
                    <select id="sport_id" name="sport_id"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Sports</option>
                        @foreach($sports as $sport)
                            <option value="{{ $sport->id }}" {{ request('sport_id') == $sport->id ? 'selected' : '' }}>
                                {{ $sport->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="status" name="status"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Coach Filter -->
                <div>
                    <label for="coach_id" class="block text-sm font-medium text-gray-300 mb-2">Coach</label>
                    <select id="coach_id" name="coach_id"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Coaches</option>
                        @foreach($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ request('coach_id') == $coach->id ? 'selected' : '' }}>
                                {{ $coach->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-search"></i>
                    <span>Search</span>
                </button>
                <a href="{{ route('batches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-times"></i>
                    <span>Clear</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Batches Table -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white">Batches List</h2>
                <p class="text-gray-400 text-sm">{{ $batches->total() }} total batches</p>
            </div>
        </div>

        @if($batches->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Batch Info</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Sport & Coach</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Schedule</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Capacity</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($batches as $batch)
                    <tr class="hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-white font-medium">{{ $batch->name }}</div>
                                @if($batch->description)
                                <div class="text-gray-400 text-sm mt-1">{{ Str::limit($batch->description, 50) }}</div>
                                @endif
                                <div class="text-gray-500 text-xs mt-1">Created {{ $batch->created_at->diffForHumans() }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-white font-medium">{{ $batch->sport->name }}</div>
                                @if($batch->coach)
                                <div class="text-gray-400 text-sm">Coach: {{ $batch->coach->name }}</div>
                                @else
                                <div class="text-gray-500 text-sm">No coach assigned</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-300">
                                @if($batch->schedule)
                                    {{ $batch->schedule }}
                                @else
                                    <span class="text-gray-500">Not scheduled</span>
                                @endif
                            </div>
                            @if($batch->start_time && $batch->end_time)
                            <div class="text-gray-400 text-sm">
                                {{ date('g:i A', strtotime($batch->start_time)) }} - 
                                {{ date('g:i A', strtotime($batch->end_time)) }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <div class="text-white font-medium">{{ $batch->current_students }}/{{ $batch->max_capacity }}</div>
                                <div class="w-16 bg-gray-600 rounded-full h-2">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $batch->max_capacity > 0 ? ($batch->current_students / $batch->max_capacity) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            @if($batch->current_students >= $batch->max_capacity)
                            <div class="text-red-400 text-xs mt-1">Full</div>
                            @else
                            <div class="text-green-400 text-xs mt-1">{{ $batch->max_capacity - $batch->current_students }} spots left</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $batch->is_active ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                {{ $batch->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('batches.show', $batch) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('batches.edit', $batch) }}" class="text-purple-400 hover:text-purple-300 transition-colors" title="Edit Batch">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="toggleStatus({{ $batch->id }})" class="text-{{ $batch->is_active ? 'yellow' : 'green' }}-400 hover:text-{{ $batch->is_active ? 'yellow' : 'green' }}-300 transition-colors" title="{{ $batch->is_active ? 'Deactivate' : 'Activate' }} Batch">
                                    <i class="fas fa-{{ $batch->is_active ? 'pause' : 'play' }}"></i>
                                </button>
                                @if(auth()->user()->hasRole('admin'))
                                <button onclick="deleteBatch({{ $batch->id }})" class="text-red-400 hover:text-red-300 transition-colors" title="Delete Batch">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-700">
            {{ $batches->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <i class="fas fa-layer-group text-gray-500 text-6xl mb-4"></i>
            <h3 class="text-xl font-medium text-gray-400 mb-2">No batches found</h3>
            <p class="text-gray-500 mb-6">
                @if(request()->hasAny(['search', 'sport_id', 'status', 'coach_id']))
                    No batches match your current filters.
                @else
                    Get started by creating your first batch.
                @endif
            </p>
            @if(!request()->hasAny(['search', 'sport_id', 'status', 'coach_id']))
            <a href="{{ route('batches.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg inline-flex items-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Create First Batch</span>
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Hidden forms for actions -->
<form id="toggle-status-form" method="POST" class="hidden">
    @csrf
    @method('PATCH')
</form>

<form id="delete-form" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
function toggleStatus(batchId) {
    if (confirm('Are you sure you want to change the batch status?')) {
        const form = document.getElementById('toggle-status-form');
        form.action = `/batches/${batchId}/toggle-status`;
        form.submit();
    }
}

function deleteBatch(batchId) {
    if (confirm('Are you sure you want to delete this batch? This action cannot be undone and will affect all enrolled students.')) {
        const form = document.getElementById('delete-form');
        form.action = `/batches/${batchId}`;
        form.submit();
    }
}
</script>
@endsection