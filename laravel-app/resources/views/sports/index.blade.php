@extends('layouts.dashboard')

@section('title', 'Sports Management')
@section('page-title', 'Sports Management')
@section('page-description', 'Manage sports, fee structures, and batch assignments')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Sports Management</h1>
            <p class="text-gray-400">{{ $sports->total() }} sports found</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('sports.export', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-download"></i>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('sports.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Add Sport</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Sports</p>
                    <p class="text-2xl font-bold">{{ $stats['total_sports'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-futbol text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Active Sports</p>
                    <p class="text-2xl font-bold">{{ $stats['active_sports'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm">Inactive Sports</p>
                    <p class="text-2xl font-bold">{{ $stats['inactive_sports'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Total Batches</p>
                    <p class="text-2xl font-bold">{{ $stats['total_batches'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-400 bg-opacity-30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-layer-group text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
        <form method="GET" action="{{ route('sports.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">
                        Search Sports
                    </label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="Search by name or description...">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                        Status
                    </label>
                    <select id="status" name="status"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-search"></i>
                    <span>Search</span>
                </button>
                <a href="{{ route('sports.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-times"></i>
                    <span>Clear</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Sports Table -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-purple-600 to-pink-600">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Sport</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Fee Structure</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Batches</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Students</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($sports as $sport)
                        <tr class="hover:bg-gray-700 transition-colors">
                            <!-- Sport Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">{{ strtoupper(substr($sport->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ $sport->name }}</div>
                                        <div class="text-sm text-gray-400">ID: {{ $sport->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">
                                    {{ Str::limit($sport->description ?? 'No description', 50) }}
                                </div>
                            </td>

                            <!-- Fee Structure -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300">
                                    @if($sport->fee_structure)
                                        @if(isset($sport->fee_structure['monthly']))
                                            <div>Monthly: ₹{{ number_format($sport->fee_structure['monthly']) }}</div>
                                        @endif
                                        @if(isset($sport->fee_structure['quarterly']))
                                            <div>Quarterly: ₹{{ number_format($sport->fee_structure['quarterly']) }}</div>
                                        @endif
                                        @if(isset($sport->fee_structure['yearly']))
                                            <div>Yearly: ₹{{ number_format($sport->fee_structure['yearly']) }}</div>
                                        @endif
                                    @else
                                        <span class="text-gray-500">Not set</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Batches -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300">{{ $sport->batches_count }} batches</div>
                            </td>

                            <!-- Students -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300">{{ $sport->students_count }} students</div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($sport->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-circle text-green-400 mr-1"></i>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-circle text-red-400 mr-1"></i>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <!-- View -->
                                    <a href="{{ route('sports.show', $sport) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('sports.edit', $sport) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="Edit Sport">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Toggle Status -->
                                    <form action="{{ route('sports.toggle-status', $sport) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-purple-400 hover:text-purple-300 transition-colors" title="{{ $sport->is_active ? 'Deactivate' : 'Activate' }} Sport">
                                            <i class="fas fa-{{ $sport->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    @if($sport->batches_count == 0 && $sport->students_count == 0)
                                        <form action="{{ route('sports.destroy', $sport) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this sport?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition-colors" title="Delete Sport">
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
                                <div class="text-gray-400">
                                    <i class="fas fa-futbol text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No sports found</p>
                                    <p class="text-sm">Get started by adding your first sport.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($sports->hasPages())
            <div class="bg-gray-800 px-6 py-4 border-t border-gray-700">
                {{ $sports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection