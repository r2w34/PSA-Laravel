@extends('install.layout')

@section('step', '1')
@section('progress', '16')

@section('content')
<div class="text-center">
    <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
    </div>
    
    <h2 class="text-3xl font-bold text-white mb-4">Welcome to PSA Sports Academy</h2>
    <p class="text-gray-300 mb-8 text-lg">
        Thank you for choosing PSA Sports Academy Management System. This installation wizard will guide you through the setup process.
    </p>
    
    <div class="bg-gray-700 rounded-lg p-6 mb-8 text-left">
        <h3 class="text-lg font-semibold text-white mb-4">What you'll need:</h3>
        <ul class="space-y-2 text-gray-300">
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                MySQL database credentials
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Administrator account details
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                5-10 minutes of your time
            </li>
        </ul>
    </div>
    
    <div class="flex justify-center">
        <a href="{{ route('install.requirements') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
            Get Started
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>
@endsection