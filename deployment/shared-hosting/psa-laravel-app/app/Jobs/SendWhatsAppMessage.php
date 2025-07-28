<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumber;
    protected $message;
    protected $messageType;
    protected $metadata;

    /**
     * Create a new job instance.
     */
    public function __construct(string $phoneNumber, string $message, string $messageType = 'text', array $metadata = [])
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
        $this->messageType = $messageType;
        $this->metadata = $metadata;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $whatsappBotUrl = config('services.whatsapp.bot_url', 'http://localhost:3001');
            
            $response = Http::timeout(30)->post($whatsappBotUrl . '/send-message', [
                'phone' => $this->phoneNumber,
                'message' => $this->message,
                'type' => $this->messageType,
                'metadata' => $this->metadata
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'phone' => $this->phoneNumber,
                    'type' => $this->messageType,
                    'response' => $response->json()
                ]);
            } else {
                Log::error('Failed to send WhatsApp message', [
                    'phone' => $this->phoneNumber,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                // Retry the job if it failed
                $this->fail('WhatsApp API returned error: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp message job failed', [
                'phone' => $this->phoneNumber,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Retry the job
            $this->fail($e);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('WhatsApp message job permanently failed', [
            'phone' => $this->phoneNumber,
            'message' => $this->message,
            'error' => $exception->getMessage()
        ]);
    }
}