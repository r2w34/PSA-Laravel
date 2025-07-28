@extends('layouts.dashboard')

@section('title', 'Create New Batch')
@section('page-title', 'Create New Batch')
@section('page-description', 'Set up a new training batch with schedule and capacity')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Create New Batch</h1>
            <p class="text-gray-400">Set up a new training batch with schedule and capacity</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('batches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Batches</span>
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6 lg:p-8">
        <form action="{{ route('batches.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Batch Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-300">
                            Batch Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('name') border-red-500 @enderror"
                               placeholder="Enter batch name (e.g., Morning Cricket Batch)">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sport -->
                    <div class="space-y-2">
                        <label for="sport_id" class="block text-sm font-medium text-gray-300">
                            Sport <span class="text-red-400">*</span>
                        </label>
                        <select id="sport_id" name="sport_id" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sport_id') border-red-500 @enderror">
                            <option value="">Select Sport</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->id }}" {{ old('sport_id') == $sport->id ? 'selected' : '' }}>
                                    {{ $sport->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sport_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Coach -->
                    <div class="space-y-2">
                        <label for="coach_id" class="block text-sm font-medium text-gray-300">
                            Coach
                        </label>
                        <select id="coach_id" name="coach_id"
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('coach_id') border-red-500 @enderror">
                            <option value="">Select Coach (Optional)</option>
                            @foreach($coaches as $coach)
                                <option value="{{ $coach->id }}" {{ old('coach_id') == $coach->id ? 'selected' : '' }}>
                                    {{ $coach->name }} - {{ $coach->specialization }}
                                </option>
                            @endforeach
                        </select>
                        @error('coach_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Status
                        </label>
                        <div class="flex items-center space-x-3 bg-gray-700 border border-gray-600 rounded-lg px-4 py-3">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-600 border-gray-500 rounded focus:ring-purple-500 focus:ring-2">
                            <label for="is_active" class="text-sm text-gray-300 cursor-pointer">Active</label>
                        </div>
                        @error('is_active')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-medium text-gray-300">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors resize-none @error('description') border-red-500 @enderror"
                              placeholder="Enter batch description, training focus, or additional information...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Schedule & Capacity Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-calendar-alt text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Schedule & Capacity</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Schedule -->
                    <div class="space-y-2">
                        <label for="schedule" class="block text-sm font-medium text-gray-300">
                            Schedule
                        </label>
                        <input type="text" id="schedule" name="schedule" value="{{ old('schedule') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('schedule') border-red-500 @enderror"
                               placeholder="e.g., Mon, Wed, Fri or Daily">
                        @error('schedule')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Capacity -->
                    <div class="space-y-2">
                        <label for="max_capacity" class="block text-sm font-medium text-gray-300">
                            Maximum Capacity <span class="text-red-400">*</span>
                        </label>
                        <input type="number" id="max_capacity" name="max_capacity" value="{{ old('max_capacity') }}" min="1" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('max_capacity') border-red-500 @enderror"
                               placeholder="Enter maximum number of students">
                        @error('max_capacity')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div class="space-y-2">
                        <label for="start_time" class="block text-sm font-medium text-gray-300">
                            Start Time
                        </label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('start_time') border-red-500 @enderror">
                        @error('start_time')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div class="space-y-2">
                        <label for="end_time" class="block text-sm font-medium text-gray-300">
                            End Time
                        </label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('end_time') border-red-500 @enderror">
                        @error('end_time')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-900 bg-opacity-30 border border-blue-700 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-400 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm text-blue-300">
                            <p class="font-medium mb-2">Batch Setup Guidelines:</p>
                            <ul class="list-disc list-inside space-y-1 text-blue-200">
                                <li>Choose an appropriate capacity based on facility and sport requirements</li>
                                <li>Schedule should clearly indicate training days (e.g., "Mon, Wed, Fri" or "Daily")</li>
                                <li>Start and end times help students plan their schedule</li>
                                <li>Coach assignment can be done later if not available now</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-8 border-t border-gray-700">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-3 rounded-lg flex items-center justify-center space-x-2 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-save"></i>
                    <span>Create Batch</span>
                </button>
                <a href="{{ route('batches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-3 rounded-lg flex items-center justify-center space-x-2 transition-all duration-200 font-medium">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection