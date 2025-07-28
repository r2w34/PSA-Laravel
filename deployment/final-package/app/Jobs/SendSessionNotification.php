<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendSessionNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batch;
    protected $notificationType;
    protected $sessionDate;

    /**
     * Create a new job instance.
     */
    public function __construct(Batch $batch, string $notificationType = 'reminder', ?Carbon $sessionDate = null)
    {
        $this->batch = $batch;
        $this->notificationType = $notificationType;
        $this->sessionDate = $sessionDate ?? now();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Get all active students in this batch
            $students = $this->batch->students()->where('is_active', true)->get();
            
            if ($students->isEmpty()) {
                Log::info('No active students found for batch', ['batch_id' => $this->batch->id]);
                return;
            }

            // Generate notification message
            $message = $this->generateNotificationMessage();
            
            // Send notification to each student
            foreach ($students as $student) {
                $this->sendNotificationToStudent($student, $message);
            }

            Log::info('Session notifications sent successfully', [
                'batch_id' => $this->batch->id,
                'notification_type' => $this->notificationType,
                'students_count' => $students->count(),
                'session_date' => $this->sessionDate->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            Log::error('Session notification job failed', [
                'batch_id' => $this->batch->id,
                'notification_type' => $this->notificationType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->fail($e);
        }
    }

    /**
     * Send notification to individual student
     */
    private function sendNotificationToStudent(Student $student, string $message): void
    {
        // Send to student's phone
        if ($student->phone) {
            SendWhatsAppMessage::dispatch(
                $student->phone,
                $message,
                'session_notification',
                [
                    'student_id' => $student->id,
                    'batch_id' => $this->batch->id,
                    'notification_type' => $this->notificationType,
                    'session_date' => $this->sessionDate->format('Y-m-d H:i:s')
                ]
            );
        }

        // Send to parent if different phone number
        if ($student->parent_phone && $student->parent_phone !== $student->phone) {
            SendWhatsAppMessage::dispatch(
                $student->parent_phone,
                $message,
                'session_notification',
                [
                    'student_id' => $student->id,
                    'batch_id' => $this->batch->id,
                    'notification_type' => $this->notificationType,
                    'session_date' => $this->sessionDate->format('Y-m-d H:i:s'),
                    'sent_to' => 'parent'
                ]
            );
        }
    }

    /**
     * Generate notification message based on type
     */
    private function generateNotificationMessage(): string
    {
        $batchName = $this->batch->name;
        $sportName = $this->batch->sport->name ?? 'Training';
        $coachName = $this->batch->coach->name ?? 'Coach';
        $sessionTime = $this->sessionDate->format('g:i A');
        $sessionDate = $this->sessionDate->format('l, M j');
        
        switch ($this->notificationType) {
            case 'reminder':
                return "🏏 Training Reminder\n\n📅 {$sessionDate} at {$sessionTime}\n🏃‍♂️ {$sportName} - {$batchName}\n👨‍🏫 Coach: {$coachName}\n\nDon't forget your training session today!\n\nSee you on the field! 💪\n\nPSA Sports Academy";
                
            case 'cancellation':
                return "❌ Session Cancelled\n\n📅 {$sessionDate} at {$sessionTime}\n🏃‍♂️ {$sportName} - {$batchName}\n\nToday's training session has been cancelled.\n\nWe'll notify you about the next session.\n\nSorry for the inconvenience.\n\nPSA Sports Academy";
                
            case 'rescheduled':
                return "🔄 Session Rescheduled\n\n📅 New Date: {$sessionDate} at {$sessionTime}\n🏃‍♂️ {$sportName} - {$batchName}\n👨‍🏫 Coach: {$coachName}\n\nYour training session has been rescheduled.\n\nPlease make note of the new timing.\n\nPSA Sports Academy";
                
            case 'special':
                return "⭐ Special Session\n\n📅 {$sessionDate} at {$sessionTime}\n🏃‍♂️ {$sportName} - {$batchName}\n👨‍🏫 Coach: {$coachName}\n\nSpecial training session scheduled!\n\nDon't miss this opportunity to improve your skills.\n\nPSA Sports Academy";
                
            default:
                return "🏏 Training Session\n\n📅 {$sessionDate} at {$sessionTime}\n🏃‍♂️ {$sportName} - {$batchName}\n👨‍🏫 Coach: {$coachName}\n\nYour training session is scheduled.\n\nBe ready and on time!\n\nPSA Sports Academy";
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Session notification job permanently failed', [
            'batch_id' => $this->batch->id,
            'notification_type' => $this->notificationType,
            'session_date' => $this->sessionDate->format('Y-m-d H:i:s'),
            'error' => $exception->getMessage()
        ]);
    }
}