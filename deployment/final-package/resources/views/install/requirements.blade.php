@extends('install.layout')

@section('step', '2')
@section('progress', '33')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-white mb-6">Server Requirements</h2>
    <p class="text-gray-300 mb-8">
        Please ensure your server meets the following requirements before proceeding.
    </p>
    
    <div class="space-y-4 mb-8">
        @foreach($requirements as $requirement)
            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    @if($requirement['check'])
                        <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                    <div>
                        <h3 class="font-semibold text-white">{{ $requirement['name'] }}</h3>
                        <p class="text-sm text-gray-400">Current: {{ $requirement['current'] }}</p>
                    </div>
                </div>
                <div class="text-right">
                    @if($requirement['check'])
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-200">
                            Passed
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-200">
                            Failed
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @php
        $allPassed = collect($requirements)->every(function($req) { return $req['check']; });
    @endphp
    
    <div class="flex justify-between">
        <a href="{{ route('install.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back
        </a>
        
        @if($allPassed)
            <a href="{{ route('install.permissions') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
                Continue
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @else
            <div class="bg-red-900/50 border border-red-700 text-red-200 px-4 py-3 rounded-lg">
                Please fix the failed requirements before continuing.
            </div>
        @endif
    </div>
</div>
@endsection