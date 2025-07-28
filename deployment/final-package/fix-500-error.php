<?php
/**
 * PSA Sports Academy - 500 Error Fix Tool
 * This script diagnoses and fixes common 500 errors after database configuration
 */

echo "<h1>🔧 PSA Sports Academy - 500 Error Fix Tool</h1>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// Function to check and fix file permissions
function checkAndFixPermissions() {
    echo "<h2>📁 Checking File Permissions</h2>";
    
    $directories = [
        'storage' => 0755,
        'storage/logs' => 0755,
        'storage/framework' => 0755,
        'storage/framework/cache' => 0755,
        'storage/framework/sessions' => 0755,
        'storage/framework/views' => 0755,
        'bootstrap/cache' => 0755,
        'database' => 0755
    ];
    
    $files = [
        '.env' => 0644,
        'database/database.sqlite' => 0664
    ];
    
    foreach ($directories as $dir => $perm) {
        if (!is_dir($dir)) {
            mkdir($dir, $perm, true);
            echo "✅ Created directory: $dir<br>";
        } else {
            chmod($dir, $perm);
            echo "✅ Set permissions for directory: $dir<br>";
        }
    }
    
    foreach ($files as $file => $perm) {
        if (file_exists($file)) {
            chmod($file, $perm);
            echo "✅ Set permissions for file: $file<br>";
        } else {
            echo "⚠️ File not found: $file<br>";
        }
    }
}

// Function to create SQLite database
function createDatabase() {
    echo "<h2>🗄️ Creating SQLite Database</h2>";
    
    $dbPath = 'database/database.sqlite';
    
    if (!file_exists('database')) {
        mkdir('database', 0755, true);
        echo "✅ Created database directory<br>";
    }
    
    if (!file_exists($dbPath)) {
        touch($dbPath);
        chmod($dbPath, 0664);
        echo "✅ Created SQLite database file<br>";
    } else {
        echo "✅ SQLite database file exists<br>";
    }
    
    // Test database connection
    try {
        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✅ Database connection successful<br>";
        return true;
    } catch (Exception $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
        return false;
    }
}

// Function to clear Laravel caches
function clearCaches() {
    echo "<h2>🧹 Clearing Laravel Caches</h2>";
    
    $cacheFiles = [
        'bootstrap/cache/config.php',
        'bootstrap/cache/routes.php',
        'bootstrap/cache/services.php',
        'bootstrap/cache/packages.php'
    ];
    
    foreach ($cacheFiles as $file) {
        if (file_exists($file)) {
            unlink($file);
            echo "✅ Cleared cache file: $file<br>";
        }
    }
    
    // Clear view cache
    $viewCacheDir = 'storage/framework/views';
    if (is_dir($viewCacheDir)) {
        $files = glob($viewCacheDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "✅ Cleared view cache<br>";
    }
}

// Function to check environment configuration
function checkEnvironment() {
    echo "<h2>⚙️ Checking Environment Configuration</h2>";
    
    if (!file_exists('.env')) {
        echo "❌ .env file not found<br>";
        return false;
    }
    
    $env = file_get_contents('.env');
    
    // Check critical settings
    $checks = [
        'APP_KEY=' => 'Application key',
        'DB_CONNECTION=sqlite' => 'Database connection',
        'DB_DATABASE=' => 'Database path'
    ];
    
    foreach ($checks as $setting => $description) {
        if (strpos($env, $setting) !== false) {
            echo "✅ $description configured<br>";
        } else {
            echo "❌ $description missing<br>";
        }
    }
    
    return true;
}

// Function to run migrations
function runMigrations() {
    echo "<h2>🔄 Running Database Migrations</h2>";
    
    // Check if we can run artisan commands
    if (!file_exists('artisan')) {
        echo "❌ Artisan command not found<br>";
        return false;
    }
    
    // Try to run migrations
    $output = [];
    $returnCode = 0;
    
    exec('php artisan migrate --force 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "✅ Migrations completed successfully<br>";
        foreach ($output as $line) {
            echo "   " . htmlspecialchars($line) . "<br>";
        }
        return true;
    } else {
        echo "❌ Migration failed<br>";
        foreach ($output as $line) {
            echo "   " . htmlspecialchars($line) . "<br>";
        }
        return false;
    }
}

// Function to test Laravel loading
function testLaravelLoading() {
    echo "<h2>🧪 Testing Laravel Application</h2>";
    
    try {
        // Try to load Laravel
        require_once 'vendor/autoload.php';
        
        // Bootstrap Laravel
        $app = require_once 'bootstrap/app.php';
        
        echo "✅ Laravel application loaded successfully<br>";
        return true;
    } catch (Exception $e) {
        echo "❌ Laravel loading failed: " . $e->getMessage() . "<br>";
        echo "Stack trace:<br>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        return false;
    }
}

// Function to create emergency .htaccess
function createEmergencyHtaccess() {
    echo "<h2>🚨 Creating Emergency .htaccess</h2>";
    
    $htaccess = '# Emergency .htaccess for PSA Sports Academy
RewriteEngine On

# Handle Angular and Vue.js client-side routing
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
</IfModule>

# Disable server signature
ServerSignature Off

# Hide sensitive files
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.json">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.lock">
    Order allow,deny
    Deny from all
</Files>

# Enable error reporting for debugging (remove in production)
php_flag display_errors On
php_flag display_startup_errors On
php_value error_reporting "E_ALL"
';
    
    file_put_contents('.htaccess', $htaccess);
    echo "✅ Emergency .htaccess created with error reporting enabled<br>";
}

// Main execution
echo "<h2>🚀 Starting 500 Error Fix Process</h2>";

// Step 1: Check and fix permissions
checkAndFixPermissions();
echo "<hr>";

// Step 2: Create database
createDatabase();
echo "<hr>";

// Step 3: Check environment
checkEnvironment();
echo "<hr>";

// Step 4: Clear caches
clearCaches();
echo "<hr>";

// Step 5: Create emergency .htaccess
createEmergencyHtaccess();
echo "<hr>";

// Step 6: Test Laravel loading
$laravelWorks = testLaravelLoading();
echo "<hr>";

// Step 7: Run migrations if Laravel loads
if ($laravelWorks) {
    runMigrations();
    echo "<hr>";
}

echo "<h2>🎯 Next Steps</h2>";
echo "<ol>";
echo "<li><strong>Try accessing your site now:</strong> <a href='/' target='_blank'>https://psanashik.in/</a></li>";
echo "<li><strong>If still getting 500 error:</strong> Check the error logs in storage/logs/</li>";
echo "<li><strong>Try the installer:</strong> <a href='/install' target='_blank'>https://psanashik.in/install</a></li>";
echo "<li><strong>Alternative installer:</strong> <a href='/install.php' target='_blank'>https://psanashik.in/install.php</a></li>";
echo "<li><strong>Debug tool:</strong> <a href='/debug.php' target='_blank'>https://psanashik.in/debug.php</a></li>";
echo "</ol>";

echo "<h2>⚠️ Security Note</h2>";
echo "<p><strong>IMPORTANT:</strong> Delete this file (fix-500-error.php) after fixing the issue for security!</p>";

echo "<h2>📞 Support</h2>";
echo "<p>If the issue persists, check the Laravel logs in <code>storage/logs/laravel.log</code> for detailed error information.</p>";
?>