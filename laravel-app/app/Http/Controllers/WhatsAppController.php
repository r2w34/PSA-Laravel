<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\WhatsAppService;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Payment;

class WhatsAppController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Show WhatsApp management dashboard
     */
    public function index()
    {
        $status = $this->whatsappService->getStatus();
        $isAvailable = $this->whatsappService->isAvailable();

        return view('whatsapp.index', compact('status', 'isAvailable'));
    }

    /**
     * Get bot status via AJAX
     */
    public function status(): JsonResponse
    {
        $status = $this->whatsappService->getStatus();
        $isAvailable = $this->whatsappService->isAvailable();

        return response()->json([
            'success' => true,
            'data' => [
                'status' => $status,
                'available' => $isAvailable
            ]
        ]);
    }

    /**
     * Initialize WhatsApp bot
     */
    public function initialize(): JsonResponse
    {
        if (!config('services.whatsapp.enabled')) {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp service is disabled'
            ], 403);
        }

        $result = $this->whatsappService->initialize();

        return response()->json($result);
    }

    /**
     * Get QR code for authentication
     */
    public function qrCode(): JsonResponse
    {
        $result = $this->whatsappService->getQRCode();

        return response()->json($result);
    }

    /**
     * Send custom message
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:4000',
            'type' => 'sometimes|string|in:text,image'
        ]);

        if (!config('services.whatsapp.enabled')) {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp service is disabled'
            ], 403);
        }

        $result = $this->whatsappService->sendMessage(
            $request->phone,
            $request->message,
            $request->type ?? 'text'
        );

        return response()->json($result);
    }

    /**
     * Send fee reminder to student
     */
    public function sendFeeReminder(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id'
        ]);

        if (!config('services.whatsapp.enabled')) {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp service is disabled'
            ], 403);
        }

        $result = $this->whatsappService->sendFeeReminder($request->student_id);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Fee reminder sent successfully via WhatsApp'
            ]);
        }

        return response()->json($result, 400);
    }

    /**
     * Send session notification to batch
     */
    public function sendSessionNotification(Request $request): JsonResponse
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'session_details' => 'sometimes|array'
        ]);

        if (!config('services.whatsapp.enabled')) {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp service is disabled'
            ], 403);
        }

        $result = $this->whatsappService->sendSessionNotification(
            $request->batch_id,
            $request->session_details
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Session notification sent successfully via WhatsApp'
            ]);
        }

        return response()->json($result, 400);
    }

    /**
     * Send bulk fee reminders
     */
    public function sendBulkFeeReminders(Request $request): JsonResponse
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id'
        ]);

        if (!config('services.whatsapp.enabled')) {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp service is disabled'
            ], 403);
        }

        $results = [];
        $successCount = 0;
        $errorCount = 0;

        foreach ($request->student_ids as $studentId) {
            $result = $this->whatsappService->sendFeeReminder($studentId);
            
            if ($result['success']) {
                $successCount++;
            } else {
                $errorCount++;
            }

            $results[] = [
                'student_id' => $studentId,
                'success' => $result['success'],
                'message' => $result['message']
            ];

            // Small delay to avoid overwhelming the service
            usleep(500000); // 0.5 seconds
        }

        return response()->json([
            'success' => true,
            'message' => "Bulk fee reminders completed. Success: {$successCount}, Errors: {$errorCount}",
            'data' => [
                'total' => count($request->student_ids),
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'results' => $results
            ]
        ]);
    }

    /**
     * Get students with outstanding fees for bulk reminders
     */
    public function getOutstandingFeeStudents(): JsonResponse
    {
        $students = Student::whereHas('payments', function ($query) {
            $query->where('status', 'pending')
                  ->where('due_date', '<', now());
        })
        ->with(['sport', 'batch'])
        ->get()
        ->map(function ($student) {
            $outstandingAmount = $student->payments()
                ->where('status', 'pending')
                ->where('due_date', '<', now())
                ->sum('amount');

            return [
                'id' => $student->id,
                'name' => $student->name,
                'phone' => $student->phone,
                'sport' => $student->sport->name ?? 'N/A',
                'batch' => $student->batch->name ?? 'N/A',
                'outstanding_amount' => $outstandingAmount
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Get batches for session notifications
     */
    public function getBatchesForNotification(): JsonResponse
    {
        $batches = Batch::with(['sport', 'coach'])
            ->where('status', 'active')
            ->get()
            ->map(function ($batch) {
                return [
                    'id' => $batch->id,
                    'name' => $batch->name,
                    'sport' => $batch->sport->name ?? 'N/A',
                    'coach' => $batch->coach->name ?? 'N/A',
                    'students_count' => $batch->students()->count(),
                    'schedule' => $batch->schedule
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $batches
        ]);
    }

    /**
     * Test WhatsApp connection
     */
    public function testConnection(): JsonResponse
    {
        $isAvailable = $this->whatsappService->isAvailable();
        $status = $this->whatsappService->getStatus();

        return response()->json([
            'success' => $isAvailable,
            'message' => $isAvailable ? 'WhatsApp bot is available and ready' : 'WhatsApp bot is not available',
            'data' => [
                'available' => $isAvailable,
                'status' => $status
            ]
        ]);
    }

    /**
     * Show WhatsApp settings page
     */
    public function settings()
    {
        $config = [
            'enabled' => config('services.whatsapp.enabled'),
            'bot_url' => config('services.whatsapp.bot_url'),
            'timeout' => config('services.whatsapp.timeout'),
        ];

        return view('whatsapp.settings', compact('config'));
    }
}