<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Student Management Routes
    Route::resource('students', StudentController::class);
    Route::get('/students-export', [StudentController::class, 'export'])->name('students.export');
    
    // Fee Management Routes
    Route::resource('fees', FeeController::class);
    Route::get('/fees-export', [FeeController::class, 'export'])->name('fees.export');
    Route::patch('/fees/{fee}/mark-completed', [FeeController::class, 'markCompleted'])->name('fees.mark-completed');
    Route::get('/fees/{fee}/receipt', [FeeController::class, 'receipt'])->name('fees.receipt');
    Route::get('/api/student-outstanding', [FeeController::class, 'getStudentOutstanding'])->name('api.student-outstanding');
    
    // Coach Management Routes
    Route::resource('coaches', CoachController::class);
    Route::get('/coaches-export', [CoachController::class, 'export'])->name('coaches.export');
    Route::patch('/coaches/{coach}/toggle-status', [CoachController::class, 'toggleStatus'])->name('coaches.toggle-status');
    
    // Sport Management Routes
    Route::resource('sports', SportController::class);
    Route::get('/sports-export', [SportController::class, 'export'])->name('sports.export');
    Route::patch('/sports/{sport}/toggle-status', [SportController::class, 'toggleStatus'])->name('sports.toggle-status');
    
    // Batch Management Routes
    Route::resource('batches', BatchController::class);
    Route::get('/batches-export', [BatchController::class, 'export'])->name('batches.export');
    Route::patch('/batches/{batch}/toggle-status', [BatchController::class, 'toggleStatus'])->name('batches.toggle-status');
    
    // Attendance Management Routes
    Route::resource('attendance', AttendanceController::class);
    Route::get('/attendance-export', [AttendanceController::class, 'export'])->name('attendance.export');
    Route::get('/attendance/mark/batch', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::post('/attendance/bulk-update', [AttendanceController::class, 'updateBulk'])->name('attendance.bulk-update');
    
    // Inquiry Management Routes
    Route::resource('inquiries', InquiryController::class);
    Route::get('/inquiries-export', [InquiryController::class, 'export'])->name('inquiries.export');
    Route::post('/inquiries/{inquiry}/convert', [InquiryController::class, 'convertToStudent'])->name('inquiries.convert');
    Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.update-status');
    
    // Payment Management Routes
    Route::resource('payments', PaymentController::class);
    Route::get('/payments-export', [PaymentController::class, 'export'])->name('payments.export');
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
