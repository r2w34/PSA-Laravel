@extends('layouts.dashboard')

@section('title', 'Edit ' . $sport->name)
@section('page-title', 'Edit ' . $sport->name)
@section('page-description', 'Update sport information and fee structure')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Edit {{ $sport->name }}</h1>
            <p class="text-gray-400">Update sport information and fee structure</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('sports.show', $sport) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-eye"></i>
                <span>View Sport</span>
            </a>
            <a href="{{ route('sports.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Sports</span>
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6 lg:p-8">
        <form action="{{ route('sports.update', $sport) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-futbol text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Sport Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-300">
                            Sport Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $sport->name) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('name') border-red-500 @enderror"
                               placeholder="Enter sport name (e.g., Cricket, Football)">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            Status
                        </label>
                        <div class="flex items-center space-x-3 bg-gray-700 border border-gray-600 rounded-lg px-4 py-3">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $sport->is_active) ? 'checked' : '' }}
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
                    <textarea id="description" name="description" rows="4"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors resize-none @error('description') border-red-500 @enderror"
                              placeholder="Enter sport description, rules, or additional information...">{{ old('description', $sport->description) }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Fee Structure Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-rupee-sign text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Fee Structure</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Monthly Fee -->
                    <div class="space-y-2">
                        <label for="fee_structure_monthly" class="block text-sm font-medium text-gray-300">
                            Monthly Fee (₹)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">₹</span>
                            <input type="number" id="fee_structure_monthly" name="fee_structure[monthly]" 
                                   value="{{ old('fee_structure.monthly', $sport->fee_structure['monthly'] ?? '') }}" 
                                   min="0" step="0.01"
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-8 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('fee_structure.monthly') border-red-500 @enderror"
                                   placeholder="0.00">
                        </div>
                        @error('fee_structure.monthly')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quarterly Fee -->
                    <div class="space-y-2">
                        <label for="fee_structure_quarterly" class="block text-sm font-medium text-gray-300">
                            Quarterly Fee (₹)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">₹</span>
                            <input type="number" id="fee_structure_quarterly" name="fee_structure[quarterly]" 
                                   value="{{ old('fee_structure.quarterly', $sport->fee_structure['quarterly'] ?? '') }}" 
                                   min="0" step="0.01"
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-8 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('fee_structure.quarterly') border-red-500 @enderror"
                                   placeholder="0.00">
                        </div>
                        @error('fee_structure.quarterly')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Yearly Fee -->
                    <div class="space-y-2">
                        <label for="fee_structure_yearly" class="block text-sm font-medium text-gray-300">
                            Yearly Fee (₹)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">₹</span>
                            <input type="number" id="fee_structure_yearly" name="fee_structure[yearly]" 
                                   value="{{ old('fee_structure.yearly', $sport->fee_structure['yearly'] ?? '') }}" 
                                   min="0" step="0.01"
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-8 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors @error('fee_structure.yearly') border-red-500 @enderror"
                                   placeholder="0.00">
                        </div>
                        @error('fee_structure.yearly')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-900 bg-opacity-30 border border-blue-700 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-400 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm text-blue-300">
                            <p class="font-medium mb-2">Fee Structure Guidelines:</p>
                            <ul class="list-disc list-inside space-y-1 text-blue-200">
                                <li>You can update fees for different payment periods</li>
                                <li>Leave fields empty if that payment option is not available</li>
                                <li>Changes will affect new enrollments only</li>
                                <li>Existing student fees remain unchanged</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-8 border-t border-gray-700">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-3 rounded-lg flex items-center justify-center space-x-2 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-save"></i>
                    <span>Update Sport</span>
                </button>
                <a href="{{ route('sports.show', $sport) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-3 rounded-lg flex items-center justify-center space-x-2 transition-all duration-200 font-medium">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
                
                <!-- Delete Button (Admin Only) -->
                @if(auth()->user()->hasRole('admin'))
                <div class="sm:ml-auto">
                    <button type="button" onclick="confirmDelete()" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg flex items-center justify-center space-x-2 transition-all duration-200 font-medium">
                        <i class="fas fa-trash"></i>
                        <span>Delete Sport</span>
                    </button>
                </div>
                @endif
            </div>
        </form>

        <!-- Delete Form (Hidden) -->
        @if(auth()->user()->hasRole('admin'))
        <form id="delete-form" action="{{ route('sports.destroy', $sport) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
        @endif
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this sport? This action cannot be undone and will affect all related batches and students.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection