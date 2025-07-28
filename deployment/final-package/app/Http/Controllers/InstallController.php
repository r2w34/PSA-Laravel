<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Exception;

class InstallController extends Controller
{
    public function index()
    {
        // Check if already installed
        if ($this->isInstalled()) {
            return redirect('/dashboard')->with('error', 'Application is already installed.');
        }
        
        return view('install.welcome');
    }
    
    public function requirements()
    {
        $requirements = $this->checkRequirements();
        return view('install.requirements', compact('requirements'));
    }
    
    public function permissions()
    {
        $permissions = $this->checkPermissions();
        return view('install.permissions', compact('permissions'));
    }
    
    public function environment()
    {
        return view('install.environment');
    }
    
    public function environmentSave(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string',
            'app_url' => 'required|url',
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_database' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'nullable|string',
        ]);
        
        try {
            $this->createEnvFile($request->all());
            return redirect()->route('install.database');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create environment file: ' . $e->getMessage());
        }
    }
    
    public function database()
    {
        return view('install.database');
    }
    
    public function databaseInstall()
    {
        try {
            \Log::info('Starting database installation...');
            
            // Test database connection
            DB::connection()->getPdo();
            \Log::info('Database connection successful');
            
            // Check if migrations are already run
            $migrationTable = DB::select("SHOW TABLES LIKE 'migrations'");
            if (empty($migrationTable)) {
                \Log::info('Running migrations...');
                $migrateResult = Artisan::call('migrate', ['--force' => true]);
                if ($migrateResult !== 0) {
                    throw new Exception('Migration failed with exit code: ' . $migrateResult);
                }
                \Log::info('Migrations completed');
            } else {
                \Log::info('Migrations already exist, skipping...');
            }
            
            // Check if roles exist
            $rolesExist = DB::table('roles')->count() > 0;
            if (!$rolesExist) {
                \Log::info('Running seeders...');
                $seedResult = Artisan::call('db:seed', ['--force' => true]);
                if ($seedResult !== 0) {
                    throw new Exception('Seeding failed with exit code: ' . $seedResult);
                }
                \Log::info('Seeders completed');
            } else {
                \Log::info('Roles already exist, skipping seeders...');
            }
            
            \Log::info('Database installation completed successfully');
            return redirect()->route('install.admin');
        } catch (Exception $e) {
            \Log::error('Database installation failed: ' . $e->getMessage());
            return back()->with('error', 'Database installation failed: ' . $e->getMessage());
        }
    }
    
    public function admin()
    {
        return view('install.admin');
    }
    
    public function adminSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        try {
            // Create admin user
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'admin',
                'is_active' => true,
            ]);
            
            // Assign admin role
            $admin->assignRole('admin');
            
            // Create installation lock file
            $this->createInstallLock();
            
            return redirect()->route('install.complete');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create admin user: ' . $e->getMessage());
        }
    }
    
    public function complete()
    {
        return view('install.complete');
    }
    
    private function isInstalled()
    {
        return File::exists(storage_path('installed'));
    }
    
    private function checkRequirements()
    {
        return [
            'php_version' => [
                'name' => 'PHP Version (>= 8.2)',
                'check' => version_compare(PHP_VERSION, '8.2.0', '>='),
                'current' => PHP_VERSION
            ],
            'pdo' => [
                'name' => 'PDO Extension',
                'check' => extension_loaded('pdo'),
                'current' => extension_loaded('pdo') ? 'Enabled' : 'Disabled'
            ],
            'mbstring' => [
                'name' => 'Mbstring Extension',
                'check' => extension_loaded('mbstring'),
                'current' => extension_loaded('mbstring') ? 'Enabled' : 'Disabled'
            ],
            'openssl' => [
                'name' => 'OpenSSL Extension',
                'check' => extension_loaded('openssl'),
                'current' => extension_loaded('openssl') ? 'Enabled' : 'Disabled'
            ],
            'tokenizer' => [
                'name' => 'Tokenizer Extension',
                'check' => extension_loaded('tokenizer'),
                'current' => extension_loaded('tokenizer') ? 'Enabled' : 'Disabled'
            ],
            'xml' => [
                'name' => 'XML Extension',
                'check' => extension_loaded('xml'),
                'current' => extension_loaded('xml') ? 'Enabled' : 'Disabled'
            ],
        ];
    }
    
    private function checkPermissions()
    {
        return [
            'storage' => [
                'name' => 'storage/',
                'check' => is_writable(storage_path()),
                'path' => storage_path()
            ],
            'bootstrap_cache' => [
                'name' => 'bootstrap/cache/',
                'check' => is_writable(base_path('bootstrap/cache')),
                'path' => base_path('bootstrap/cache')
            ],
        ];
    }
    
    private function createEnvFile($data)
    {
        $envContent = "APP_NAME=\"{$data['app_name']}\"
APP_ENV=production
APP_KEY=" . config('app.key') . "
APP_DEBUG=false
APP_URL={$data['app_url']}

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST={$data['db_host']}
DB_PORT={$data['db_port']}
DB_DATABASE={$data['db_database']}
DB_USERNAME={$data['db_username']}
DB_PASSWORD={$data['db_password']}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=\"hello@example.com\"
MAIL_FROM_NAME=\"\${APP_NAME}\"

VITE_APP_NAME=\"\${APP_NAME}\"
";
        
        File::put(base_path('.env'), $envContent);
    }
    
    private function createInstallLock()
    {
        File::put(storage_path('installed'), date('Y-m-d H:i:s'));
    }
}
