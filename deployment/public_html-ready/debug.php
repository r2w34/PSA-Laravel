<?php
// PSA Sports Academy - Debug File
// Upload this to public_html and visit https://psanashik.in/debug.php

echo "<h1>🔧 PSA Sports Academy - Debug Information</h1>";
echo "<p><strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

echo "<hr><h2>File Structure Check</h2>";

// Check if key Laravel files exist
$files_to_check = [
    'index.php' => 'Laravel Entry Point',
    '.env' => 'Environment Configuration',
    '.htaccess' => 'Apache Rewrite Rules',
    'artisan' => 'Laravel CLI Tool',
    'composer.json' => 'Dependencies File',
    'app/Http/Controllers/InstallController.php' => 'Installation Controller',
    'routes/web.php' => 'Web Routes File',
    'vendor/autoload.php' => 'Composer Autoloader',
    'bootstrap/app.php' => 'Laravel Bootstrap',
    'storage/logs/' => 'Log Directory',
    'database/database.sqlite' => 'SQLite Database'
];

foreach ($files_to_check as $file => $description) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✅ <strong>$description</strong>: $file (exists)<br>";
        if (is_file($path)) {
            echo "&nbsp;&nbsp;&nbsp;&nbsp;Size: " . filesize($path) . " bytes<br>";
        }
    } else {
        echo "❌ <strong>$description</strong>: $file (missing)<br>";
    }
}

echo "<hr><h2>Environment Check</h2>";

// Check .env file content
if (file_exists(__DIR__ . '/.env')) {
    echo "✅ .env file exists<br>";
    $env_content = file_get_contents(__DIR__ . '/.env');
    
    // Check key settings
    if (strpos($env_content, 'APP_KEY=base64:') !== false) {
        echo "✅ APP_KEY is configured<br>";
    } else {
        echo "❌ APP_KEY is missing or invalid<br>";
    }
    
    if (strpos($env_content, 'APP_URL=https://psanashik.in') !== false) {
        echo "✅ APP_URL is set to https://psanashik.in<br>";
    } else {
        echo "⚠️ APP_URL might not be set correctly<br>";
    }
    
    if (strpos($env_content, 'DB_CONNECTION=sqlite') !== false) {
        echo "✅ Database is configured for SQLite<br>";
    } else {
        echo "❌ Database configuration issue<br>";
    }
} else {
    echo "❌ .env file is missing<br>";
}

echo "<hr><h2>Laravel Test</h2>";

// Try to load Laravel
try {
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "✅ Composer autoloader loaded successfully<br>";
        
        if (file_exists(__DIR__ . '/bootstrap/app.php')) {
            $app = require_once __DIR__ . '/bootstrap/app.php';
            echo "✅ Laravel application bootstrapped<br>";
            
            // Try to get the current environment
            if (method_exists($app, 'environment')) {
                echo "✅ Laravel environment: " . $app->environment() . "<br>";
            }
        } else {
            echo "❌ Laravel bootstrap file missing<br>";
        }
    } else {
        echo "❌ Composer autoloader missing<br>";
    }
} catch (Exception $e) {
    echo "❌ Laravel loading error: " . $e->getMessage() . "<br>";
}

echo "<hr><h2>URL Testing</h2>";

// Test different URLs
$test_urls = [
    'https://psanashik.in/' => 'Home Page',
    'https://psanashik.in/install' => 'Installation Page',
    'https://psanashik.in/login' => 'Login Page'
];

echo "<p>Test these URLs manually:</p>";
foreach ($test_urls as $url => $description) {
    echo "🔗 <a href='$url' target='_blank'>$description</a> - $url<br>";
}

echo "<hr><h2>Server Information</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "HTTP Host: " . $_SERVER['HTTP_HOST'] . "<br>";

echo "<hr><h2>Quick Fixes</h2>";

echo "<h3>If /install shows 'Page Not Found':</h3>";
echo "<ol>";
echo "<li><strong>Check .htaccess file</strong> - Make sure it exists and has correct Laravel rewrite rules</li>";
echo "<li><strong>Check file permissions</strong> - Run: chmod 644 .htaccess</li>";
echo "<li><strong>Check Apache mod_rewrite</strong> - Make sure it's enabled on your server</li>";
echo "<li><strong>Try direct access</strong> - Visit: <a href='https://psanashik.in/index.php/install'>https://psanashik.in/index.php/install</a></li>";
echo "</ol>";

echo "<h3>Alternative Installation Method:</h3>";
echo "<p>If the installer doesn't work, you can manually set up the database:</p>";
echo "<ol>";
echo "<li>Create the SQLite database file: <code>touch database/database.sqlite</code></li>";
echo "<li>Set permissions: <code>chmod 664 database/database.sqlite</code></li>";
echo "<li>Run migrations manually via SSH: <code>php artisan migrate --seed</code></li>";
echo "<li>Or import the database structure manually</li>";
echo "</ol>";

echo "<hr>";
echo "<p><strong>⚠️ Delete this debug.php file after diagnosis for security!</strong></p>";
echo "<p><strong>📧 Share the results above to get specific help with your setup.</strong></p>";
?>