@extends('layouts.dashboard')

@section('title', 'Edit Coach - ' . $coach->name)
@section('page-title', 'Edit Coach')
@section('page-description', 'Update coach information and specialization details')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Edit Coach</h1>
            <p class="text-gray-400">Update {{ $coach->name }}'s information</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('coaches.show', $coach) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-eye"></i>
                <span>View Coach</span>
            </a>
            <a href="{{ route('coaches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Coaches</span>
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
        <form action="{{ route('coaches.update', $coach) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

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
                        <input type="text" id="name" name="name" value="{{ old('name', $coach->name) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $coach->email) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                            Phone Number <span class="text-red-400">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $coach->phone) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror">
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
                                <option value="{{ $sport->name }}" {{ old('specialization', $coach->specialization) === $sport->name ? 'selected' : '' }}>
                                    {{ $sport->name }}
                                </option>
                            @endforeach
                            <option value="Multi-Sport" {{ old('specialization', $coach->specialization) === 'Multi-Sport' ? 'selected' : '' }}>Multi-Sport</option>
                            <option value="Fitness Training" {{ old('specialization', $coach->specialization) === 'Fitness Training' ? 'selected' : '' }}>Fitness Training</option>
                            <option value="Youth Development" {{ old('specialization', $coach->specialization) === 'Youth Development' ? 'selected' : '' }}>Youth Development</option>
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
                        <input type="number" id="experience" name="experience" value="{{ old('experience', $coach->experience) }}" required
                               min="0" max="50"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('experience') border-red-500 @enderror">
                        @error('experience')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <div class="flex items-center space-x-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $coach->is_active) ? 'checked' : '' }}
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
                                  class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('qualifications') border-red-500 @enderror">{{ old('qualifications', $coach->qualifications) }}</textarea>
                        @error('qualifications')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-400 text-sm mt-1">
                            Example: B.P.Ed, Sports Science Diploma, Level 2 Cricket Coaching Certificate, etc.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Current Assignments (Read-only) -->
            @if($coach->batches->count() > 0)
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Current Batch Assignments</h2>
                </div>

                <div class="bg-gray-700 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($coach->batches as $batch)
                        <div class="bg-gray-600 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-white font-medium">{{ $batch->name }}</h4>
                                    <p class="text-gray-300 text-sm">{{ $batch->sport->name ?? 'No Sport' }}</p>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $batch->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $batch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-gray-400 text-sm mt-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        To modify batch assignments, please contact the administrator or use the batch management section.
                    </p>
                </div>
            </div>
            @endif

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-6 border-t border-gray-700">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-save"></i>
                    <span>Update Coach</span>
                </button>
                <a href="{{ route('coaches.show', $coach) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
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

    // Handle custom specialization
    const specializationSelect = document.getElementById('specialization');
    const currentValue = specializationSelect.value;
    
    // Check if current value is not in the options (custom value)
    let foundOption = false;
    for (let option of specializationSelect.options) {
        if (option.value === currentValue) {
            foundOption = true;
            break;
        }
    }
    
    // If current value is custom, add it as an option
    if (!foundOption && currentValue) {
        const customOption = document.createElement('option');
        customOption.value = currentValue;
        customOption.textContent = currentValue + ' (Custom)';
        customOption.selected = true;
        specializationSelect.appendChild(customOption);
    }
    
    // Add option for new custom specialization
    const newCustomOption = document.createElement('option');
    newCustomOption.value = 'custom';
    newCustomOption.textContent = 'Other (Custom)';
    specializationSelect.appendChild(newCustomOption);
    
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
});
</script>
@endsection