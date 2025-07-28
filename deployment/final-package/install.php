<?php
// PSA Sports Academy - Simple Installation Script
// If the Laravel installer doesn't work, this will help

echo "<h1>🚀 PSA Sports Academy - Simple Installation</h1>";

// Check if already installed
if (file_exists(__DIR__ . '/storage/installed')) {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; color: #155724;'>";
    echo "<h2>✅ Already Installed!</h2>";
    echo "<p>PSA Sports Academy is already installed.</p>";
    echo "<p><a href='/login' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Login</a></p>";
    echo "</div>";
    exit;
}

echo "<p>This is a simplified installation script for PSA Sports Academy.</p>";

// Step 1: Check requirements
echo "<h2>Step 1: System Requirements</h2>";
$requirements_met = true;

// Check PHP version
if (version_compare(phpversion(), '8.1.0', '>=')) {
    echo "✅ PHP Version: " . phpversion() . " (Required: 8.1+)<br>";
} else {
    echo "❌ PHP Version: " . phpversion() . " (Required: 8.1+)<br>";
    $requirements_met = false;
}

// Check extensions
$required_extensions = ['pdo', 'pdo_sqlite', 'openssl', 'mbstring', 'tokenizer', 'json', 'ctype', 'fileinfo', 'bcmath', 'xml'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext extension loaded<br>";
    } else {
        echo "❌ $ext extension missing<br>";
        $requirements_met = false;
    }
}

if (!$requirements_met) {
    echo "<p style='color: red;'><strong>❌ System requirements not met. Please contact your hosting provider.</strong></p>";
    exit;
}

// Step 2: Check files
echo "<h2>Step 2: File Check</h2>";
$files_ok = true;

$required_files = [
    '.env' => 'Environment configuration',
    'vendor/autoload.php' => 'Composer dependencies',
    'bootstrap/app.php' => 'Laravel bootstrap',
    'artisan' => 'Laravel CLI'
];

foreach ($required_files as $file => $desc) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ $desc ($file)<br>";
    } else {
        echo "❌ $desc ($file) - Missing<br>";
        $files_ok = false;
    }
}

if (!$files_ok) {
    echo "<p style='color: red;'><strong>❌ Required files missing. Please re-upload the application.</strong></p>";
    exit;
}

// Step 3: Database setup
echo "<h2>Step 3: Database Setup</h2>";

// Create database directory if it doesn't exist
if (!is_dir(__DIR__ . '/database')) {
    mkdir(__DIR__ . '/database', 0755, true);
    echo "✅ Created database directory<br>";
}

// Create SQLite database file
$db_file = __DIR__ . '/database/database.sqlite';
if (!file_exists($db_file)) {
    touch($db_file);
    chmod($db_file, 0664);
    echo "✅ Created SQLite database file<br>";
} else {
    echo "✅ SQLite database file exists<br>";
}

// Step 4: Run installation
echo "<h2>Step 4: Installation Process</h2>";

if (isset($_POST['install'])) {
    try {
        // Load Laravel
        require_once __DIR__ . '/vendor/autoload.php';
        $app = require_once __DIR__ . '/bootstrap/app.php';
        
        echo "✅ Laravel loaded successfully<br>";
        
        // Run migrations
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        
        echo "🔄 Running database migrations...<br>";
        $kernel->call('migrate', ['--force' => true]);
        echo "✅ Database migrations completed<br>";
        
        echo "🔄 Seeding database with sample data...<br>";
        $kernel->call('db:seed', ['--force' => true]);
        echo "✅ Database seeding completed<br>";
        
        // Create storage link
        echo "🔄 Creating storage link...<br>";
        $kernel->call('storage:link');
        echo "✅ Storage link created<br>";
        
        // Mark as installed
        file_put_contents(__DIR__ . '/storage/installed', date('Y-m-d H:i:s'));
        echo "✅ Installation completed successfully!<br>";
        
        echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; color: #155724; margin: 20px 0;'>";
        echo "<h3>🎉 Installation Complete!</h3>";
        echo "<p><strong>Default Login Credentials:</strong></p>";
        echo "<p>Email: <strong>admin@psa.com</strong></p>";
        echo "<p>Password: <strong>password</strong></p>";
        echo "<p><a href='/login' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Login</a></p>";
        echo "<p style='color: #856404; background: #fff3cd; padding: 10px; border-radius: 3px; margin-top: 10px;'>";
        echo "⚠️ <strong>Important:</strong> Change the default password immediately after login!";
        echo "</p>";
        echo "</div>";
        
    } catch (Exception $e) {
        echo "❌ Installation failed: " . $e->getMessage() . "<br>";
        echo "<p style='color: red;'>Please check your server configuration and try again.</p>";
    }
} else {
    // Show installation form
    echo "<form method='POST'>";
    echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>Ready to Install</h3>";
    echo "<p>This will:</p>";
    echo "<ul>";
    echo "<li>Create database tables</li>";
    echo "<li>Insert sample data (sports, coaches, batches)</li>";
    echo "<li>Create default admin account</li>";
    echo "<li>Configure the system</li>";
    echo "</ul>";
    echo "<p><strong>Default Admin Account:</strong></p>";
    echo "<p>Email: admin@psa.com | Password: password</p>";
    echo "</div>";
    echo "<button type='submit' name='install' value='1' style='background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;'>🚀 Install PSA Sports Academy</button>";
    echo "</form>";
}

echo "<hr>";
echo "<p><strong>⚠️ Delete this install.php file after installation for security!</strong></p>";
?>