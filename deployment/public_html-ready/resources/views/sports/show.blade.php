@extends('layouts.dashboard')

@section('title', $sport->name . ' - Sport Details')
@section('page-title', $sport->name)
@section('page-description', 'View sport details, statistics, and manage batches')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $sport->name }}</h1>
            <p class="text-gray-400">Sport details and management</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('sports.edit', $sport) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-edit"></i>
                <span>Edit Sport</span>
            </a>
            <a href="{{ route('sports.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Sports</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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

        <!-- Active Students -->
        <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Students</p>
                    <p class="text-3xl font-bold">{{ $stats['total_students'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Monthly Fee</p>
                    <p class="text-3xl font-bold">₹{{ number_format($sport->fee_structure['monthly'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-gradient-to-br from-{{ $sport->is_active ? 'green' : 'red' }}-600 to-{{ $sport->is_active ? 'green' : 'red' }}-800 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-{{ $sport->is_active ? 'green' : 'red' }}-100 text-sm font-medium">Status</p>
                    <p class="text-2xl font-bold">{{ $sport->is_active ? 'Active' : 'Inactive' }}</p>
                </div>
                <div class="w-12 h-12 bg-{{ $sport->is_active ? 'green' : 'red' }}-500 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-{{ $sport->is_active ? 'check-circle' : 'times-circle' }} text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sport Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-futbol text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Sport Information</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Sport Name</label>
                        <p class="text-white text-lg font-medium">{{ $sport->name }}</p>
                    </div>

                    @if($sport->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                        <p class="text-gray-300 leading-relaxed">{{ $sport->description }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Created Date</label>
                            <p class="text-gray-300">{{ $sport->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Last Updated</label>
                            <p class="text-gray-300">{{ $sport->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Batches -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-layer-group text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Recent Batches</h2>
                    </div>
                    <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View All</a>
                </div>

                @if($recentBatches->count() > 0)
                <div class="space-y-3">
                    @foreach($recentBatches as $batch)
                    <div class="bg-gray-700 border border-gray-600 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-medium">{{ $batch->name }}</h3>
                                <p class="text-gray-400 text-sm">
                                    {{ $batch->schedule }} • 
                                    Capacity: {{ $batch->current_students }}/{{ $batch->max_capacity }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $batch->is_active ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $batch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-layer-group text-gray-500 text-4xl mb-4"></i>
                    <p class="text-gray-400">No batches created yet</p>
                    <p class="text-gray-500 text-sm">Create your first batch to get started</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Fee Structure -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-rupee-sign text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Fee Structure</h2>
                </div>

                <div class="space-y-4">
                    @if(isset($sport->fee_structure['monthly']) && $sport->fee_structure['monthly'])
                    <div class="bg-gray-700 border border-gray-600 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Monthly Fee</p>
                                <p class="text-white text-xl font-bold">₹{{ number_format($sport->fee_structure['monthly']) }}</p>
                            </div>
                            <div class="w-8 h-8 bg-blue-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-blue-400"></i>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(isset($sport->fee_structure['quarterly']) && $sport->fee_structure['quarterly'])
                    <div class="bg-gray-700 border border-gray-600 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Quarterly Fee</p>
                                <p class="text-white text-xl font-bold">₹{{ number_format($sport->fee_structure['quarterly']) }}</p>
                            </div>
                            <div class="w-8 h-8 bg-purple-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar text-purple-400"></i>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(isset($sport->fee_structure['yearly']) && $sport->fee_structure['yearly'])
                    <div class="bg-gray-700 border border-gray-600 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Yearly Fee</p>
                                <p class="text-white text-xl font-bold">₹{{ number_format($sport->fee_structure['yearly']) }}</p>
                            </div>
                            <div class="w-8 h-8 bg-green-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-check text-green-400"></i>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(empty(array_filter($sport->fee_structure ?? [])))
                    <div class="text-center py-8">
                        <i class="fas fa-rupee-sign text-gray-500 text-4xl mb-4"></i>
                        <p class="text-gray-400">No fee structure set</p>
                        <p class="text-gray-500 text-sm">Edit sport to add fees</p>
                    </div>
                    @endif
                </div>
            </div>

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
                        <i class="fas fa-plus"></i>
                        <span>Create New Batch</span>
                    </a>
                    <a href="{{ route('sports.edit', $sport) }}" class="w-full bg-gray-700 hover:bg-gray-600 text-white px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors">
                        <i class="fas fa-edit"></i>
                        <span>Edit Sport Details</span>
                    </a>
                    <button onclick="toggleStatus({{ $sport->id }})" class="w-full bg-{{ $sport->is_active ? 'red' : 'green' }}-600 hover:bg-{{ $sport->is_active ? 'red' : 'green' }}-700 text-white px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors">
                        <i class="fas fa-{{ $sport->is_active ? 'pause' : 'play' }}"></i>
                        <span>{{ $sport->is_active ? 'Deactivate' : 'Activate' }} Sport</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStatus(sportId) {
    if (confirm('Are you sure you want to change the sport status?')) {
        fetch(`/sports/${sportId}/toggle-status`, {
            method: 'POST',
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