@extends('layouts.dashboard')

@section('title', 'Attendance Management')
@section('page-title', 'Attendance Management')
@section('page-description', 'Track and manage student attendance records')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Attendance Management</h1>
                    <p class="mt-2 text-gray-400">Track and manage student attendance records</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('attendance.export', request()->query()) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>
                        Export
                    </a>
                    <a href="{{ route('attendance.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <span class="mr-2">+</span>
                        Mark Attendance
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Total Records</p>
                        <p class="text-2xl font-bold text-white">{{ number_format($stats['total_records']) }}</p>
                    </div>
                    <div class="p-3 bg-blue-500/10 rounded-lg">
                        <i class="fas fa-clipboard-list text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Present Today</p>
                        <p class="text-2xl font-bold text-green-400">{{ number_format($stats['present_today']) }}</p>
                    </div>
                    <div class="p-3 bg-green-500/10 rounded-lg">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Absent Today</p>
                        <p class="text-2xl font-bold text-red-400">{{ number_format($stats['absent_today']) }}</p>
                    </div>
                    <div class="p-3 bg-red-500/10 rounded-lg">
                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Late Today</p>
                        <p class="text-2xl font-bold text-yellow-400">{{ number_format($stats['late_today']) }}</p>
                    </div>
                    <div class="p-3 bg-yellow-500/10 rounded-lg">
                        <i class="fas fa-clock text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-gray-800 rounded-xl p-6 mb-8 border border-gray-700">
            <form method="GET" action="{{ route('attendance.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Students</label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by name, email, or phone"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-300 mb-2">Batch</label>
                        <select id="batch_id" 
                                name="batch_id" 
                                class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">All Batches</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }} ({{ $batch->sport->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-300 mb-2">Date</label>
                        <input type="date" 
                               id="date" 
                               name="date" 
                               value="{{ request('date') }}"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                        </select>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                    <a href="{{ route('attendance.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Attendance List -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-white">Attendance Records</h2>
                    <p class="text-gray-400">{{ $attendances->total() }} total records</p>
                </div>
            </div>

            @if($attendances->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Batch & Sport</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Marked By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($attendances as $attendance)
                                <tr class="hover:bg-gray-700/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-white font-medium">{{ $attendance->date->format('M d, Y') }}</div>
                                        <div class="text-gray-400 text-sm">{{ $attendance->date->format('l') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
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
                                            <div class="ml-4">
                                                <div class="text-white font-medium">{{ $attendance->student->name }}</div>
                                                <div class="text-gray-400 text-sm">{{ $attendance->student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-white font-medium">{{ $attendance->batch->name }}</div>
                                        <div class="text-gray-400 text-sm">{{ $attendance->batch->sport->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-white text-sm">{{ $attendance->markedBy->name ?? 'System' }}</div>
                                        <div class="text-gray-400 text-xs">{{ $attendance->marked_at ? $attendance->marked_at->format('M d, Y H:i') : '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('attendance.show', $attendance) }}" 
                                               class="text-blue-400 hover:text-blue-300 transition-colors duration-200" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('attendance.edit', $attendance) }}" 
                                               class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('attendance.destroy', $attendance) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-400 hover:text-red-300 transition-colors duration-200" 
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-700">
                    {{ $attendances->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-clipboard-list text-gray-500 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-300 mb-2">No attendance records found</h3>
                    <p class="text-gray-500 mb-6">Start by marking attendance for your batches.</p>
                    <a href="{{ route('attendance.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <span class="mr-2">+</span>
                        Mark Attendance
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection