<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppBotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:bot {action} {--student=} {--batch=} {--phone=} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage WhatsApp bot operations';

    /**
     * WhatsApp bot service URL
     *
     * @var string
     */
    protected $botUrl;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->botUrl = config('services.whatsapp.bot_url', 'http://localhost:3001');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'status':
                return $this->checkStatus();
            case 'initialize':
                return $this->initializeBot();
            case 'send-message':
                return $this->sendMessage();
            case 'send-fee-reminder':
                return $this->sendFeeReminder();
            case 'send-session-notification':
                return $this->sendSessionNotification();
            case 'health':
                return $this->checkHealth();
            default:
                $this->error("Unknown action: {$action}");
                $this->info('Available actions: status, initialize, send-message, send-fee-reminder, send-session-notification, health');
                return 1;
        }
    }

    /**
     * Check WhatsApp bot status
     */
    protected function checkStatus()
    {
        try {
            $response = Http::timeout(10)->get("{$this->botUrl}/status");

            if ($response->successful()) {
                $data = $response->json();
                
                $this->info('WhatsApp Bot Status:');
                $this->table(
                    ['Property', 'Value'],
                    [
                        ['Status', $data['data']['status'] ?? 'unknown'],
                        ['Session Exists', $data['data']['session_exists'] ? 'Yes' : 'No'],
                        ['Last Activity', $data['data']['last_activity'] ?? 'N/A'],
                        ['Queue Size', $data['data']['message_queue_size'] ?? 0],
                    ]
                );

                return 0;
            } else {
                $this->error('Failed to get bot status: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error connecting to WhatsApp bot: ' . $e->getMessage());
            $this->info('Make sure the WhatsApp bot service is running on: ' . $this->botUrl);
            return 1;
        }
    }

    /**
     * Initialize WhatsApp bot
     */
    protected function initializeBot()
    {
        try {
            $this->info('Initializing WhatsApp bot...');
            
            $response = Http::timeout(30)->post("{$this->botUrl}/initialize");

            if ($response->successful()) {
                $data = $response->json();
                $this->info($data['message'] ?? 'Bot initialization started');
                
                $this->info('If this is the first time, you may need to scan a QR code.');
                $this->info('Check the bot logs or visit: ' . $this->botUrl . '/qr-code');
                
                return 0;
            } else {
                $this->error('Failed to initialize bot: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error initializing bot: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Send a custom message
     */
    protected function sendMessage()
    {
        $phone = $this->option('phone');
        $message = $this->option('message');

        if (!$phone || !$message) {
            $this->error('Both --phone and --message options are required');
            return 1;
        }

        try {
            $response = Http::timeout(30)->post("{$this->botUrl}/send-message", [
                'phone' => $phone,
                'message' => $message,
                'type' => 'text'
            ]);

            if ($response->successful()) {
                $this->info('Message sent successfully!');
                return 0;
            } else {
                $this->error('Failed to send message: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error sending message: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Send fee reminder
     */
    protected function sendFeeReminder()
    {
        $studentId = $this->option('student');

        if (!$studentId) {
            $this->error('--student option is required');
            return 1;
        }

        try {
            $response = Http::timeout(30)->post("{$this->botUrl}/send-fee-reminder", [
                'student_id' => $studentId
            ]);

            if ($response->successful()) {
                $this->info('Fee reminder sent successfully!');
                return 0;
            } else {
                $this->error('Failed to send fee reminder: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error sending fee reminder: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Send session notification
     */
    protected function sendSessionNotification()
    {
        $batchId = $this->option('batch');

        if (!$batchId) {
            $this->error('--batch option is required');
            return 1;
        }

        try {
            $response = Http::timeout(60)->post("{$this->botUrl}/send-session-notification", [
                'batch_id' => $batchId
            ]);

            if ($response->successful()) {
                $this->info('Session notification sent successfully!');
                return 0;
            } else {
                $this->error('Failed to send session notification: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error sending session notification: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Check bot health
     */
    protected function checkHealth()
    {
        try {
            $response = Http::timeout(10)->get("{$this->botUrl}/health");

            if ($response->successful()) {
                $data = $response->json();
                
                $this->info('WhatsApp Bot Health Check:');
                $this->table(
                    ['Property', 'Value'],
                    [
                        ['Service Status', $data['status'] ?? 'unknown'],
                        ['Service', $data['service'] ?? 'N/A'],
                        ['Version', $data['version'] ?? 'N/A'],
                        ['Uptime', round($data['uptime'] ?? 0, 2) . ' seconds'],
                        ['Bot Status', $data['bot_status'] ?? 'unknown'],
                    ]
                );

                if ($data['status'] === 'ok') {
                    $this->info('✅ WhatsApp bot service is healthy');
                    return 0;
                } else {
                    $this->warn('⚠️ WhatsApp bot service has issues');
                    return 1;
                }
            } else {
                $this->error('Failed to get health status: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error checking health: ' . $e->getMessage());
            return 1;
        }
    }
}