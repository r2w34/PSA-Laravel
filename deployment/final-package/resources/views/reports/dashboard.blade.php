@extends('layouts.dashboard')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header with Date Range -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Analytics Dashboard</h1>
            <p class="text-gray-400 mt-1">Comprehensive business intelligence overview</p>
        </div>
        <div class="flex space-x-3">
            <form method="GET" class="flex space-x-3">
                <input type="date" name="start_date" value="{{ $startDate }}" class="bg-gray-700 text-white px-3 py-2 rounded-lg border border-gray-600">
                <input type="date" name="end_date" value="{{ $endDate }}" class="bg-gray-700 text-white px-3 py-2 rounded-lg border border-gray-600">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </form>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Revenue</p>
                    <p class="text-2xl font-bold text-white">₹{{ number_format($revenueData['total_revenue']) }}</p>
                    <p class="text-green-400 text-sm">Avg: ₹{{ number_format($revenueData['avg_payment']) }}</p>
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
                    <p class="text-2xl font-bold text-white">{{ $studentData['total_students'] }}</p>
                    <p class="text-blue-400 text-sm">New: {{ $studentData['new_students'] }}</p>
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
                    <p class="text-2xl font-bold text-white">{{ number_format($attendanceData['overall_rate'], 1) }}%</p>
                    <p class="text-yellow-400 text-sm">{{ $attendanceData['present_sessions'] }}/{{ $attendanceData['total_sessions'] }} sessions</p>
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
                    <p class="text-2xl font-bold text-white">{{ number_format($feeData['collection_rate'], 1) }}%</p>
                    <p class="text-purple-400 text-sm">₹{{ number_format($feeData['collected_fees']) }} collected</p>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-lg">
                    <i class="fas fa-money-bill-wave text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Trends -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-white">Revenue Trends</h2>
                <div class="flex space-x-2">
                    <button class="text-sm bg-gray-700 text-white px-3 py-1 rounded">Monthly</button>
                    <button class="text-sm text-gray-400 px-3 py-1 rounded">Weekly</button>
                </div>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Sports Distribution -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-white">Sports Distribution</h2>
                <button class="text-sm text-purple-400">View Details</button>
            </div>
            <div class="space-y-4">
                @foreach($sportsData['sports_popularity'] as $sport)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-white">{{ $sport->name }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-gray-400">{{ $sport->students_count }} students</span>
                        <div class="w-20 bg-gray-700 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: {{ ($sport->students_count / $studentData['total_students']) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Detailed Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Fee Collection Details -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <h3 class="text-lg font-semibold text-white mb-4">Fee Collection Breakdown</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Total Fees</span>
                    <span class="text-white font-semibold">₹{{ number_format($feeData['total_fees']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Collected</span>
                    <span class="text-green-400 font-semibold">₹{{ number_format($feeData['collected_fees']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Pending</span>
                    <span class="text-yellow-400 font-semibold">₹{{ number_format($feeData['pending_fees']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Overdue</span>
                    <span class="text-red-400 font-semibold">₹{{ number_format($feeData['overdue_fees']) }}</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3 mt-4">
                    <div class="bg-green-500 h-3 rounded-full" style="width: {{ $feeData['collection_rate'] }}%"></div>
                </div>
            </div>
        </div>

        <!-- Attendance by Sport -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <h3 class="text-lg font-semibold text-white mb-4">Attendance by Sport</h3>
            <div class="space-y-3">
                @foreach($attendanceData['attendance_by_sport'] as $sport)
                <div class="flex items-center justify-between">
                    <span class="text-gray-300">{{ $sport->sport_name }}</span>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-400">{{ $sport->attendance_rate }}%</span>
                        <div class="w-16 bg-gray-700 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $sport->attendance_rate }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Age Distribution -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <h3 class="text-lg font-semibold text-white mb-4">Student Age Distribution</h3>
            <div class="space-y-3">
                @foreach($studentData['age_distribution'] as $age)
                <div class="flex items-center justify-between">
                    <span class="text-gray-300">{{ $age->age_group }}</span>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-400">{{ $age->count }} students</span>
                        <div class="w-16 bg-gray-700 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($age->count / $studentData['total_students']) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-white">Export Analytics</h3>
                <p class="text-gray-400 text-sm">Download comprehensive reports for the selected period</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('reports.export', ['type' => 'revenue', 'format' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </a>
                <a href="{{ route('reports.export', ['type' => 'revenue', 'format' => 'excel', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            @foreach($revenueData['monthly_revenue'] as $month)
                '{{ date("M Y", mktime(0, 0, 0, $month->month, 1, $month->year)) }}',
            @endforeach
        ],
        datasets: [{
            label: 'Revenue',
            data: [
                @foreach($revenueData['monthly_revenue'] as $month)
                    {{ $month->total }},
                @endforeach
            ],
            borderColor: 'rgb(147, 51, 234)',
            backgroundColor: 'rgba(147, 51, 234, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                }
            },
            x: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                }
            }
        }
    }
});
</script>
@endsection