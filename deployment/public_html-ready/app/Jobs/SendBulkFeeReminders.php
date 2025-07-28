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
use Carbon\Carbon;

class SendBulkFeeReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reminderType;
    protected $daysOverdue;
    protected $sportId;
    protected $batchId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $reminderType = 'overdue', int $daysOverdue = 0, ?int $sportId = null, ?int $batchId = null)
    {
        $this->reminderType = $reminderType;
        $this->daysOverdue = $daysOverdue;
        $this->sportId = $sportId;
        $this->batchId = $batchId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Get students with outstanding fees
            $studentsWithOutstandingFees = $this->getStudentsWithOutstandingFees();
            
            if ($studentsWithOutstandingFees->isEmpty()) {
                Log::info('No students found with outstanding fees', [
                    'reminder_type' => $this->reminderType,
                    'sport_id' => $this->sportId,
                    'batch_id' => $this->batchId
                ]);
                return;
            }

            $successCount = 0;
            $failureCount = 0;

            // Send reminder to each student
            foreach ($studentsWithOutstandingFees as $student) {
                try {
                    SendFeeReminder::dispatch($student, $this->reminderType, $this->daysOverdue);
                    $successCount++;
                } catch (\Exception $e) {
                    Log::error('Failed to dispatch fee reminder for student', [
                        'student_id' => $student->id,
                        'error' => $e->getMessage()
                    ]);
                    $failureCount++;
                }
            }

            Log::info('Bulk fee reminders dispatched', [
                'reminder_type' => $this->reminderType,
                'total_students' => $studentsWithOutstandingFees->count(),
                'success_count' => $successCount,
                'failure_count' => $failureCount,
                'sport_id' => $this->sportId,
                'batch_id' => $this->batchId
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk fee reminders job failed', [
                'reminder_type' => $this->reminderType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->fail($e);
        }
    }

    /**
     * Get students with outstanding fees
     */
    private function getStudentsWithOutstandingFees()
    {
        $query = Student::where('is_active', true)
            ->with(['sport', 'batches', 'payments']);

        // Filter by sport if specified
        if ($this->sportId) {
            $query->where('sport_id', $this->sportId);
        }

        // Filter by batch if specified
        if ($this->batchId) {
            $query->whereHas('batches', function ($q) {
                $q->where('batch_id', $this->batchId);
            });
        }

        $students = $query->get();

        // Filter students with outstanding fees
        return $students->filter(function ($student) {
            return $this->hasOutstandingFees($student);
        });
    }

    /**
     * Check if student has outstanding fees
     */
    private function hasOutstandingFees(Student $student): bool
    {
        $currentMonth = now()->format('Y-m');
        $monthlyFee = $student->sport->monthly_fee ?? 0;
        
        if ($monthlyFee <= 0) {
            return false;
        }

        // Get payments made this month
        $paidAmount = Payment::where('student_id', $student->id)
            ->whereRaw('DATE_FORMAT(payment_date, "%Y-%m") = ?', [$currentMonth])
            ->sum('amount');
        
        $outstandingAmount = $monthlyFee - $paidAmount;
        
        // Check if overdue based on days
        if ($this->daysOverdue > 0) {
            $dueDate = now()->startOfMonth()->addDays(5); // Assume fees are due by 5th of each month
            $daysPastDue = now()->diffInDays($dueDate, false);
            
            return $outstandingAmount > 0 && $daysPastDue >= $this->daysOverdue;
        }
        
        return $outstandingAmount > 0;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Bulk fee reminders job permanently failed', [
            'reminder_type' => $this->reminderType,
            'days_overdue' => $this->daysOverdue,
            'sport_id' => $this->sportId,
            'batch_id' => $this->batchId,
            'error' => $exception->getMessage()
        ]);
    }
}