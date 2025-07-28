@extends('install.layout')

@section('step', '4')
@section('progress', '66')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-white mb-6">Environment Configuration</h2>
    <p class="text-gray-300 mb-8">
        Configure your application settings and database connection.
    </p>
    
    <form method="POST" action="{{ route('install.environment.save') }}" class="space-y-6">
        @csrf
        
        <!-- Application Settings -->
        <div class="bg-gray-700 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Application Settings</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="app_name" class="block text-sm font-medium text-gray-300 mb-2">Application Name</label>
                    <input type="text" id="app_name" name="app_name" value="{{ old('app_name', 'PSA Sports Academy') }}" 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    @error('app_name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="app_url" class="block text-sm font-medium text-gray-300 mb-2">Application URL</label>
                    <input type="url" id="app_url" name="app_url" value="{{ old('app_url', request()->getSchemeAndHttpHost()) }}" 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    @error('app_url')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Database Settings -->
        <div class="bg-gray-700 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Database Configuration</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="db_host" class="block text-sm font-medium text-gray-300 mb-2">Database Host</label>
                    <input type="text" id="db_host" name="db_host" value="{{ old('db_host', '127.0.0.1') }}" 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    @error('db_host')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="db_port" class="block text-sm font-medium text-gray-300 mb-2">Database Port</label>
                    <input type="number" id="db_port" name="db_port" value="{{ old('db_port', '3306') }}" 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    @error('db_port')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="db_database" class="block text-sm font-medium text-gray-300 mb-2">Database Name</label>
                    <input type="text" id="db_database" name="db_database" value="{{ old('db_database') }}" 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    @error('db_database')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="db_username" class="block text-sm font-medium text-gray-300 mb-2">Database Username</label>
                    <input type="text" id="db_username" name="db_username" value="{{ old('db_username') }}" 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    @error('db_username')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="db_password" class="block text-sm font-medium text-gray-300 mb-2">Database Password</label>
                    <input type="password" id="db_password" name="db_password" value="{{ old('db_password') }}" 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('db_password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="flex justify-between">
            <a href="{{ route('install.permissions') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back
            </a>
            
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
                Save & Continue
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </form>
</div>
@endsection