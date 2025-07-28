@extends('install.layout')

@section('step', '5')
@section('progress', '83')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-white mb-6">Database Installation</h2>
    <p class="text-gray-300 mb-8">
        Ready to install the database tables and configure your application.
    </p>
    
    <div class="bg-gray-700 rounded-lg p-6 mb-8">
        <h3 class="text-lg font-semibold text-white mb-4">What will be installed:</h3>
        <ul class="space-y-2 text-gray-300">
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Database tables for users, students, coaches, and more
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Role and permission system
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                API authentication setup (Passport)
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Default application settings
            </li>
        </ul>
    </div>
    
    <div class="bg-yellow-900/50 border border-yellow-700 text-yellow-200 px-4 py-3 rounded-lg mb-8">
        <div class="flex">
            <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <h4 class="font-semibold mb-1">Important Notice</h4>
                <p class="text-sm">This process will create new database tables. Make sure you have a backup if you're installing over an existing database.</p>
            </div>
        </div>
    </div>
    
    <form method="POST" action="{{ route('install.database.install') }}">
        @csrf
        <div class="flex justify-between">
            <a href="{{ route('install.environment') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back
            </a>
            
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center" id="installBtn">
                <span id="installText">Install Database</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="installIcon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                <svg class="w-5 h-5 ml-2 animate-spin hidden" id="loadingIcon" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('installBtn').addEventListener('click', function() {
    this.disabled = true;
    document.getElementById('installText').textContent = 'Installing...';
    document.getElementById('installIcon').classList.add('hidden');
    document.getElementById('loadingIcon').classList.remove('hidden');
});
</script>
@endsection