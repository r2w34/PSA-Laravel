@extends('layouts.dashboard')

@section('title', 'Add New Inquiry')
@section('page-title', 'Add New Inquiry')
@section('page-description', 'Create a new inquiry record for potential students')

@section('content')
<div class="space-y-6">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Add New Inquiry</h1>
                    <p class="mt-2 text-gray-400">Create a new student inquiry record</p>
                </div>
                <a href="{{ route('inquiries.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">Inquiry Information</h3>
                <p class="text-sm text-gray-400 mt-1">Fill in the details for the new inquiry</p>
            </div>

            <form method="POST" action="{{ route('inquiries.store') }}" class="p-6 space-y-6">
                @csrf

                <!-- Personal Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                            Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Enter full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="Enter email address">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                            Phone Number <span class="text-red-400">*</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               required
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="Enter phone number">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-300 mb-2">Age</label>
                        <input type="number" 
                               id="age" 
                               name="age" 
                               value="{{ old('age') }}"
                               min="3" 
                               max="50"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('age') border-red-500 @enderror"
                               placeholder="Enter age">
                        @error('age')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-300 mb-2">Gender</label>
                        <select id="gender" 
                                name="gender" 
                                class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('gender') border-red-500 @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Sport and Batch Information -->
                <div class="border-t border-gray-700 pt-6">
                    <h4 class="text-lg font-medium text-white mb-4">Sport & Batch Interest</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sport_id" class="block text-sm font-medium text-gray-300 mb-2">
                                Interested Sport <span class="text-red-400">*</span>
                            </label>
                            <select id="sport_id" 
                                    name="sport_id" 
                                    required
                                    onchange="updateBatches()"
                                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sport_id') border-red-500 @enderror">
                                <option value="">Select Sport</option>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}" {{ old('sport_id') == $sport->id ? 'selected' : '' }}>
                                        {{ $sport->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sport_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="batch_id" class="block text-sm font-medium text-gray-300 mb-2">Preferred Batch</label>
                            <select id="batch_id" 
                                    name="batch_id" 
                                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('batch_id') border-red-500 @enderror">
                                <option value="">Select Batch (Optional)</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" 
                                            data-sport="{{ $batch->sport_id }}"
                                            {{ old('batch_id') == $batch->id ? 'selected' : '' }}
                                            style="display: none;">
                                        {{ $batch->name }} ({{ $batch->sport->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Inquiry Details -->
                <div class="border-t border-gray-700 pt-6">
                    <h4 class="text-lg font-medium text-white mb-4">Inquiry Details</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-300 mb-2">
                                Priority <span class="text-red-400">*</span>
                            </label>
                            <select id="priority" 
                                    name="priority" 
                                    required
                                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('priority') border-red-500 @enderror">
                                <option value="">Select Priority</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="source" class="block text-sm font-medium text-gray-300 mb-2">
                                Inquiry Source <span class="text-red-400">*</span>
                            </label>
                            <select id="source" 
                                    name="source" 
                                    required
                                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('source') border-red-500 @enderror">
                                <option value="">Select Source</option>
                                <option value="website" {{ old('source') == 'website' ? 'selected' : '' }}>Website</option>
                                <option value="phone" {{ old('source') == 'phone' ? 'selected' : '' }}>Phone Call</option>
                                <option value="walk_in" {{ old('source') == 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                                <option value="referral" {{ old('source') == 'referral' ? 'selected' : '' }}>Referral</option>
                                <option value="social_media" {{ old('source') == 'social_media' ? 'selected' : '' }}>Social Media</option>
                                <option value="advertisement" {{ old('source') == 'advertisement' ? 'selected' : '' }}>Advertisement</option>
                            </select>
                            @error('source')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="follow_up_date" class="block text-sm font-medium text-gray-300 mb-2">Follow-up Date</label>
                            <input type="date" 
                                   id="follow_up_date" 
                                   name="follow_up_date" 
                                   value="{{ old('follow_up_date') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('follow_up_date') border-red-500 @enderror">
                            @error('follow_up_date')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="border-t border-gray-700 pt-6">
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Notes</label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="4"
                                  class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                                  placeholder="Add any additional notes about this inquiry...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="border-t border-gray-700 pt-6">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('inquiries.index') }}" 
                           class="inline-flex items-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Create Inquiry
                        </button>
                    </div>
                </div>
            </form>
    </div>
</div>

<script>
function updateBatches() {
    const sportSelect = document.getElementById('sport_id');
    const batchSelect = document.getElementById('batch_id');
    const selectedSportId = sportSelect.value;
    
    // Hide all batch options
    const batchOptions = batchSelect.querySelectorAll('option[data-sport]');
    batchOptions.forEach(option => {
        option.style.display = 'none';
    });
    
    // Reset batch selection
    batchSelect.value = '';
    
    // Show batches for selected sport
    if (selectedSportId) {
        const relevantBatches = batchSelect.querySelectorAll(`option[data-sport="${selectedSportId}"]`);
        relevantBatches.forEach(option => {
            option.style.display = 'block';
        });
    }
}

// Initialize batch filtering on page load
document.addEventListener('DOMContentLoaded', function() {
    updateBatches();
});
</script>
@endsection