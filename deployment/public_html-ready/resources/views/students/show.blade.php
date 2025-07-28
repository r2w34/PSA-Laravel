@extends('layouts.dashboard')

@section('title', 'Student Details - ' . $student->name)
@section('page-title', 'Student Details')
@section('page-description', 'View complete student information and statistics')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $student->name }}</h1>
            <p class="text-gray-400">Student ID: {{ $student->student_id }}</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('students.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Students</span>
            </a>
            <a href="{{ route('students.edit', $student) }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-edit"></i>
                <span>Edit Student</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Student Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Student ID</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->student_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->email ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Phone</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->phone }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Date of Birth</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Gender</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ ucfirst($student->gender) }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Address</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->address ?: 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Sports & Batch Information -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-futbol text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Sports & Batch</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Sport</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->sport->name ?? 'Not assigned' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Batch</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->batch->name ?? 'Not assigned' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Admission Date</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->admission_date ? $student->admission_date->format('M d, Y') : 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $student->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="fas fa-circle w-2 h-2 mr-2"></i>
                            {{ $student->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            @if($student->emergency_contact_name || $student->emergency_contact_phone)
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-phone text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Emergency Contact</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Contact Name</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->emergency_contact_name ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Contact Phone</label>
                        <p class="text-white bg-gray-700 px-4 py-2 rounded-lg">{{ $student->emergency_contact_phone ?: 'Not provided' }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Statistics Sidebar -->
        <div class="space-y-6">
            <!-- Payment Statistics -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Payment Stats</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Total Paid</span>
                            <span class="text-green-400 font-bold">₹{{ number_format($paymentStats['total_paid']) }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Total Pending</span>
                            <span class="text-red-400 font-bold">₹{{ number_format($paymentStats['total_pending']) }}</span>
                        </div>
                    </div>
                    @if($paymentStats['last_payment'])
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="text-gray-300 text-sm mb-1">Last Payment</div>
                        <div class="text-white font-medium">₹{{ number_format($paymentStats['last_payment']->amount) }}</div>
                        <div class="text-gray-400 text-xs">{{ $paymentStats['last_payment']->payment_date->format('M d, Y') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Attendance Statistics -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Attendance</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Total Sessions</span>
                            <span class="text-white font-bold">{{ $attendanceStats['total_sessions'] }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Present</span>
                            <span class="text-green-400 font-bold">{{ $attendanceStats['present_sessions'] }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-300">Absent</span>
                            <span class="text-red-400 font-bold">{{ $attendanceStats['absent_sessions'] }}</span>
                        </div>
                    </div>
                    @if($attendanceStats['total_sessions'] > 0)
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="text-gray-300 text-sm mb-1">Attendance Rate</div>
                        <div class="text-white font-bold">{{ round(($attendanceStats['present_sessions'] / $attendanceStats['total_sessions']) * 100, 1) }}%</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('fees.create', ['student_id' => $student->id]) }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Add Payment</span>
                    </a>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-calendar-check"></i>
                        <span>Mark Attendance</span>
                    </button>
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                        <i class="fas fa-file-pdf"></i>
                        <span>Generate Report</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection