<?php

namespace App\Console\Commands;

use App\Models\Batch;
use Illuminate\Console\Command;

class CleanupBatchSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batches:cleanup-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up legacy batch schedule data from JSON format to proper fields';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting batch schedule cleanup...');
        
        // Find batches with JSON schedule data
        $batches = Batch::whereNotNull('schedule')
                        ->where('schedule', 'like', '%{%')
                        ->get();
        
        $updated = 0;
        
        foreach ($batches as $batch) {
            // Try to parse legacy schedule JSON
            if ($batch->schedule && is_string($batch->schedule)) {
                try {
                    $scheduleData = json_decode($batch->schedule, true);
                    
                    if (isset($scheduleData['days']) && isset($scheduleData['start_time']) && isset($scheduleData['end_time'])) {
                        // Convert days array to readable format
                        $daysMap = [
                            'monday' => 'Mon',
                            'tuesday' => 'Tue', 
                            'wednesday' => 'Wed',
                            'thursday' => 'Thu',
                            'friday' => 'Fri',
                            'saturday' => 'Sat',
                            'sunday' => 'Sun'
                        ];
                        
                        $readableDays = array_map(function($day) use ($daysMap) {
                            return $daysMap[strtolower($day)] ?? $day;
                        }, $scheduleData['days']);
                        
                        // Format time
                        $startTime = date('g:i A', strtotime($scheduleData['start_time']));
                        $endTime = date('g:i A', strtotime($scheduleData['end_time']));
                        
                        $readableSchedule = implode(', ', $readableDays) . "\n" . $startTime . ' - ' . $endTime;
                        
                        $batch->update([
                            'start_time' => $scheduleData['start_time'],
                            'end_time' => $scheduleData['end_time'],
                            'schedule' => $readableSchedule
                        ]);
                        
                        $updated++;
                        $this->line("Updated batch: {$batch->name}");
                    }
                } catch (\Exception $e) {
                    $this->warn("Could not parse schedule for batch: {$batch->name} - " . $e->getMessage());
                }
            }
        }
        
        $this->info("Cleanup completed! Updated {$updated} batches.");
        
        return 0;
    }
}
