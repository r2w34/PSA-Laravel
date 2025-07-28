@extends('install.layout')

@section('step', '3')
@section('progress', '50')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-white mb-6">Directory Permissions</h2>
    <p class="text-gray-300 mb-8">
        Please ensure the following directories are writable by the web server.
    </p>
    
    <div class="space-y-4 mb-8">
        @foreach($permissions as $permission)
            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    @if($permission['check'])
                        <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                    <div>
                        <h3 class="font-semibold text-white">{{ $permission['name'] }}</h3>
                        <p class="text-sm text-gray-400 font-mono">{{ $permission['path'] }}</p>
                    </div>
                </div>
                <div class="text-right">
                    @if($permission['check'])
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-200">
                            Writable
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-200">
                            Not Writable
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @php
        $allPassed = collect($permissions)->every(function($perm) { return $perm['check']; });
    @endphp
    
    @if(!$allPassed)
        <div class="bg-yellow-900/50 border border-yellow-700 text-yellow-200 px-4 py-3 rounded-lg mb-6">
            <h4 class="font-semibold mb-2">Fix Permissions:</h4>
            <p class="text-sm mb-2">Run the following commands to fix directory permissions:</p>
            <code class="block bg-gray-800 p-2 rounded text-xs font-mono">
                chmod -R 755 storage/<br>
                chmod -R 755 bootstrap/cache/
            </code>
        </div>
    @endif
    
    <div class="flex justify-between">
        <a href="{{ route('install.requirements') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back
        </a>
        
        @if($allPassed)
            <a href="{{ route('install.environment') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
                Continue
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @else
            <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200" onclick="location.reload()">
                Refresh Check
            </button>
        @endif
    </div>
</div>
@endsection