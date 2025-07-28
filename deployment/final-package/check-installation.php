<?php
/**
 * PSA Sports Academy - Installation Status Checker
 * Quick check to see if the application is properly installed
 */

echo "<h1>🔍 PSA Sports Academy - Installation Status</h1>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// Function to check if Laravel is working
function checkLaravel() {
    echo "<h2>🧪 Laravel Status</h2>";
    
    try {
        require_once 'vendor/autoload.php';
        $app = require_once 'bootstrap/app.php';
        
        echo "✅ Laravel application loads successfully<br>";
        
        // Check if we can access config
        try {
            $config = $app->make('config');
            $appName = $config->get('app.name', 'Unknown');
            echo "✅ Configuration system working (App: $appName)<br>";
        } catch (Exception $e) {
            echo "⚠️ Configuration issue: " . $e->getMessage() . "<br>";
        }
        
        // Check database connection
        try {
            $db = $app->make('db');
            $pdo = $db->connection()->getPdo();
            echo "✅ Database connection working<br>";
            
            // Check if migrations are run
            try {
                $tables = $db->select("SELECT name FROM sqlite_master WHERE type='table'");
                $tableCount = count($tables);
                echo "✅ Database has $tableCount tables<br>";
                
                // Check for key tables
                $keyTables = ['users', 'roles', 'permissions', 'students', 'batches'];
                $foundTables = [];
                
                foreach ($tables as $table) {
                    if (in_array($table->name, $keyTables)) {
                        $foundTables[] = $table->name;
                    }
                }
                
                if (count($foundTables) >= 3) {
                    echo "✅ Key application tables found: " . implode(', ', $foundTables) . "<br>";
                } else {
                    echo "⚠️ Some key tables missing. Found: " . implode(', ', $foundTables) . "<br>";
                }
                
            } catch (Exception $e) {
                echo "⚠️ Could not check database tables: " . $e->getMessage() . "<br>";
            }
            
        } catch (Exception $e) {
            echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
        }
        
        return true;
    } catch (Exception $e) {
        echo "❌ Laravel loading failed: " . $e->getMessage() . "<br>";
        return false;
    }
}

// Function to check routes
function checkRoutes() {
    echo "<h2>🛣️ Route Status</h2>";
    
    $routes = [
        '/' => 'Home Page',
        '/login' => 'Login Page',
        '/install' => 'Installation Page'
    ];
    
    foreach ($routes as $route => $description) {
        $url = 'https://psanashik.in' . $route;
        echo "🔗 <a href='$url' target='_blank'>$description</a> - $url<br>";
    }
}

// Function to check installation status
function checkInstallationStatus() {
    echo "<h2>📋 Installation Status</h2>";
    
    $checks = [
        '.env' => 'Environment configuration',
        'vendor/autoload.php' => 'Composer dependencies',
        'database/database.sqlite' => 'SQLite database',
        'storage/installed' => 'Installation marker'
    ];
    
    $allGood = true;
    
    foreach ($checks as $file => $description) {
        if (file_exists($file)) {
            echo "✅ $description ($file)<br>";
        } else {
            echo "❌ $description ($file) - Missing<br>";
            $allGood = false;
        }
    }
    
    return $allGood;
}

// Function to provide next steps
function provideNextSteps($laravelWorks, $installationComplete) {
    echo "<h2>🎯 Next Steps</h2>";
    
    if ($laravelWorks && $installationComplete) {
        echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; color: #155724; margin: 20px 0;'>";
        echo "<h3>🎉 Installation Complete!</h3>";
        echo "<p>Your PSA Sports Academy application is ready to use.</p>";
        echo "<h4>Access Your Application:</h4>";
        echo "<ul>";
        echo "<li><strong>Home:</strong> <a href='https://psanashik.in/' target='_blank'>https://psanashik.in/</a></li>";
        echo "<li><strong>Login:</strong> <a href='https://psanashik.in/login' target='_blank'>https://psanashik.in/login</a></li>";
        echo "</ul>";
        echo "<h4>Default Admin Credentials:</h4>";
        echo "<p><strong>Email:</strong> admin@psa.com<br>";
        echo "<strong>Password:</strong> password</p>";
        echo "<p style='color: #856404; background: #fff3cd; padding: 10px; border-radius: 3px;'>";
        echo "⚠️ <strong>Important:</strong> Change the default password immediately after login!";
        echo "</p>";
        echo "</div>";
    } else if ($laravelWorks && !$installationComplete) {
        echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; color: #856404; margin: 20px 0;'>";
        echo "<h3>⚠️ Installation Incomplete</h3>";
        echo "<p>Laravel is working but installation is not complete.</p>";
        echo "<h4>Complete Installation:</h4>";
        echo "<ul>";
        echo "<li><strong>Web Installer:</strong> <a href='https://psanashik.in/install' target='_blank'>https://psanashik.in/install</a></li>";
        echo "<li><strong>Alternative Installer:</strong> <a href='https://psanashik.in/install.php' target='_blank'>https://psanashik.in/install.php</a></li>";
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24; margin: 20px 0;'>";
        echo "<h3>❌ Issues Detected</h3>";
        echo "<p>There are issues that need to be resolved.</p>";
        echo "<h4>Fix Tools Available:</h4>";
        echo "<ul>";
        echo "<li><strong>General 500 Errors:</strong> <a href='fix-500-error.php' target='_blank'>fix-500-error.php</a></li>";
        echo "<li><strong>ENV Configuration:</strong> <a href='fix-env-error.php' target='_blank'>fix-env-error.php</a></li>";
        echo "<li><strong>Debug Information:</strong> <a href='debug.php' target='_blank'>debug.php</a></li>";
        echo "</ul>";
        echo "</div>";
    }
}

// Main execution
echo "<h2>🚀 Checking Installation Status</h2>";

// Check Laravel
$laravelWorks = checkLaravel();
echo "<hr>";

// Check installation status
$installationComplete = checkInstallationStatus();
echo "<hr>";

// Check routes
checkRoutes();
echo "<hr>";

// Provide next steps
provideNextSteps($laravelWorks, $installationComplete);

echo "<h2>⚠️ Security Note</h2>";
echo "<p><strong>IMPORTANT:</strong> Delete diagnostic files after installation for security:</p>";
echo "<ul>";
echo "<li>check-installation.php (this file)</li>";
echo "<li>fix-500-error.php</li>";
echo "<li>fix-env-error.php</li>";
echo "<li>debug.php</li>";
echo "<li>install.php (after successful installation)</li>";
echo "</ul>";

echo "<h2>📞 Support</h2>";
echo "<p>If you need help, share the results above for specific assistance.</p>";
?>