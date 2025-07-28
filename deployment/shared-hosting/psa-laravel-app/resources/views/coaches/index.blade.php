@extends('layouts.dashboard')

@section('title', 'Coaches Management')
@section('page-title', 'Coaches Management')
@section('page-description', 'Manage coaches, their specializations, and batch assignments')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Coaches Management</h1>
            <p class="text-gray-400">{{ $coaches->total() }} coaches found</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('coaches.export', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-download"></i>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('coaches.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Add Coach</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Coaches</p>
                    <p class="text-2xl font-bold">{{ $stats['total_coaches'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Active Coaches</p>
                    <p class="text-2xl font-bold">{{ $stats['active_coaches'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm">Inactive Coaches</p>
                    <p class="text-2xl font-bold">{{ $stats['inactive_coaches'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-times text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Avg Experience</p>
                    <p class="text-2xl font-bold">{{ $stats['avg_experience'] }} yrs</p>
                </div>
                <div class="w-12 h-12 bg-purple-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-medal text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
        <form method="GET" action="{{ route('coaches.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Coaches</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           placeholder="Name, email, phone, specialization..."
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="status" name="status" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Specialization Filter -->
                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-300 mb-2">Specialization</label>
                    <select id="specialization" name="specialization" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec }}" {{ request('specialization') === $spec ? 'selected' : '' }}>
                                {{ $spec }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Experience Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Experience (Years)</label>
                    <div class="flex space-x-2">
                        <input type="number" name="experience_min" value="{{ request('experience_min') }}" 
                               placeholder="Min" min="0" max="50"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <input type="number" name="experience_max" value="{{ request('experience_max') }}" 
                               placeholder="Max" min="0" max="50"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-search"></i>
                    <span>Search</span>
                </button>
                <a href="{{ route('coaches.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-times"></i>
                    <span>Clear</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Coaches Table -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Coach</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Specialization</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Experience</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Batches</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($coaches as $coach)
                        <tr class="hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($coach->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $coach->name }}</div>
                                        <div class="text-sm text-gray-400">ID: {{ $coach->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-white">{{ $coach->phone }}</div>
                                <div class="text-sm text-gray-400">{{ $coach->email ?: 'No email' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $coach->specialization }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-white">{{ $coach->experience }} years</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-white">{{ $coach->batches_count }} batches</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $coach->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas fa-circle w-2 h-2 mr-1"></i>
                                    {{ $coach->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('coaches.show', $coach) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="View Coach">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('coaches.edit', $coach) }}" class="text-purple-400 hover:text-purple-300 transition-colors" title="Edit Coach">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('coaches.toggle-status', $coach) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="{{ $coach->is_active ? 'Deactivate' : 'Activate' }} Coach">
                                            <i class="fas fa-{{ $coach->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    @if($coach->batches_count == 0)
                                    <form action="{{ route('coaches.destroy', $coach) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this coach?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors" title="Delete Coach">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center">
                                        <i class="fas fa-users text-2xl text-gray-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-white mb-2">No coaches found</h3>
                                        <p class="text-gray-400 mb-4">Get started by adding your first coach.</p>
                                        <a href="{{ route('coaches.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 rounded-lg inline-flex items-center space-x-2 transition-colors">
                                            <i class="fas fa-plus"></i>
                                            <span>Add First Coach</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($coaches->hasPages())
            <div class="bg-gray-700 px-6 py-4 border-t border-gray-600">
                {{ $coaches->links() }}
            </div>
        @endif
    </div>
</div>
@endsection