@extends('layouts.dashboard')

@section('title', 'Add New Coach')
@section('page-title', 'Add New Coach')
@section('page-description', 'Create a new coach profile with specialization and experience details')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Add New Coach</h1>
            <p class="text-gray-400">Fill in the coach's information and specialization details</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('coaches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Coaches</span>
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
        <form action="{{ route('coaches.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Basic Information Section -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                            Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Enter coach's full name">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="coach@example.com">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                            Phone Number <span class="text-red-400">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="+91 9876543210">
                        @error('phone')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Specialization -->
                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-300 mb-2">
                            Specialization <span class="text-red-400">*</span>
                        </label>
                        <select id="specialization" name="specialization" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('specialization') border-red-500 @enderror">
                            <option value="">Select Specialization</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->name }}" {{ old('specialization') === $sport->name ? 'selected' : '' }}>
                                    {{ $sport->name }}
                                </option>
                            @endforeach
                            <option value="Multi-Sport" {{ old('specialization') === 'Multi-Sport' ? 'selected' : '' }}>Multi-Sport</option>
                            <option value="Fitness Training" {{ old('specialization') === 'Fitness Training' ? 'selected' : '' }}>Fitness Training</option>
                            <option value="Youth Development" {{ old('specialization') === 'Youth Development' ? 'selected' : '' }}>Youth Development</option>
                        </select>
                        @error('specialization')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience -->
                    <div>
                        <label for="experience" class="block text-sm font-medium text-gray-300 mb-2">
                            Experience (Years) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" id="experience" name="experience" value="{{ old('experience') }}" required
                               min="0" max="50"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('experience') border-red-500 @enderror"
                               placeholder="5">
                        @error('experience')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <div class="flex items-center space-x-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
                            <label for="is_active" class="text-gray-300">Coach is active</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information Section -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-certificate text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Professional Information</h2>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Qualifications -->
                    <div>
                        <label for="qualifications" class="block text-sm font-medium text-gray-300 mb-2">
                            Qualifications & Certifications
                        </label>
                        <textarea id="qualifications" name="qualifications" rows="4" 
                                  placeholder="List educational qualifications, certifications, achievements, etc..."
                                  class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('qualifications') border-red-500 @enderror">{{ old('qualifications') }}</textarea>
                        @error('qualifications')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-400 text-sm mt-1">
                            Example: B.P.Ed, Sports Science Diploma, Level 2 Cricket Coaching Certificate, etc.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-6 border-t border-gray-700">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-save"></i>
                    <span>Create Coach</span>
                </button>
                <a href="{{ route('coaches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format phone number
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 0 && !value.startsWith('91')) {
            if (value.length === 10) {
                value = '91' + value;
            }
        }
        if (value.length > 12) {
            value = value.substring(0, 12);
        }
        this.value = value.replace(/(\d{2})(\d{10})/, '+$1 $2');
    });

    // Custom specialization input
    const specializationSelect = document.getElementById('specialization');
    specializationSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            const customInput = document.createElement('input');
            customInput.type = 'text';
            customInput.name = 'specialization';
            customInput.placeholder = 'Enter custom specialization';
            customInput.className = this.className;
            customInput.required = true;
            
            this.parentNode.replaceChild(customInput, this);
            customInput.focus();
        }
    });

    // Add option for custom specialization
    const customOption = document.createElement('option');
    customOption.value = 'custom';
    customOption.textContent = 'Other (Custom)';
    specializationSelect.appendChild(customOption);
});
</script>
@endsection