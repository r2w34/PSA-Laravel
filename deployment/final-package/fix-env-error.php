<?php
/**
 * PSA Sports Academy - Fix "Target class [env] does not exist" Error
 * This script specifically fixes the Laravel configuration cache issue
 */

echo "<h1>🔧 PSA Sports Academy - ENV Error Fix Tool</h1>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Fixing:</strong> Target class [env] does not exist</p>";
echo "<hr>";

// Function to clear all Laravel caches
function clearAllCaches() {
    echo "<h2>🧹 Clearing All Laravel Caches</h2>";
    
    $cacheFiles = [
        'bootstrap/cache/config.php',
        'bootstrap/cache/routes.php', 
        'bootstrap/cache/services.php',
        'bootstrap/cache/packages.php',
        'bootstrap/cache/compiled.php'
    ];
    
    $cleared = 0;
    foreach ($cacheFiles as $file) {
        if (file_exists($file)) {
            unlink($file);
            echo "✅ Cleared: $file<br>";
            $cleared++;
        }
    }
    
    if ($cleared === 0) {
        echo "ℹ️ No cache files found to clear<br>";
    }
    
    // Clear view cache
    $viewCacheDir = 'storage/framework/views';
    if (is_dir($viewCacheDir)) {
        $files = glob($viewCacheDir . '/*');
        $viewsCleared = 0;
        foreach ($files as $file) {
            if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                unlink($file);
                $viewsCleared++;
            }
        }
        echo "✅ Cleared $viewsCleared view cache files<br>";
    }
    
    // Clear data cache
    $dataCacheDir = 'storage/framework/cache/data';
    if (is_dir($dataCacheDir)) {
        $files = glob($dataCacheDir . '/*');
        $dataCleared = 0;
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                $dataCleared++;
            }
        }
        echo "✅ Cleared $dataCleared data cache files<br>";
    }
}

// Function to fix .env file format
function fixEnvFile() {
    echo "<h2>⚙️ Fixing .env File Configuration</h2>";
    
    if (!file_exists('.env')) {
        echo "❌ .env file not found<br>";
        return false;
    }
    
    $envContent = file_get_contents('.env');
    $lines = explode("\n", $envContent);
    $fixedLines = [];
    $fixed = false;
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Skip empty lines and comments
        if (empty($line) || strpos($line, '#') === 0) {
            $fixedLines[] = $line;
            continue;
        }
        
        // Check for problematic env() calls in .env file
        if (strpos($line, 'env(') !== false) {
            echo "⚠️ Found problematic line: $line<br>";
            // Remove env() calls from .env file
            $line = preg_replace('/env\([^)]+\)/', '', $line);
            $fixed = true;
            echo "✅ Fixed to: $line<br>";
        }
        
        $fixedLines[] = $line;
    }
    
    if ($fixed) {
        file_put_contents('.env', implode("\n", $fixedLines));
        echo "✅ .env file has been fixed<br>";
    } else {
        echo "✅ .env file format is correct<br>";
    }
    
    return true;
}

// Function to regenerate APP_KEY
function regenerateAppKey() {
    echo "<h2>🔑 Regenerating Application Key</h2>";
    
    // Generate a new base64 encoded key
    $key = base64_encode(random_bytes(32));
    $newKey = 'base64:' . $key;
    
    if (!file_exists('.env')) {
        echo "❌ .env file not found<br>";
        return false;
    }
    
    $envContent = file_get_contents('.env');
    
    // Replace or add APP_KEY
    if (strpos($envContent, 'APP_KEY=') !== false) {
        $envContent = preg_replace('/APP_KEY=.*/', 'APP_KEY=' . $newKey, $envContent);
        echo "✅ Updated existing APP_KEY<br>";
    } else {
        $envContent = "APP_KEY=" . $newKey . "\n" . $envContent;
        echo "✅ Added new APP_KEY<br>";
    }
    
    file_put_contents('.env', $envContent);
    echo "✅ New APP_KEY: $newKey<br>";
    
    return true;
}

// Function to fix database configuration
function fixDatabaseConfig() {
    echo "<h2>🗄️ Fixing Database Configuration</h2>";
    
    $dbPath = 'database/database.sqlite';
    
    // Ensure database directory exists
    if (!is_dir('database')) {
        mkdir('database', 0755, true);
        echo "✅ Created database directory<br>";
    }
    
    // Create SQLite database file if it doesn't exist
    if (!file_exists($dbPath)) {
        touch($dbPath);
        chmod($dbPath, 0664);
        echo "✅ Created SQLite database file<br>";
    } else {
        chmod($dbPath, 0664);
        echo "✅ Set database file permissions<br>";
    }
    
    // Test database connection
    try {
        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✅ Database connection test successful<br>";
        return true;
    } catch (Exception $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
        return false;
    }
}

// Function to set proper file permissions
function setFilePermissions() {
    echo "<h2>📁 Setting File Permissions</h2>";
    
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
    
    foreach ($directories as $dir => $perm) {
        if (!is_dir($dir)) {
            mkdir($dir, $perm, true);
            echo "✅ Created directory: $dir<br>";
        } else {
            chmod($dir, $perm);
            echo "✅ Set permissions for: $dir<br>";
        }
    }
    
    // Set file permissions
    $files = [
        '.env' => 0644,
        'database/database.sqlite' => 0664
    ];
    
    foreach ($files as $file => $perm) {
        if (file_exists($file)) {
            chmod($file, $perm);
            echo "✅ Set permissions for file: $file<br>";
        }
    }
}

// Function to test Laravel loading
function testLaravelLoading() {
    echo "<h2>🧪 Testing Laravel Application Loading</h2>";
    
    try {
        // Clear any existing autoloader cache
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        
        // Load Laravel
        require_once 'vendor/autoload.php';
        $app = require_once 'bootstrap/app.php';
        
        echo "✅ Laravel application loaded successfully<br>";
        
        // Test configuration loading
        $config = $app->make('config');
        echo "✅ Configuration system working<br>";
        
        // Test database connection
        try {
            $db = $app->make('db');
            $db->connection()->getPdo();
            echo "✅ Database connection working<br>";
        } catch (Exception $e) {
            echo "⚠️ Database connection issue: " . $e->getMessage() . "<br>";
        }
        
        return true;
    } catch (Exception $e) {
        echo "❌ Laravel loading failed: " . $e->getMessage() . "<br>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        return false;
    }
}

// Main execution
echo "<h2>🚀 Starting ENV Error Fix Process</h2>";

// Step 1: Clear all caches first
clearAllCaches();
echo "<hr>";

// Step 2: Fix .env file format
fixEnvFile();
echo "<hr>";

// Step 3: Regenerate APP_KEY
regenerateAppKey();
echo "<hr>";

// Step 4: Fix database configuration
fixDatabaseConfig();
echo "<hr>";

// Step 5: Set proper file permissions
setFilePermissions();
echo "<hr>";

// Step 6: Test Laravel loading
$laravelWorks = testLaravelLoading();
echo "<hr>";

// Results and next steps
echo "<h2>📋 Fix Results</h2>";

if ($laravelWorks) {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; color: #155724; margin: 20px 0;'>";
    echo "<h3>✅ SUCCESS! Laravel is now working</h3>";
    echo "<p>The 'Target class [env] does not exist' error has been fixed.</p>";
    echo "<h4>Next Steps:</h4>";
    echo "<ol>";
    echo "<li><strong>Test your site:</strong> <a href='/' target='_blank'>https://psanashik.in/</a></li>";
    echo "<li><strong>Run the installer:</strong> <a href='/install' target='_blank'>https://psanashik.in/install</a></li>";
    echo "<li><strong>Login to admin:</strong> <a href='/login' target='_blank'>https://psanashik.in/login</a></li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24; margin: 20px 0;'>";
    echo "<h3>❌ Issue Still Exists</h3>";
    echo "<p>Additional troubleshooting may be needed.</p>";
    echo "<h4>Try These Steps:</h4>";
    echo "<ol>";
    echo "<li><strong>Check PHP version:</strong> Ensure PHP 8.1+ is active</li>";
    echo "<li><strong>Check file permissions:</strong> Ensure all files are readable</li>";
    echo "<li><strong>Contact hosting support:</strong> There may be server-specific issues</li>";
    echo "</ol>";
    echo "</div>";
}

echo "<h2>🔧 Additional Tools</h2>";
echo "<p><a href='debug.php' style='background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Debug Tool</a>";
echo "<a href='install.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Installer</a>";
echo "<a href='fix-500-error.php' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>500 Error Fix</a></p>";

echo "<h2>⚠️ Security Note</h2>";
echo "<p><strong>IMPORTANT:</strong> Delete this file (fix-env-error.php) after fixing the issue for security!</p>";

echo "<h2>📞 Support Information</h2>";
echo "<p>If the issue persists after running this fix:</p>";
echo "<ul>";
echo "<li>Check your hosting provider's error logs</li>";
echo "<li>Ensure PHP 8.1+ is enabled</li>";
echo "<li>Verify that all required PHP extensions are installed</li>";
echo "<li>Contact your hosting provider for server-specific issues</li>";
echo "</ul>";
?>