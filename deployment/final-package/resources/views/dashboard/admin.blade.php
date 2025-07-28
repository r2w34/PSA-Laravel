@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')
@section('page-description', 'Welcome back! Here\'s what\'s happening at your academy today.')

@section('content')
<div class="space-y-6 lg:space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl p-6 lg:p-8 shadow-xl">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Dashboard Overview</h1>
                <p class="text-blue-100 opacity-90">Welcome back! Here's what's happening at your academy today.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button class="btn-primary bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-xl flex items-center justify-center space-x-2 transition-all duration-300 backdrop-blur-sm border border-white/20">
                    <i class="fas fa-file-export"></i>
                    <span>Export Report</span>
                </button>
                <button class="btn-primary bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl flex items-center justify-center space-x-2 transition-all duration-300 shadow-lg">
                    <i class="fas fa-user-plus"></i>
                    <span>Add Student</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="metric-card">
        <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
            <i class="fas fa-bolt text-blue-400 mr-3"></i>
            Quick Actions
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <button class="group h-20 lg:h-24 w-full flex flex-col items-center justify-center space-y-2 bg-gradient-to-br from-slate-700 to-slate-800 hover:from-blue-600 hover:to-blue-700 text-gray-300 hover:text-white transition-all duration-300 hover:shadow-lg hover:scale-105 rounded-xl border border-slate-600 hover:border-blue-500">
                <i class="fas fa-user-plus text-xl group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-xs font-medium">Add Student</span>
            </button>
            <button class="group h-20 lg:h-24 w-full flex flex-col items-center justify-center space-y-2 bg-gradient-to-br from-slate-700 to-slate-800 hover:from-green-600 hover:to-green-700 text-gray-300 hover:text-white transition-all duration-300 hover:shadow-lg hover:scale-105 rounded-xl border border-slate-600 hover:border-green-500">
                <i class="fas fa-money-bill-wave text-xl group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-xs font-medium">Collect Fee</span>
            </button>
            <button class="group h-20 lg:h-24 w-full flex flex-col items-center justify-center space-y-2 bg-gradient-to-br from-slate-700 to-slate-800 hover:from-purple-600 hover:to-purple-700 text-gray-300 hover:text-white transition-all duration-300 hover:shadow-lg hover:scale-105 rounded-xl border border-slate-600 hover:border-purple-500">
                <i class="fas fa-calendar-check text-xl group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-xs font-medium">Mark Attendance</span>
            </button>
            <button class="group h-20 lg:h-24 w-full flex flex-col items-center justify-center space-y-2 bg-gradient-to-br from-slate-700 to-slate-800 hover:from-indigo-600 hover:to-indigo-700 text-gray-300 hover:text-white transition-all duration-300 hover:shadow-lg hover:scale-105 rounded-xl border border-slate-600 hover:border-indigo-500">
                <i class="fas fa-file-alt text-xl group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-xs font-medium">Generate Report</span>
            </button>
            <button class="group h-20 lg:h-24 w-full flex flex-col items-center justify-center space-y-2 bg-gradient-to-br from-slate-700 to-slate-800 hover:from-orange-600 hover:to-orange-700 text-gray-300 hover:text-white transition-all duration-300 hover:shadow-lg hover:scale-105 rounded-xl border border-slate-600 hover:border-orange-500">
                <i class="fas fa-users text-xl group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-xs font-medium">View Students</span>
            </button>
            <button class="group h-20 lg:h-24 w-full flex flex-col items-center justify-center space-y-2 bg-gradient-to-br from-slate-700 to-slate-800 hover:from-teal-600 hover:to-teal-700 text-gray-300 hover:text-white transition-all duration-300 hover:shadow-lg hover:scale-105 rounded-xl border border-slate-600 hover:border-teal-500">
                <i class="fas fa-layer-group text-xl group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-xs font-medium">Manage Batches</span>
            </button>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Active Students -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-blue-100 opacity-90">Total Active Students</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">{{ $stats['active_students'] }}</p>
                        <div class="flex items-center">
                            <i class="fas fa-arrow-up text-green-400 text-xs mr-1"></i>
                            <span class="text-xs text-blue-100 opacity-75">+12%</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-blue-200 transition-all duration-500" style="width: 75%"></div>
                    </div>
                    <button class="text-sm text-blue-100 hover:text-white transition-colors opacity-90 hover:opacity-100 flex items-center">
                        <span>View All</span>
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Revenue This Month -->
        <div class="bg-gradient-to-br from-emerald-600 via-green-700 to-teal-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-emerald-100 opacity-90">Revenue This Month</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">₹{{ number_format($stats['total_revenue']) }}</p>
                        <div class="flex items-center">
                            <i class="fas fa-arrow-up text-green-300 text-xs mr-1"></i>
                            <span class="text-xs text-emerald-100 opacity-75">+8%</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-emerald-200 transition-all duration-500" style="width: 80%"></div>
                    </div>
                    <button class="text-sm text-emerald-100 hover:text-white transition-colors opacity-90 hover:opacity-100 flex items-center">
                        <span>View Details</span>
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Today's Attendance -->
        <div class="bg-gradient-to-br from-purple-600 via-indigo-700 to-blue-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-purple-100 opacity-90">Today's Attendance</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">85%</p>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 text-xs mr-1"></i>
                            <span class="text-xs text-purple-100 opacity-75">{{ $stats['total_students'] - round($stats['total_students'] * 0.85) }} absent</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-calendar-check text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-purple-200 transition-all duration-500" style="width: 85%"></div>
                    </div>
                    <button class="text-sm text-purple-100 hover:text-white transition-colors opacity-90 hover:opacity-100 flex items-center">
                        <span>Mark Attendance</span>
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Pending Fees -->
        <div class="bg-gradient-to-br from-orange-600 via-red-600 to-pink-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-orange-100 opacity-90">Pending Fees</p>
                        <p class="text-3xl font-bold text-white mt-2 mb-1">₹{{ number_format($stats['pending_payments'] * 1500) }}</p>
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-400 text-xs mr-1"></i>
                            <span class="text-xs text-orange-100 opacity-75">{{ $stats['pending_payments'] }} students</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-white to-orange-200 transition-all duration-500" style="width: 60%"></div>
                    </div>
                    <button class="text-sm text-orange-100 hover:text-white transition-colors opacity-90 hover:opacity-100 flex items-center">
                        <span>Collect Fees</span>
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
        <div class="xl:col-span-2 space-y-6">
            <!-- Revenue Chart -->
            <div class="metric-card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-line text-blue-400 mr-3"></i>
                        Revenue Trends
                    </h3>
                    <div class="flex space-x-2">
                        <button class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-lg">Monthly</button>
                        <button class="bg-slate-700 text-slate-300 px-4 py-2 rounded-lg text-sm hover:bg-slate-600 transition-colors">Weekly</button>
                        <button class="bg-slate-700 text-slate-300 px-4 py-2 rounded-lg text-sm hover:bg-slate-600 transition-colors">Daily</button>
                    </div>
                </div>
                <div class="h-80 bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl flex items-center justify-center relative overflow-hidden border border-slate-600">
                    <!-- Simulated Bar Chart -->
                    <div class="absolute inset-0 flex items-end justify-center space-x-3 p-8">
                        <div class="bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg shadow-lg" style="width: 24px; height: 40%"></div>
                        <div class="bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg shadow-lg" style="width: 24px; height: 60%"></div>
                        <div class="bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg shadow-lg" style="width: 24px; height: 80%"></div>
                        <div class="bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg shadow-lg" style="width: 24px; height: 45%"></div>
                        <div class="bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg shadow-lg" style="width: 24px; height: 70%"></div>
                        <div class="bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg shadow-lg" style="width: 24px; height: 55%"></div>
                        <div class="bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg shadow-lg" style="width: 24px; height: 90%"></div>
                    </div>
                    <div class="text-center z-10">
                        <h4 class="text-white text-2xl mb-2 font-bold">₹{{ number_format($stats['total_revenue']) }}</h4>
                        <p class="text-slate-400">Total Revenue</p>
                    </div>
                </div>
            </div>

            <!-- Sports Distribution -->
            <div class="metric-card">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-chart-pie text-blue-400 mr-3"></i>
                    Sports Distribution
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Donut Chart Placeholder -->
                    <div class="flex items-center justify-center">
                        <div class="relative w-36 h-36">
                            <div class="absolute inset-0 rounded-full border-8 border-slate-600"></div>
                            <div class="absolute inset-0 rounded-full border-8 border-blue-500 border-t-transparent transform rotate-45"></div>
                            <div class="absolute inset-4 rounded-full bg-slate-800 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-white">100%</p>
                                    <p class="text-xs text-slate-400">Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sports List -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                                <span class="text-white font-medium">Cricket</span>
                            </div>
                            <span class="text-slate-300 font-semibold">40%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                <span class="text-white font-medium">Football</span>
                            </div>
                            <span class="text-slate-300 font-semibold">35%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded-full bg-purple-500"></div>
                                <span class="text-white font-medium">Basketball</span>
                            </div>
                            <span class="text-slate-300 font-semibold">25%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Recent Activities -->
            <div class="metric-card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clock text-blue-400 mr-3"></i>
                        Recent Activities
                    </h3>
                    <button class="text-blue-400 hover:text-blue-300 text-sm font-medium flex items-center">
                        <span>View All</span>
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    @if(isset($recentActivities) && $recentActivities->count() > 0)
                        @foreach($recentActivities as $activity)
                        <div class="flex items-center space-x-4 p-4 rounded-xl bg-slate-700/50 hover:bg-slate-700 transition-all duration-300 border border-slate-600/50">
                            <div class="p-2 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 shadow-lg">
                                <i class="fas fa-user-plus text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-white font-medium">{{ $activity->description }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg">
                                <i class="fas fa-calendar text-white text-xl"></i>
                            </div>
                            <p class="text-slate-400">No recent activities</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Performance Insights -->
            <div class="metric-card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-line text-blue-400 mr-3"></i>
                        Performance Insights
                    </h3>
                    <i class="fas fa-chart-line text-blue-400 text-xl"></i>
                </div>
                <div class="space-y-4">
                    <!-- Student Progress -->
                    <div class="p-4 rounded-xl bg-gradient-to-r from-blue-600/10 to-indigo-600/10 border border-blue-500/20 hover:border-blue-400/40 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-white font-medium flex items-center">
                                <i class="fas fa-graduation-cap text-blue-400 mr-2"></i>
                                Student Progress
                            </span>
                            <span class="text-blue-400 font-bold text-lg">85%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="h-3 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 shadow-lg" style="width: 85%"></div>
                        </div>
                    </div>
                    
                    <!-- Attendance Rate -->
                    <div class="p-4 rounded-xl bg-gradient-to-r from-green-600/10 to-emerald-600/10 border border-green-500/20 hover:border-green-400/40 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-white font-medium flex items-center">
                                <i class="fas fa-calendar-check text-green-400 mr-2"></i>
                                Attendance Rate
                            </span>
                            <span class="text-green-400 font-bold text-lg">92%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="h-3 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 shadow-lg" style="width: 92%"></div>
                        </div>
                    </div>
                    
                    <!-- Fee Collection -->
                    <div class="p-4 rounded-xl bg-gradient-to-r from-orange-600/10 to-red-600/10 border border-orange-500/20 hover:border-orange-400/40 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-white font-medium flex items-center">
                                <i class="fas fa-money-bill-wave text-orange-400 mr-2"></i>
                                Fee Collection
                            </span>
                            <span class="text-orange-400 font-bold text-lg">78%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="h-3 rounded-full bg-gradient-to-r from-orange-500 to-red-500 shadow-lg" style="width: 78%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection