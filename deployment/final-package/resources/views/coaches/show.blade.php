@extends('layouts.dashboard')

@section('title', 'Coach Details - ' . $coach->name)
@section('page-title', 'Coach Details')
@section('page-description', 'View complete coach information, batches, and performance statistics')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $coach->name }}</h1>
            <p class="text-gray-400">{{ $coach->specialization }} Coach • {{ $coach->experience }} years experience</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('coaches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Coaches</span>
            </a>
            <a href="{{ route('coaches.edit', $coach) }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-edit"></i>
                <span>Edit Coach</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Coach Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $coach->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $coach->email ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Phone</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $coach->phone }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Specialization</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $coach->specialization }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Experience</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $coach->experience }} years</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $coach->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="fas fa-circle w-2 h-2 mr-2"></i>
                            {{ $coach->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Qualifications -->
            @if($coach->qualifications)
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-certificate text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Qualifications & Certifications</h2>
                </div>

                <div class="text-white bg-gray-700 px-4 py-3 rounded-lg whitespace-pre-line">{{ $coach->qualifications }}</div>
            </div>
            @endif

            <!-- Assigned Batches -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Assigned Batches</h2>
                    </div>
                    <span class="text-gray-400">{{ $recentBatches->count() }} active batches</span>
                </div>

                @if($recentBatches->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentBatches as $batch)
                        <div class="bg-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-layer-group text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-medium">{{ $batch->name }}</h3>
                                        <p class="text-gray-400 text-sm">
                                            {{ $batch->sport->name ?? 'No Sport' }} • 
                                            {{ $batch->students->count() }} students
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($batch->start_time && $batch->end_time)
                                    <p class="text-white text-sm">{{ $batch->start_time }} - {{ $batch->end_time }}</p>
                                    @endif
                                    @if($batch->days)
                                    <p class="text-gray-400 text-xs">{{ $batch->days }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">No Batches Assigned</h3>
                        <p class="text-gray-400">This coach is not currently assigned to any batches.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistics Sidebar -->
        <div class="space-y-6">
            <!-- Performance Statistics -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Statistics</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Total Batches</span>
                            <span class="text-white font-bold">{{ $stats['total_batches'] }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Active Batches</span>
                            <span class="text-green-400 font-bold">{{ $stats['active_batches'] }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Total Students</span>
                            <span class="text-blue-400 font-bold">{{ $stats['total_students'] }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Sports Taught</span>
                            <span class="text-purple-400 font-bold">{{ $stats['sports_taught'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coach Timeline -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Timeline</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="text-gray-300 text-sm mb-1">Joined Academy</div>
                        <div class="text-white font-medium">{{ $coach->created_at->format('M d, Y') }}</div>
                        <div class="text-gray-400 text-xs">{{ $coach->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="text-gray-300 text-sm mb-1">Last Updated</div>
                        <div class="text-white font-medium">{{ $coach->updated_at->format('M d, Y') }}</div>
                        <div class="text-gray-400 text-xs">{{ $coach->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('coaches.edit', $coach) }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-edit"></i>
                        <span>Edit Coach</span>
                    </a>
                    
                    <form action="{{ route('coaches.toggle-status', $coach) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full bg-{{ $coach->is_active ? 'yellow' : 'green' }}-600 hover:bg-{{ $coach->is_active ? 'yellow' : 'green' }}-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <i class="fas fa-{{ $coach->is_active ? 'pause' : 'play' }}"></i>
                            <span>{{ $coach->is_active ? 'Deactivate' : 'Activate' }} Coach</span>
                        </button>
                    </form>
                    
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Assign Batch</span>
                    </button>
                    
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-file-pdf"></i>
                        <span>Generate Report</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection