<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Payment;
use Exception;

class WhatsAppService
{
    protected $botUrl;
    protected $webhookSecret;
    protected $timeout;

    public function __construct()
    {
        $this->botUrl = config('services.whatsapp.bot_url', 'http://localhost:3001');
        $this->webhookSecret = config('services.whatsapp.webhook_secret');
        $this->timeout = config('services.whatsapp.timeout', 30);
    }

    /**
     * Check if WhatsApp bot is available and ready
     */
    public function isAvailable(): bool
    {
        try {
            $response = Http::timeout(5)->get("{$this->botUrl}/health");
            if ($response->successful()) {
                $data = $response->json();
                return $data['success'] === true && 
                       isset($data['data']['status']) && 
                       $data['data']['status'] === 'healthy';
            }
            return false;
        } catch (Exception $e) {
            Log::warning('WhatsApp bot health check failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get bot status
     */
    public function getStatus(): array
    {
        try {
            $response = Http::timeout(10)->get("{$this->botUrl}/status");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Failed to get status'];
        } catch (Exception $e) {
            Log::error('Failed to get WhatsApp bot status', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send a generic message to a phone number
     */
    public function sendMessage(string $phone, string $message, string $type = 'text'): array
    {
        try {
            $response = Http::timeout($this->timeout)->post("{$this->botUrl}/send-message", [
                'phone' => $this->formatPhoneNumber($phone),
                'message' => $message,
                'type' => $type
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return ['success' => false, 'message' => 'Failed to send message'];
        } catch (Exception $e) {
            Log::error('Failed to send WhatsApp message', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send fee reminder to a student
     */
    public function sendFeeReminder(int $studentId, array $paymentDetails = null): array
    {
        try {
            $student = Student::with(['sport', 'batch.coach'])->find($studentId);
            
            if (!$student) {
                return ['success' => false, 'message' => 'Student not found'];
            }

            if (!$student->phone) {
                return ['success' => false, 'message' => 'Student phone number not available'];
            }

            // Get outstanding payments if not provided
            if (!$paymentDetails) {
                $outstandingPayments = Payment::where('student_id', $studentId)
                    ->where('status', 'pending')
                    ->where('due_date', '<', now())
                    ->get();

                if ($outstandingPayments->isEmpty()) {
                    return ['success' => false, 'message' => 'No outstanding payments found'];
                }

                $paymentDetails = [
                    'amount' => $outstandingPayments->sum('amount'),
                    'due_date' => $outstandingPayments->first()->due_date,
                    'count' => $outstandingPayments->count()
                ];
            }

            $response = Http::timeout($this->timeout)->post("{$this->botUrl}/send-fee-reminder", [
                'student_id' => $studentId,
                'payment_details' => $paymentDetails
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return ['success' => false, 'message' => 'Failed to send fee reminder'];
        } catch (Exception $e) {
            Log::error('Failed to send fee reminder', [
                'student_id' => $studentId,
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send session notification to a batch
     */
    public function sendSessionNotification(int $batchId, array $sessionDetails = null): array
    {
        try {
            $batch = Batch::with(['sport', 'coach', 'students'])->find($batchId);
            
            if (!$batch) {
                return ['success' => false, 'message' => 'Batch not found'];
            }

            $response = Http::timeout(60)->post("{$this->botUrl}/send-session-notification", [
                'batch_id' => $batchId,
                'session_details' => $sessionDetails
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return ['success' => false, 'message' => 'Failed to send session notification'];
        } catch (Exception $e) {
            Log::error('Failed to send session notification', [
                'batch_id' => $batchId,
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Format phone number for WhatsApp
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove all non-digit characters
        $cleaned = preg_replace('/\D/', '', $phone);
        
        // Add country code if not present (assuming India +91)
        if (!str_starts_with($cleaned, '91') && strlen($cleaned) === 10) {
            $cleaned = '91' . $cleaned;
        }
        
        return $cleaned;
    }
}