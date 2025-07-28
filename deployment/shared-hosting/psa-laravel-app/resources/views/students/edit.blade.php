@extends('layouts.dashboard')

@section('title', 'Edit Student - ' . $student->name)
@section('page-title', 'Edit Student')
@section('page-description', 'Update student information and details')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Edit Student</h1>
            <p class="text-gray-400">Update {{ $student->name }}'s information</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('students.show', $student) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-eye"></i>
                <span>View Student</span>
            </a>
            <a href="{{ route('students.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Students</span>
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
        <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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
                        <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}"
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
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $student->phone) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-300 mb-2">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('date_of_birth') border-red-500 @enderror">
                        @error('date_of_birth')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-300 mb-2">
                            Gender <span class="text-red-400">*</span>
                        </label>
                        <select id="gender" name="gender" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('gender') border-red-500 @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Admission Date -->
                    <div>
                        <label for="admission_date" class="block text-sm font-medium text-gray-300 mb-2">Admission Date</label>
                        <input type="date" id="admission_date" name="admission_date" value="{{ old('admission_date', $student->admission_date?->format('Y-m-d')) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('admission_date') border-red-500 @enderror">
                        @error('admission_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-300 mb-2">Address</label>
                        <textarea id="address" name="address" rows="3" placeholder="Enter complete address..."
                                  class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sports & Batch Information -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-futbol text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Sports & Batch Assignment</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sport -->
                    <div>
                        <label for="sport_id" class="block text-sm font-medium text-gray-300 mb-2">
                            Sport <span class="text-red-400">*</span>
                        </label>
                        <select id="sport_id" name="sport_id" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sport_id') border-red-500 @enderror">
                            <option value="">Select Sport</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->id }}" {{ old('sport_id', $student->sport_id) == $sport->id ? 'selected' : '' }}>
                                    {{ $sport->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sport_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Batch -->
                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-300 mb-2">
                            Batch <span class="text-red-400">*</span>
                        </label>
                        <select id="batch_id" name="batch_id" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('batch_id') border-red-500 @enderror">
                            <option value="">Select Batch</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id', $student->batch_id) == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }} ({{ $batch->sport->name ?? 'No Sport' }})
                                </option>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Emergency Contact Information -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-phone text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Emergency Contact</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Emergency Contact Name -->
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-gray-300 mb-2">Emergency Contact Name</label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $student->emergency_contact_name) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('emergency_contact_name') border-red-500 @enderror">
                        @error('emergency_contact_name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-300 mb-2">Emergency Contact Phone</label>
                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $student->emergency_contact_phone) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('emergency_contact_phone') border-red-500 @enderror">
                        @error('emergency_contact_phone')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-toggle-on text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Status</h2>
                </div>

                <div class="flex items-center space-x-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $student->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
                    <label for="is_active" class="text-gray-300">Student is active</label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-6 border-t border-gray-700">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-save"></i>
                    <span>Update Student</span>
                </button>
                <a href="{{ route('students.show', $student) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter batches based on selected sport
    const sportSelect = document.getElementById('sport_id');
    const batchSelect = document.getElementById('batch_id');
    const allBatches = Array.from(batchSelect.options);

    sportSelect.addEventListener('change', function() {
        const selectedSportId = this.value;
        
        // Clear batch options
        batchSelect.innerHTML = '<option value="">Select Batch</option>';
        
        if (selectedSportId) {
            // Filter batches by sport (this would need to be enhanced with AJAX for dynamic filtering)
            allBatches.forEach(option => {
                if (option.value && option.textContent.includes('{{ $student->sport->name ?? "" }}')) {
                    batchSelect.appendChild(option.cloneNode(true));
                }
            });
        } else {
            // Show all batches
            allBatches.forEach(option => {
                if (option.value) {
                    batchSelect.appendChild(option.cloneNode(true));
                }
            });
        }
    });
});
</script>
@endsection