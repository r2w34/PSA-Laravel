@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')
@section('page-description', 'Welcome back! Here\'s what\'s happening at your academy today.')

@section('content')
<div class="p-4 sm:p-6 space-y-6 sm:space-y-8 max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Dashboard Overview</h1>
                <p class="text-gray-400">Welcome back! Here's what's happening at your academy today.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <button class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors w-full sm:w-auto">
                    <i class="fas fa-file-export"></i>
                    <span>Export Report</span>
                </button>
                <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors w-full sm:w-auto">
                    <i class="fas fa-user-plus"></i>
                    <span>Add Student</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gray-800 rounded-xl shadow-sm border border-gray-700 p-4 sm:p-6 mb-6 sm:mb-8">
        <h2 class="text-lg font-semibold text-white mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            <button class="h-16 sm:h-20 w-full flex flex-col items-center justify-center space-y-1 sm:space-y-2 bg-gray-700 hover:bg-purple-600 text-gray-300 hover:text-white transition-all duration-200 hover:shadow-md rounded-lg border border-gray-600">
                <i class="fas fa-user-plus text-lg sm:text-xl"></i>
                <span class="text-xs font-medium">Add Student</span>
            </button>
            <button class="h-16 sm:h-20 w-full flex flex-col items-center justify-center space-y-1 sm:space-y-2 bg-gray-700 hover:bg-green-600 text-gray-300 hover:text-white transition-all duration-200 hover:shadow-md rounded-lg border border-gray-600">
                <i class="fas fa-money-bill-wave text-lg sm:text-xl"></i>
                <span class="text-xs font-medium">Collect Fee</span>
            </button>
            <button class="h-16 sm:h-20 w-full flex flex-col items-center justify-center space-y-1 sm:space-y-2 bg-gray-700 hover:bg-blue-600 text-gray-300 hover:text-white transition-all duration-200 hover:shadow-md rounded-lg border border-gray-600">
                <i class="fas fa-calendar-check text-lg sm:text-xl"></i>
                <span class="text-xs font-medium">Mark Attendance</span>
            </button>
            <button class="h-16 sm:h-20 w-full flex flex-col items-center justify-center space-y-1 sm:space-y-2 bg-gray-700 hover:bg-purple-600 text-gray-300 hover:text-white transition-all duration-200 hover:shadow-md rounded-lg border border-gray-600">
                <i class="fas fa-file-alt text-lg sm:text-xl"></i>
                <span class="text-xs font-medium">Generate Report</span>
            </button>
            <button class="h-16 sm:h-20 w-full flex flex-col items-center justify-center space-y-1 sm:space-y-2 bg-gray-700 hover:bg-orange-600 text-gray-300 hover:text-white transition-all duration-200 hover:shadow-md rounded-lg border border-gray-600">
                <i class="fas fa-users text-lg sm:text-xl"></i>
                <span class="text-xs font-medium">View Students</span>
            </button>
            <button class="h-16 sm:h-20 w-full flex flex-col items-center justify-center space-y-1 sm:space-y-2 bg-gray-700 hover:bg-indigo-600 text-gray-300 hover:text-white transition-all duration-200 hover:shadow-md rounded-lg border border-gray-600">
                <i class="fas fa-layer-group text-lg sm:text-xl"></i>
                <span class="text-xs font-medium">Manage Batches</span>
            </button>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Active Students -->
        <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-purple-100 opacity-90">Total Active Students</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">{{ $stats['active_students'] }}</p>
                        <div class="flex items-center">
                            <span class="text-xs text-purple-100 opacity-75">+12%</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-purple-200 transition-all duration-500" style="width: 75%"></div>
                    </div>
                    <button class="text-sm text-purple-100 hover:text-white transition-colors opacity-90 hover:opacity-100">View All</button>
                </div>
            </div>
        </div>

        <!-- Revenue This Month -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-purple-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-blue-100 opacity-90">Revenue This Month</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">₹{{ number_format($stats['total_revenue']) }}</p>
                        <div class="flex items-center">
                            <span class="text-xs text-blue-100 opacity-75">+8%</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-blue-200 transition-all duration-500" style="width: 80%"></div>
                    </div>
                    <button class="text-sm text-blue-100 hover:text-white transition-colors opacity-90 hover:opacity-100">View Details</button>
                </div>
            </div>
        </div>

        <!-- Today's Attendance -->
        <div class="bg-gradient-to-br from-green-600 via-green-700 to-teal-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-green-100 opacity-90">Today's Attendance</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">85%</p>
                        <div class="flex items-center">
                            <span class="text-xs text-green-100 opacity-75">{{ $stats['total_students'] - round($stats['total_students'] * 0.85) }} absent</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-calendar-check text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-green-200 transition-all duration-500" style="width: 85%"></div>
                    </div>
                    <button class="text-sm text-green-100 hover:text-white transition-colors opacity-90 hover:opacity-100">Mark Attendance</button>
                </div>
            </div>
        </div>

        <!-- Pending Fees -->
        <div class="bg-gradient-to-br from-orange-600 via-red-600 to-pink-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-orange-100 opacity-90">Pending Fees</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">₹{{ number_format($stats['pending_payments'] * 1500) }}</p>
                        <div class="flex items-center">
                            <span class="text-xs text-orange-100 opacity-75">{{ $stats['pending_payments'] }} students</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <button class="w-full bg-white/20 hover:bg-white/30 text-white py-2 px-4 rounded-lg transition-colors shadow-sm backdrop-blur-sm">
                        Collect Fees
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 space-y-6">
            <!-- Revenue Chart -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Revenue Trends</h3>
                        <div class="flex space-x-2">
                            <button class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Monthly</button>
                            <button class="bg-gray-700 text-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition-colors">Weekly</button>
                            <button class="bg-gray-700 text-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition-colors">Daily</button>
                        </div>
                    </div>
                    <div class="h-80 bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl flex items-center justify-center relative overflow-hidden">
                        <!-- Simulated Bar Chart -->
                        <div class="absolute inset-0 flex items-end justify-center space-x-2 p-8">
                            <div class="bg-gradient-to-t from-purple-600 to-pink-500 rounded-t-lg" style="width: 20px; height: 40%"></div>
                            <div class="bg-gradient-to-t from-purple-600 to-pink-500 rounded-t-lg" style="width: 20px; height: 60%"></div>
                            <div class="bg-gradient-to-t from-purple-600 to-pink-500 rounded-t-lg" style="width: 20px; height: 80%"></div>
                            <div class="bg-gradient-to-t from-purple-600 to-pink-500 rounded-t-lg" style="width: 20px; height: 45%"></div>
                            <div class="bg-gradient-to-t from-purple-600 to-pink-500 rounded-t-lg" style="width: 20px; height: 70%"></div>
                            <div class="bg-gradient-to-t from-purple-600 to-pink-500 rounded-t-lg" style="width: 20px; height: 55%"></div>
                            <div class="bg-gradient-to-t from-purple-600 to-pink-500 rounded-t-lg" style="width: 20px; height: 90%"></div>
                        </div>
                        <div class="text-center z-10">
                            <h4 class="text-white text-lg mb-2 font-semibold">₹{{ number_format($stats['total_revenue']) }}</h4>
                            <p class="text-gray-400">Total Revenue</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sports Distribution -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-6">Sports Distribution</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Donut Chart Placeholder -->
                        <div class="flex items-center justify-center">
                            <div class="relative w-32 h-32">
                                <div class="absolute inset-0 rounded-full border-8 border-gray-600"></div>
                                <div class="absolute inset-0 rounded-full border-8 border-purple-500 border-t-transparent transform rotate-45"></div>
                                <div class="absolute inset-4 rounded-full bg-gray-800 flex items-center justify-center">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-white">100%</p>
                                        <p class="text-xs text-gray-400">Total</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sports List -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                    <span class="text-white">Cricket</span>
                                </div>
                                <span class="text-gray-400">40%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full bg-pink-500"></div>
                                    <span class="text-white">Football</span>
                                </div>
                                <span class="text-gray-400">35%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-white">Basketball</span>
                                </div>
                                <span class="text-gray-400">25%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Recent Activities -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Recent Activities</h3>
                        <button class="text-purple-400 hover:text-purple-300 text-sm font-medium">View All</button>
                    </div>
                    <div class="space-y-4">
                        @if($recentActivities->count() > 0)
                            @foreach($recentActivities as $activity)
                            <div class="flex items-center space-x-4 p-3 rounded-xl bg-gray-700/50 hover:bg-gray-700 transition-colors">
                                <div class="p-2 rounded-lg bg-gradient-to-br from-purple-600 to-pink-600">
                                    <i class="fas fa-user-plus text-white text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-white font-medium">{{ $activity->description }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                                    <i class="fas fa-calendar text-white text-xl"></i>
                                </div>
                                <p class="text-gray-400">No recent activities</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Performance Insights -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Performance Insights</h3>
                        <i class="fas fa-chart-line text-purple-400 text-xl"></i>
                    </div>
                    <div class="space-y-4">
                        <!-- Student Progress -->
                        <div class="p-4 rounded-xl bg-gradient-to-r from-purple-600/10 to-pink-600/10 border border-purple-500/20">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-white font-medium">Student Progress</span>
                                <span class="text-purple-400 font-bold">85%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="h-2 rounded-full bg-gradient-to-r from-purple-500 to-pink-500" style="width: 85%"></div>
                            </div>
                        </div>
                        
                        <!-- Attendance Rate -->
                        <div class="p-4 rounded-xl bg-gradient-to-r from-blue-600/10 to-purple-600/10 border border-blue-500/20">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-white font-medium">Attendance Rate</span>
                                <span class="text-blue-400 font-bold">92%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-500" style="width: 92%"></div>
                            </div>
                        </div>
                        
                        <!-- Fee Collection -->
                        <div class="p-4 rounded-xl bg-gradient-to-r from-green-600/10 to-teal-600/10 border border-green-500/20">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-white font-medium">Fee Collection</span>
                                <span class="text-green-400 font-bold">78%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="h-2 rounded-full bg-gradient-to-r from-green-500 to-teal-500" style="width: 78%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection