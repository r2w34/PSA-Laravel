<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class SendFeeReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $reminderType;
    protected $daysOverdue;

    /**
     * Create a new job instance.
     */
    public function __construct(Student $student, string $reminderType = 'overdue', int $daysOverdue = 0)
    {
        $this->student = $student;
        $this->reminderType = $reminderType;
        $this->daysOverdue = $daysOverdue;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Calculate outstanding amount
            $outstandingAmount = $this->calculateOutstandingAmount();
            
            if ($outstandingAmount <= 0) {
                Log::info('No outstanding fees for student', ['student_id' => $this->student->id]);
                return;
            }

            // Generate reminder message
            $message = $this->generateReminderMessage($outstandingAmount);
            
            // Send WhatsApp message
            if ($this->student->phone) {
                SendWhatsAppMessage::dispatch(
                    $this->student->phone,
                    $message,
                    'fee_reminder',
                    [
                        'student_id' => $this->student->id,
                        'reminder_type' => $this->reminderType,
                        'outstanding_amount' => $outstandingAmount,
                        'days_overdue' => $this->daysOverdue
                    ]
                );
            }

            // Send to parent if different phone number
            if ($this->student->parent_phone && $this->student->parent_phone !== $this->student->phone) {
                SendWhatsAppMessage::dispatch(
                    $this->student->parent_phone,
                    $message,
                    'fee_reminder',
                    [
                        'student_id' => $this->student->id,
                        'reminder_type' => $this->reminderType,
                        'outstanding_amount' => $outstandingAmount,
                        'days_overdue' => $this->daysOverdue,
                        'sent_to' => 'parent'
                    ]
                );
            }

            Log::info('Fee reminder sent successfully', [
                'student_id' => $this->student->id,
                'reminder_type' => $this->reminderType,
                'outstanding_amount' => $outstandingAmount
            ]);

        } catch (\Exception $e) {
            Log::error('Fee reminder job failed', [
                'student_id' => $this->student->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->fail($e);
        }
    }

    /**
     * Calculate outstanding amount for student
     */
    private function calculateOutstandingAmount(): float
    {
        // Get total fees for current month
        $currentMonth = now()->format('Y-m');
        $monthlyFee = $this->student->sport->monthly_fee ?? 0;
        
        // Get payments made this month
        $paidAmount = Payment::where('student_id', $this->student->id)
            ->whereRaw('DATE_FORMAT(payment_date, "%Y-%m") = ?', [$currentMonth])
            ->sum('amount');
        
        return max(0, $monthlyFee - $paidAmount);
    }

    /**
     * Generate reminder message based on type
     */
    private function generateReminderMessage(float $outstandingAmount): string
    {
        $studentName = $this->student->name;
        $formattedAmount = number_format($outstandingAmount, 2);
        
        switch ($this->reminderType) {
            case 'gentle':
                return "🏏 Dear {$studentName},\n\nThis is a gentle reminder that your monthly fee of ₹{$formattedAmount} is due for PSA Sports Academy.\n\nPlease make the payment at your earliest convenience.\n\nThank you!\nPSA Sports Academy";
                
            case 'overdue':
                return "⚠️ Dear {$studentName},\n\nYour monthly fee of ₹{$formattedAmount} is now overdue by {$this->daysOverdue} days.\n\nPlease make the payment immediately to avoid any disruption in your training.\n\nFor any queries, contact us.\n\nPSA Sports Academy";
                
            case 'final':
                return "🚨 FINAL NOTICE - Dear {$studentName},\n\nYour fee of ₹{$formattedAmount} is seriously overdue by {$this->daysOverdue} days.\n\nImmediate payment is required to continue your training sessions.\n\nPlease contact us urgently.\n\nPSA Sports Academy";
                
            default:
                return "Dear {$studentName},\n\nYour monthly fee of ₹{$formattedAmount} is pending for PSA Sports Academy.\n\nPlease make the payment soon.\n\nThank you!\nPSA Sports Academy";
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Fee reminder job permanently failed', [
            'student_id' => $this->student->id,
            'reminder_type' => $this->reminderType,
            'error' => $exception->getMessage()
        ]);
    }
}