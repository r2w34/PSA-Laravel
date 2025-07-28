@extends('layouts.dashboard')

@section('title', 'Advanced Reports')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Advanced Reports</h1>
            <p class="text-gray-400 mt-1">Comprehensive business intelligence and analytics</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('reports.dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-chart-line mr-2"></i>
                Analytics Dashboard
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Revenue</p>
                    <p class="text-2xl font-bold text-white">₹{{ number_format($totalRevenue ?? 0) }}</p>
                    <p class="text-green-400 text-sm">+12% from last month</p>
                </div>
                <div class="bg-green-500/20 p-3 rounded-lg">
                    <i class="fas fa-rupee-sign text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Active Students</p>
                    <p class="text-2xl font-bold text-white">{{ $totalStudents ?? 0 }}</p>
                    <p class="text-blue-400 text-sm">+8% from last month</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-lg">
                    <i class="fas fa-users text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Attendance Rate</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($attendanceRate ?? 85, 1) }}%</p>
                    <p class="text-yellow-400 text-sm">-2% from last month</p>
                </div>
                <div class="bg-yellow-500/20 p-3 rounded-lg">
                    <i class="fas fa-calendar-check text-yellow-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Fee Collection</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($collectionRate ?? 78, 1) }}%</p>
                    <p class="text-purple-400 text-sm">+5% from last month</p>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-lg">
                    <i class="fas fa-money-bill-wave text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Revenue Reports -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-green-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-chart-line text-green-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Revenue Analytics</h3>
                    <p class="text-gray-400 text-sm">Income trends and financial insights</p>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('reports.revenue') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    View Revenue Reports
                </a>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Student Reports -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-blue-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-users text-blue-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Student Analytics</h3>
                    <p class="text-gray-400 text-sm">Enrollment and demographic insights</p>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('reports.students') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    View Student Reports
                </a>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Attendance Reports -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-calendar-check text-yellow-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Attendance Analytics</h3>
                    <p class="text-gray-400 text-sm">Participation and engagement metrics</p>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('reports.attendance') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    View Attendance Reports
                </a>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Fee Reports -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-purple-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-purple-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Fee Collection Analytics</h3>
                    <p class="text-gray-400 text-sm">Payment tracking and collection rates</p>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('reports.fees') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    View Fee Reports
                </a>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Performance Reports -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-red-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-trophy text-red-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Performance Analytics</h3>
                    <p class="text-gray-400 text-sm">Sports and coaching effectiveness</p>
                </div>
            </div>
            <div class="space-y-3">
                <button class="block w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    View Performance Reports
                </button>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Custom Reports -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-indigo-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-cogs text-indigo-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Custom Reports</h3>
                    <p class="text-gray-400 text-sm">Build your own analytics reports</p>
                </div>
            </div>
            <div class="space-y-3">
                <button class="block w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    Create Custom Report
                </button>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-plus mr-1"></i> New
                    </button>
                    <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-3 rounded text-sm">
                        <i class="fas fa-save mr-1"></i> Templates
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reports -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-white">Recent Reports</h2>
            <button class="text-purple-400 hover:text-purple-300 text-sm">View All</button>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <div class="bg-green-500/20 p-2 rounded mr-3">
                        <i class="fas fa-chart-line text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium">Monthly Revenue Report</p>
                        <p class="text-gray-400 text-sm">Generated on {{ date('M d, Y') }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-share"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <div class="bg-blue-500/20 p-2 rounded mr-3">
                        <i class="fas fa-users text-blue-400"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium">Student Enrollment Analysis</p>
                        <p class="text-gray-400 text-sm">Generated on {{ date('M d, Y', strtotime('-1 day')) }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-share"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <div class="bg-yellow-500/20 p-2 rounded mr-3">
                        <i class="fas fa-calendar-check text-yellow-400"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium">Weekly Attendance Summary</p>
                        <p class="text-gray-400 text-sm">Generated on {{ date('M d, Y', strtotime('-2 days')) }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-share"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection