<?php
// PSA Sports Academy - Server Test File
// Upload this to public_html and visit https://psanashik.in/test.php

echo "<h1>🔧 PSA Sports Academy - Server Diagnostics</h1>";

// Check PHP version
echo "<h2>PHP Version</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Required: PHP 8.1 or higher<br>";
if (version_compare(phpversion(), '8.1.0', '>=')) {
    echo "✅ PHP version is compatible<br>";
} else {
    echo "❌ PHP version is too old. Laravel 11 requires PHP 8.1+<br>";
}

echo "<hr>";

// Check required extensions
echo "<h2>Required PHP Extensions</h2>";
$required_extensions = [
    'bcmath', 'ctype', 'fileinfo', 'json', 'mbstring', 
    'openssl', 'pdo', 'pdo_sqlite', 'tokenizer', 'xml'
];

foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext - Loaded<br>";
    } else {
        echo "❌ $ext - Missing<br>";
    }
}

echo "<hr>";

// Check file permissions
echo "<h2>File System Check</h2>";
$paths_to_check = [
    '/home/u806902440/public_html/.env',
    '/home/u806902440/public_html/storage',
    '/home/u806902440/public_html/bootstrap/cache',
    '/home/u806902440/public_html/database',
    '/home/u806902440/public_html/vendor/autoload.php'
];

foreach ($paths_to_check as $path) {
    if (file_exists($path)) {
        echo "✅ $path - Exists<br>";
        if (is_dir($path)) {
            echo "   Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "<br>";
        }
    } else {
        echo "❌ $path - Missing<br>";
    }
}

echo "<hr>";

// Check .env file content
echo "<h2>.env File Check</h2>";
$env_file = '/home/u806902440/public_html/.env';
if (file_exists($env_file)) {
    echo "✅ .env file exists<br>";
    $env_content = file_get_contents($env_file);
    if (strpos($env_content, 'APP_KEY=base64:') !== false) {
        echo "✅ APP_KEY is set<br>";
    } else {
        echo "❌ APP_KEY is missing or invalid<br>";
    }
    if (strpos($env_content, 'DB_CONNECTION=sqlite') !== false) {
        echo "✅ SQLite database configured<br>";
    } else {
        echo "❌ Database configuration missing<br>";
    }
} else {
    echo "❌ .env file is missing<br>";
}

echo "<hr>";

// Check database
echo "<h2>Database Check</h2>";
$db_file = '/home/u806902440/public_html/database/database.sqlite';
if (file_exists($db_file)) {
    echo "✅ SQLite database file exists<br>";
    echo "   File size: " . filesize($db_file) . " bytes<br>";
    echo "   Permissions: " . substr(sprintf('%o', fileperms($db_file)), -4) . "<br>";
    if (is_writable($db_file)) {
        echo "✅ Database file is writable<br>";
    } else {
        echo "❌ Database file is not writable<br>";
    }
} else {
    echo "❌ SQLite database file is missing<br>";
    echo "   Create it with: touch /home/u806902440/public_html/database/database.sqlite<br>";
}

echo "<hr>";

// Test Laravel autoloader
echo "<h2>Laravel Autoloader Test</h2>";
$autoloader = '/home/u806902440/public_html/vendor/autoload.php';
if (file_exists($autoloader)) {
    echo "✅ Composer autoloader exists<br>";
    try {
        require_once $autoloader;
        echo "✅ Autoloader loaded successfully<br>";
    } catch (Exception $e) {
        echo "❌ Autoloader error: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Composer autoloader missing<br>";
    echo "   Run: composer install --no-dev --optimize-autoloader<br>";
}

echo "<hr>";

// Memory and execution limits
echo "<h2>Server Limits</h2>";
echo "Memory Limit: " . ini_get('memory_limit') . "<br>";
echo "Max Execution Time: " . ini_get('max_execution_time') . " seconds<br>";
echo "Upload Max Filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "Post Max Size: " . ini_get('post_max_size') . "<br>";

echo "<hr>";
echo "<h2>🎯 Next Steps</h2>";
echo "<p>1. Fix any ❌ issues shown above</p>";
echo "<p>2. Check cPanel Error Logs for specific errors</p>";
echo "<p>3. Set APP_DEBUG=true in .env to see detailed Laravel errors</p>";
echo "<p>4. Delete this test.php file after diagnosis</p>";

// Show phpinfo if requested
if (isset($_GET['phpinfo'])) {
    echo "<hr><h2>Complete PHP Info</h2>";
    phpinfo();
}

echo "<hr>";
echo "<p><a href='?phpinfo=1'>Show Complete PHP Info</a></p>";
echo "<p><strong>⚠️ Delete this file after testing for security!</strong></p>";
?>