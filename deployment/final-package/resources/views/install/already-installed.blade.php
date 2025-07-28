@extends('install.layout')

@section('title', 'Already Installed')

@section('content')
<div class="text-center">
    <div class="mb-8">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Already Installed</h2>
        <p class="text-gray-600 mb-8">PSA Sports Academy Management System is already installed and configured.</p>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div class="text-left">
                <h3 class="text-lg font-semibold text-yellow-800">Installation Complete</h3>
                <p class="text-yellow-700">The application has been successfully installed and is ready to use.</p>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Go to Login
        </a>
        
        <div class="text-sm text-gray-500">
            <p>If you need to reinstall, please delete the <code class="bg-gray-100 px-2 py-1 rounded">storage/installed</code> file first.</p>
        </div>
    </div>
</div>
@endsection