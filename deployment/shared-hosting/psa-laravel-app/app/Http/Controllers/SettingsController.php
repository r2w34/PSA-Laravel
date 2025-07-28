<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = $this->getSystemSettings();
        return view('settings.index', compact('settings'));
    }

    public function general()
    {
        $settings = $this->getSystemSettings();
        return view('settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url',
            'timezone' => 'required|string',
            'currency' => 'required|string|max:10',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
        ]);

        $this->updateEnvFile([
            'APP_NAME' => '"' . $request->app_name . '"',
            'APP_URL' => $request->app_url,
            'APP_TIMEZONE' => $request->timezone,
        ]);

        $this->updateSystemSetting('currency', $request->currency);
        $this->updateSystemSetting('date_format', $request->date_format);
        $this->updateSystemSetting('time_format', $request->time_format);

        return redirect()->back()->with('success', 'General settings updated successfully.');
    }

    public function database()
    {
        $settings = $this->getSystemSettings();
        $dbInfo = $this->getDatabaseInfo();
        return view('settings.database', compact('settings', 'dbInfo'));
    }

    public function updateDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_database' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'nullable|string',
        ]);

        // Test connection first
        try {
            $connection = new \PDO(
                "mysql:host={$request->db_host};port={$request->db_port};dbname={$request->db_database}",
                $request->db_username,
                $request->db_password
            );
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Database connection failed: ' . $e->getMessage()]);
        }

        $this->updateEnvFile([
            'DB_HOST' => $request->db_host,
            'DB_PORT' => $request->db_port,
            'DB_DATABASE' => $request->db_database,
            'DB_USERNAME' => $request->db_username,
            'DB_PASSWORD' => $request->db_password,
        ]);

        return redirect()->back()->with('success', 'Database settings updated successfully.');
    }

    public function email()
    {
        $settings = $this->getSystemSettings();
        return view('settings.email', compact('settings'));
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|string',
            'mail_host' => 'required_if:mail_mailer,smtp|string',
            'mail_port' => 'required_if:mail_mailer,smtp|numeric',
            'mail_username' => 'required_if:mail_mailer,smtp|string',
            'mail_password' => 'required_if:mail_mailer,smtp|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        $this->updateEnvFile([
            'MAIL_MAILER' => $request->mail_mailer,
            'MAIL_HOST' => $request->mail_host,
            'MAIL_PORT' => $request->mail_port,
            'MAIL_USERNAME' => $request->mail_username,
            'MAIL_PASSWORD' => $request->mail_password,
            'MAIL_ENCRYPTION' => $request->mail_encryption,
            'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            'MAIL_FROM_NAME' => '"' . $request->mail_from_name . '"',
        ]);

        return redirect()->back()->with('success', 'Email settings updated successfully.');
    }

    public function whatsapp()
    {
        $settings = $this->getSystemSettings();
        $botStatus = $this->getWhatsAppBotStatus();
        return view('settings.whatsapp', compact('settings', 'botStatus'));
    }

    public function updateWhatsApp(Request $request)
    {
        $request->validate([
            'whatsapp_enabled' => 'boolean',
            'whatsapp_api_url' => 'nullable|url',
            'whatsapp_api_token' => 'nullable|string',
            'fee_reminder_enabled' => 'boolean',
            'fee_reminder_days' => 'nullable|numeric|min:1|max:30',
            'attendance_notification_enabled' => 'boolean',
            'session_reminder_enabled' => 'boolean',
            'session_reminder_hours' => 'nullable|numeric|min:1|max:24',
        ]);

        $this->updateSystemSetting('whatsapp_enabled', $request->boolean('whatsapp_enabled'));
        $this->updateSystemSetting('whatsapp_api_url', $request->whatsapp_api_url);
        $this->updateSystemSetting('whatsapp_api_token', $request->whatsapp_api_token);
        $this->updateSystemSetting('fee_reminder_enabled', $request->boolean('fee_reminder_enabled'));
        $this->updateSystemSetting('fee_reminder_days', $request->fee_reminder_days);
        $this->updateSystemSetting('attendance_notification_enabled', $request->boolean('attendance_notification_enabled'));
        $this->updateSystemSetting('session_reminder_enabled', $request->boolean('session_reminder_enabled'));
        $this->updateSystemSetting('session_reminder_hours', $request->session_reminder_hours);

        return redirect()->back()->with('success', 'WhatsApp settings updated successfully.');
    }

    public function backup()
    {
        $backups = $this->getBackupList();
        return view('settings.backup', compact('backups'));
    }

    public function createBackup()
    {
        try {
            $filename = 'backup_' . date('Y_m_d_H_i_s') . '.sql';
            $backupPath = storage_path('app/backups/' . $filename);
            
            // Create backups directory if it doesn't exist
            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }

            // Create database backup
            $command = sprintf(
                'mysqldump -h %s -P %s -u %s -p%s %s > %s',
                config('database.connections.mysql.host'),
                config('database.connections.mysql.port'),
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.database'),
                $backupPath
            );

            exec($command, $output, $returnCode);

            if ($returnCode === 0) {
                return redirect()->back()->with('success', 'Backup created successfully: ' . $filename);
            } else {
                return redirect()->back()->withErrors(['error' => 'Backup creation failed.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Backup creation failed: ' . $e->getMessage()]);
        }
    }

    public function downloadBackup($filename)
    {
        $backupPath = storage_path('app/backups/' . $filename);
        
        if (!File::exists($backupPath)) {
            abort(404, 'Backup file not found.');
        }

        return response()->download($backupPath);
    }

    public function deleteBackup($filename)
    {
        $backupPath = storage_path('app/backups/' . $filename);
        
        if (File::exists($backupPath)) {
            File::delete($backupPath);
            return redirect()->back()->with('success', 'Backup deleted successfully.');
        }

        return redirect()->back()->withErrors(['error' => 'Backup file not found.']);
    }

    public function cache()
    {
        $cacheInfo = $this->getCacheInfo();
        return view('settings.cache', compact('cacheInfo'));
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            return redirect()->back()->with('success', 'All caches cleared successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Cache clearing failed: ' . $e->getMessage()]);
        }
    }

    public function optimizeCache()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');
            
            return redirect()->back()->with('success', 'Application optimized successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Optimization failed: ' . $e->getMessage()]);
        }
    }

    private function getSystemSettings()
    {
        return [
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'timezone' => config('app.timezone'),
            'currency' => $this->getSystemSetting('currency', 'INR'),
            'date_format' => $this->getSystemSetting('date_format', 'Y-m-d'),
            'time_format' => $this->getSystemSetting('time_format', 'H:i'),
            'db_host' => config('database.connections.mysql.host'),
            'db_port' => config('database.connections.mysql.port'),
            'db_database' => config('database.connections.mysql.database'),
            'db_username' => config('database.connections.mysql.username'),
            'mail_mailer' => config('mail.default'),
            'mail_host' => config('mail.mailers.smtp.host'),
            'mail_port' => config('mail.mailers.smtp.port'),
            'mail_username' => config('mail.mailers.smtp.username'),
            'mail_encryption' => config('mail.mailers.smtp.encryption'),
            'mail_from_address' => config('mail.from.address'),
            'mail_from_name' => config('mail.from.name'),
            'whatsapp_enabled' => $this->getSystemSetting('whatsapp_enabled', false),
            'whatsapp_api_url' => $this->getSystemSetting('whatsapp_api_url'),
            'whatsapp_api_token' => $this->getSystemSetting('whatsapp_api_token'),
            'fee_reminder_enabled' => $this->getSystemSetting('fee_reminder_enabled', true),
            'fee_reminder_days' => $this->getSystemSetting('fee_reminder_days', 3),
            'attendance_notification_enabled' => $this->getSystemSetting('attendance_notification_enabled', true),
            'session_reminder_enabled' => $this->getSystemSetting('session_reminder_enabled', true),
            'session_reminder_hours' => $this->getSystemSetting('session_reminder_hours', 2),
        ];
    }

    private function getSystemSetting($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = DB::table('system_settings')->where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    private function updateSystemSetting($key, $value)
    {
        DB::table('system_settings')->updateOrInsert(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );
        
        Cache::forget("setting_{$key}");
    }

    private function updateEnvFile($data)
    {
        $envFile = base_path('.env');
        $envContent = File::get($envFile);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";
            
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        File::put($envFile, $envContent);
    }

    private function getDatabaseInfo()
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $dbSize = DB::select('SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS "DB Size in MB" FROM information_schema.tables WHERE table_schema = ?', [config('database.connections.mysql.database')]);
            
            return [
                'table_count' => count($tables),
                'size' => $dbSize[0]->{'DB Size in MB'} ?? 0,
                'connection_status' => 'Connected',
            ];
        } catch (\Exception $e) {
            return [
                'table_count' => 0,
                'size' => 0,
                'connection_status' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

    private function getWhatsAppBotStatus()
    {
        try {
            // Check if WhatsApp bot process is running
            $output = shell_exec('pm2 list | grep psa-whatsapp-bot');
            $isRunning = !empty($output) && strpos($output, 'online') !== false;
            
            return [
                'status' => $isRunning ? 'online' : 'offline',
                'last_check' => now()->format('Y-m-d H:i:s'),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unknown',
                'last_check' => now()->format('Y-m-d H:i:s'),
                'error' => $e->getMessage(),
            ];
        }
    }

    private function getBackupList()
    {
        $backupPath = storage_path('app/backups');
        
        if (!File::exists($backupPath)) {
            return [];
        }

        $files = File::files($backupPath);
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'filename' => $file->getFilename(),
                'size' => $this->formatBytes($file->getSize()),
                'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
            ];
        }

        return collect($backups)->sortByDesc('created_at')->values()->all();
    }

    private function getCacheInfo()
    {
        return [
            'config_cached' => File::exists(bootstrap_path('cache/config.php')),
            'routes_cached' => File::exists(bootstrap_path('cache/routes-v7.php')),
            'views_cached' => File::exists(storage_path('framework/views')),
            'cache_driver' => config('cache.default'),
        ];
    }

    public function payment()
    {
        $settings = $this->getSystemSettings();
        return view('settings.payment', compact('settings'));
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'razorpay_key_id' => 'nullable|string',
            'razorpay_key_secret' => 'nullable|string',
            'razorpay_webhook_secret' => 'nullable|string',
            'payment_enabled' => 'boolean',
            'currency' => 'required|string|max:10',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $this->updateEnvFile([
            'RAZORPAY_KEY_ID' => $request->razorpay_key_id,
            'RAZORPAY_KEY_SECRET' => $request->razorpay_key_secret,
            'RAZORPAY_WEBHOOK_SECRET' => $request->razorpay_webhook_secret,
        ]);

        $this->updateSystemSetting('payment_enabled', $request->has('payment_enabled'));
        $this->updateSystemSetting('currency', $request->currency);
        $this->updateSystemSetting('tax_percentage', $request->tax_percentage ?? 0);

        return redirect()->back()->with('success', 'Payment settings updated successfully.');
    }

    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}