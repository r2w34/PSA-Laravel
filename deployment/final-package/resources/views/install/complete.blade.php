@extends('install.layout')

@section('step', '6')
@section('progress', '100')

@section('content')
<div class="text-center">
    <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
    </div>
    
    <h2 class="text-3xl font-bold text-white mb-4">Installation Complete!</h2>
    <p class="text-gray-300 mb-8 text-lg">
        Congratulations! PSA Sports Academy Management System has been successfully installed.
    </p>
    
    <div class="bg-gray-700 rounded-lg p-6 mb-8 text-left">
        <h3 class="text-lg font-semibold text-white mb-4">What's Next?</h3>
        <ul class="space-y-3 text-gray-300">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong>Login to your dashboard</strong> - Use the administrator credentials you just created
                </div>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong>Configure sports and batches</strong> - Set up your academy's sports programs
                </div>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong>Add coaches and students</strong> - Start building your academy database
                </div>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong>Set up WhatsApp integration</strong> - Configure automated notifications
                </div>
            </li>
        </ul>
    </div>
    
    <div class="bg-blue-900/50 border border-blue-700 text-blue-200 px-4 py-3 rounded-lg mb-8">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-semibold mb-1">Security Reminder</h4>
                <p class="text-sm">For security reasons, the installation files have been disabled. If you need to reinstall, delete the <code class="bg-gray-800 px-1 rounded">storage/installed</code> file.</p>
            </div>
        </div>
    </div>
    
    <div class="flex justify-center space-x-4">
        <a href="/login" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Login to Dashboard
        </a>
        
        <a href="/api/documentation" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            API Documentation
        </a>
    </div>
</div>
@endsection