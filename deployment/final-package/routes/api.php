<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\CoachController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes (authentication required)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    
    // Authentication routes
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    Route::put('/user/password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

    // Student routes
    Route::apiResource('students', StudentController::class)->names([
        'index' => 'api.students.index',
        'store' => 'api.students.store',
        'show' => 'api.students.show',
        'update' => 'api.students.update',
        'destroy' => 'api.students.destroy'
    ]);
    Route::get('/students-statistics', [StudentController::class, 'statistics']);
    Route::get('/students-sports', [StudentController::class, 'sports']);
    Route::get('/students-batches', [StudentController::class, 'batches']);

    // Payment routes
    Route::apiResource('payments', PaymentController::class)->names([
        'index' => 'api.payments.index',
        'store' => 'api.payments.store',
        'show' => 'api.payments.show',
        'update' => 'api.payments.update',
        'destroy' => 'api.payments.destroy'
    ]);
    Route::get('/payments-statistics', [PaymentController::class, 'statistics']);
    Route::get('/payments-students', [PaymentController::class, 'students']);
    Route::get('/payments-batches', [PaymentController::class, 'batches']);
    Route::get('/payments-student/{studentId}', [PaymentController::class, 'studentPayments']);
    Route::get('/payments/{id}/receipt', [PaymentController::class, 'receipt']);

    // Coach routes
    Route::apiResource('coaches', CoachController::class)->names([
        'index' => 'api.coaches.index',
        'store' => 'api.coaches.store',
        'show' => 'api.coaches.show',
        'update' => 'api.coaches.update',
        'destroy' => 'api.coaches.destroy'
    ]);
    Route::get('/coaches-statistics', [CoachController::class, 'statistics']);
    Route::get('/coaches-sports', [CoachController::class, 'sports']);

    // Dashboard/Statistics routes
    Route::get('/dashboard-stats', function () {
        $stats = [
            'students' => [
                'total' => \App\Models\Student::count(),
                'active' => \App\Models\Student::where('status', 'active')->count(),
                'new_this_month' => \App\Models\Student::whereMonth('created_at', now()->month)->count(),
            ],
            'payments' => [
                'total' => \App\Models\Payment::count(),
                'total_amount' => \App\Models\Payment::sum('amount'),
                'this_month' => \App\Models\Payment::whereMonth('payment_date', now()->month)->sum('amount'),
                'pending' => \App\Models\Payment::where('status', 'pending')->count(),
            ],
            'sports' => [
                'total' => \App\Models\Sport::where('is_active', true)->count(),
                'batches' => \App\Models\Batch::where('is_active', true)->count(),
            ],
            'recent_activities' => [
                'recent_students' => \App\Models\Student::with('sport')->orderBy('created_at', 'desc')->limit(5)->get(),
                'recent_payments' => \App\Models\Payment::with('student')->orderBy('created_at', 'desc')->limit(5)->get(),
            ]
        ];

        return response()->json([
            'success' => true,
            'message' => 'Dashboard statistics retrieved successfully',
            'data' => $stats
        ]);
    });

    // Health check route
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'API is working properly',
            'data' => [
                'version' => '1.0.0',
                'timestamp' => now(),
                'environment' => app()->environment(),
            ]
        ]);
    });
});

// Fallback route for API
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found',
        'error' => 'The requested API endpoint does not exist'
    ], 404);
});