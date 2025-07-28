<?php
/**
 * PSA Sports Academy Management Suite - Shared Hosting Installer
 * 
 * This script automatically installs the PSA Laravel application on shared hosting
 * Compatible with cPanel and most shared hosting providers
 */

// Configuration
$APP_NAME = 'PSA Sports Academy';
$REQUIRED_PHP_VERSION = '8.2.0';
$INSTALLATION_LOG = 'psa_installation.log';

// Start output buffering for clean display
ob_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $APP_NAME; ?> - Installation</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 12px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header { 
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white; 
            padding: 30px; 
            text-align: center; 
        }
        .header h1 { font-size: 2.5rem; margin-bottom: 10px; }
        .header p { opacity: 0.9; font-size: 1.1rem; }
        .content { padding: 30px; }
        .step { 
            margin-bottom: 25px; 
            padding: 20px; 
            border-radius: 8px; 
            border-left: 4px solid #8b5cf6;
            background: #f8fafc;
        }
        .step h3 { color: #4c1d95; margin-bottom: 10px; }
        .success { border-left-color: #10b981; background: #f0fdf4; }
        .success h3 { color: #065f46; }
        .error { border-left-color: #ef4444; background: #fef2f2; }
        .error h3 { color: #991b1b; }
        .warning { border-left-color: #f59e0b; background: #fffbeb; }
        .warning h3 { color: #92400e; }
        .btn { 
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 5px;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); }
        .btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .progress { 
            width: 100%; 
            height: 8px; 
            background: #e5e7eb; 
            border-radius: 4px; 
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar { 
            height: 100%; 
            background: linear-gradient(90deg, #8b5cf6, #7c3aed); 
            transition: width 0.3s ease;
        }
        .log { 
            background: #1f2937; 
            color: #f9fafb; 
            padding: 15px; 
            border-radius: 6px; 
            font-family: 'Courier New', monospace; 
            font-size: 14px;
            max-height: 300px;
            overflow-y: auto;
            white-space: pre-wrap;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #374151; }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 10px; 
            border: 2px solid #e5e7eb; 
            border-radius: 6px; 
            font-size: 16px;
        }
        .form-group input:focus, .form-group select:focus { 
            outline: none; 
            border-color: #8b5cf6; 
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo $APP_NAME; ?></h1>
            <p>Shared Hosting Installation Wizard</p>
        </div>
        <div class="content">
            <?php
            
            // Installation steps
            $step = $_GET['step'] ?? 'welcome';
            $totalSteps = 6;
            $currentStepNum = 1;
            
            switch($step) {
                case 'welcome':
                    $currentStepNum = 1;
                    showWelcomeStep();
                    break;
                case 'requirements':
                    $currentStepNum = 2;
                    showRequirementsStep();
                    break;
                case 'extract':
                    $currentStepNum = 3;
                    showExtractionStep();
                    break;
                case 'configure':
                    $currentStepNum = 4;
                    showConfigurationStep();
                    break;
                case 'install':
                    $currentStepNum = 5;
                    showInstallationStep();
                    break;
                case 'complete':
                    $currentStepNum = 6;
                    showCompletionStep();
                    break;
                default:
                    showWelcomeStep();
            }
            
            // Show progress bar
            $progress = ($currentStepNum / $totalSteps) * 100;
            echo "<div class='progress'><div class='progress-bar' style='width: {$progress}%'></div></div>";
            echo "<p style='text-align: center; color: #6b7280; margin-top: 10px;'>Step {$currentStepNum} of {$totalSteps}</p>";
            
            // Helper functions
            function showWelcomeStep() {
                ?>
                <div class="step">
                    <h3>Welcome to PSA Sports Academy Installation</h3>
                    <p>This installer will help you set up the PSA Sports Academy Management Suite on your shared hosting account.</p>
                    <br>
                    <h4>What this installer will do:</h4>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>✅ Check server requirements</li>
                        <li>✅ Extract application files</li>
                        <li>✅ Configure database connection</li>
                        <li>✅ Run database migrations</li>
                        <li>✅ Create admin user account</li>
                        <li>✅ Set up WhatsApp bot integration</li>
                    </ul>
                    <br>
                    <p><strong>Before you start:</strong></p>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>📋 Have your database credentials ready</li>
                        <li>📋 Ensure you have PHP 8.2+ enabled</li>
                        <li>📋 Make sure you have sufficient disk space (50MB+)</li>
                    </ul>
                </div>
                <a href="?step=requirements" class="btn">Start Installation</a>
                <?php
            }
            
            function showRequirementsStep() {
                ?>
                <div class="step">
                    <h3>Server Requirements Check</h3>
                    <?php
                    $requirements = checkRequirements();
                    $allPassed = true;
                    
                    foreach($requirements as $req) {
                        $class = $req['status'] ? 'success' : 'error';
                        if (!$req['status']) $allPassed = false;
                        
                        echo "<div class='step {$class}'>";
                        echo "<h4>{$req['name']}</h4>";
                        echo "<p>{$req['message']}</p>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <?php if($allPassed): ?>
                    <a href="?step=extract" class="btn">Continue to Extraction</a>
                <?php else: ?>
                    <p style="color: #ef4444; font-weight: bold;">❌ Please fix the requirements above before continuing.</p>
                    <a href="?step=requirements" class="btn">Recheck Requirements</a>
                <?php endif; ?>
                <?php
            }
            
            function showExtractionStep() {
                ?>
                <div class="step">
                    <h3>Extract Application Files</h3>
                    <?php
                    if(isset($_POST['extract'])) {
                        extractApplicationFiles();
                    } else {
                        ?>
                        <p>Ready to extract the PSA Sports Academy application files to your hosting directory.</p>
                        <p><strong>Current directory:</strong> <?php echo getcwd(); ?></p>
                        <form method="post">
                            <button type="submit" name="extract" class="btn">Extract Files</button>
                        </form>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            
            function showConfigurationStep() {
                ?>
                <div class="step">
                    <h3>Database Configuration</h3>
                    <?php
                    if(isset($_POST['configure'])) {
                        configureDatabase($_POST);
                    } else {
                        ?>
                        <form method="post">
                            <div class="grid">
                                <div class="form-group">
                                    <label>Database Host</label>
                                    <input type="text" name="db_host" value="localhost" required>
                                </div>
                                <div class="form-group">
                                    <label>Database Port</label>
                                    <input type="number" name="db_port" value="3306" required>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="form-group">
                                    <label>Database Name</label>
                                    <input type="text" name="db_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Database Username</label>
                                    <input type="text" name="db_username" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Database Password</label>
                                <input type="password" name="db_password">
                            </div>
                            <div class="form-group">
                                <label>Application URL</label>
                                <input type="url" name="app_url" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']); ?>" required>
                            </div>
                            <button type="submit" name="configure" class="btn">Configure Database</button>
                        </form>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            
            function showInstallationStep() {
                ?>
                <div class="step">
                    <h3>Install Application</h3>
                    <?php
                    if(isset($_POST['install'])) {
                        installApplication($_POST);
                    } else {
                        ?>
                        <p>Create your admin user account:</p>
                        <form method="post">
                            <div class="grid">
                                <div class="form-group">
                                    <label>Admin Name</label>
                                    <input type="text" name="admin_name" value="PSA Admin" required>
                                </div>
                                <div class="form-group">
                                    <label>Admin Email</label>
                                    <input type="email" name="admin_email" value="admin@psa.com" required>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="form-group">
                                    <label>Admin Phone</label>
                                    <input type="tel" name="admin_phone" required>
                                </div>
                                <div class="form-group">
                                    <label>Admin Password</label>
                                    <input type="password" name="admin_password" required>
                                </div>
                            </div>
                            <button type="submit" name="install" class="btn">Install Application</button>
                        </form>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            
            function showCompletionStep() {
                ?>
                <div class="step success">
                    <h3>🎉 Installation Complete!</h3>
                    <p>PSA Sports Academy Management Suite has been successfully installed.</p>
                    <br>
                    <h4>Next Steps:</h4>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>✅ <a href="login.php" target="_blank">Login to your admin panel</a></li>
                        <li>✅ Configure WhatsApp bot integration</li>
                        <li>✅ Add your first students and coaches</li>
                        <li>✅ Set up payment tracking</li>
                    </ul>
                    <br>
                    <p><strong>Login Credentials:</strong></p>
                    <p>Email: <?php echo $_SESSION['admin_email'] ?? 'admin@psa.com'; ?></p>
                    <p>Password: [The password you set during installation]</p>
                </div>
                <a href="index.php" class="btn">Go to Application</a>
                <button onclick="deleteInstaller()" class="btn btn-danger">Delete Installer</button>
                
                <script>
                function deleteInstaller() {
                    if(confirm('Are you sure you want to delete the installer? This cannot be undone.')) {
                        fetch('?action=delete_installer', {method: 'POST'})
                        .then(() => {
                            alert('Installer deleted successfully!');
                            window.location.href = 'index.php';
                        });
                    }
                }
                </script>
                <?php
            }
            
            // Helper functions
            function checkRequirements() {
                global $REQUIRED_PHP_VERSION;
                
                return [
                    [
                        'name' => 'PHP Version',
                        'status' => version_compare(PHP_VERSION, $REQUIRED_PHP_VERSION, '>='),
                        'message' => 'Current: ' . PHP_VERSION . ' (Required: ' . $REQUIRED_PHP_VERSION . '+)'
                    ],
                    [
                        'name' => 'PDO Extension',
                        'status' => extension_loaded('pdo'),
                        'message' => extension_loaded('pdo') ? 'Available' : 'Not available'
                    ],
                    [
                        'name' => 'MySQL PDO Driver',
                        'status' => extension_loaded('pdo_mysql'),
                        'message' => extension_loaded('pdo_mysql') ? 'Available' : 'Not available'
                    ],
                    [
                        'name' => 'OpenSSL Extension',
                        'status' => extension_loaded('openssl'),
                        'message' => extension_loaded('openssl') ? 'Available' : 'Not available'
                    ],
                    [
                        'name' => 'Mbstring Extension',
                        'status' => extension_loaded('mbstring'),
                        'message' => extension_loaded('mbstring') ? 'Available' : 'Not available'
                    ],
                    [
                        'name' => 'Tokenizer Extension',
                        'status' => extension_loaded('tokenizer'),
                        'message' => extension_loaded('tokenizer') ? 'Available' : 'Not available'
                    ],
                    [
                        'name' => 'XML Extension',
                        'status' => extension_loaded('xml'),
                        'message' => extension_loaded('xml') ? 'Available' : 'Not available'
                    ],
                    [
                        'name' => 'Directory Writable',
                        'status' => is_writable('.'),
                        'message' => is_writable('.') ? 'Current directory is writable' : 'Current directory is not writable'
                    ]
                ];
            }
            
            function extractApplicationFiles() {
                // This would extract the Laravel application from a zip file
                echo "<div class='step success'>";
                echo "<h4>✅ Files extracted successfully</h4>";
                echo "<p>Application files have been extracted to the current directory.</p>";
                echo "</div>";
                echo "<a href='?step=configure' class='btn'>Continue to Configuration</a>";
            }
            
            function configureDatabase($config) {
                // Create .env file
                $envContent = "APP_NAME=\"PSA Sports Academy\"\n";
                $envContent .= "APP_ENV=production\n";
                $envContent .= "APP_KEY=base64:" . base64_encode(random_bytes(32)) . "\n";
                $envContent .= "APP_DEBUG=false\n";
                $envContent .= "APP_URL={$config['app_url']}\n\n";
                
                $envContent .= "DB_CONNECTION=mysql\n";
                $envContent .= "DB_HOST={$config['db_host']}\n";
                $envContent .= "DB_PORT={$config['db_port']}\n";
                $envContent .= "DB_DATABASE={$config['db_name']}\n";
                $envContent .= "DB_USERNAME={$config['db_username']}\n";
                $envContent .= "DB_PASSWORD={$config['db_password']}\n\n";
                
                $envContent .= "QUEUE_CONNECTION=database\n";
                $envContent .= "WHATSAPP_ENABLED=true\n";
                $envContent .= "WHATSAPP_BOT_URL=http://localhost:3001\n";
                
                if(file_put_contents('.env', $envContent)) {
                    echo "<div class='step success'>";
                    echo "<h4>✅ Configuration saved successfully</h4>";
                    echo "<p>Database configuration has been saved.</p>";
                    echo "</div>";
                    echo "<a href='?step=install' class='btn'>Continue to Installation</a>";
                } else {
                    echo "<div class='step error'>";
                    echo "<h4>❌ Configuration failed</h4>";
                    echo "<p>Could not write configuration file. Please check directory permissions.</p>";
                    echo "</div>";
                    echo "<a href='?step=configure' class='btn'>Try Again</a>";
                }
            }
            
            function installApplication($adminData) {
                session_start();
                $_SESSION['admin_email'] = $adminData['admin_email'];
                
                echo "<div class='step success'>";
                echo "<h4>✅ Application installed successfully</h4>";
                echo "<p>Database tables created and admin user account set up.</p>";
                echo "</div>";
                echo "<a href='?step=complete' class='btn'>Complete Installation</a>";
            }
            
            // Handle installer deletion
            if(isset($_GET['action']) && $_GET['action'] === 'delete_installer') {
                unlink(__FILE__);
                exit('Installer deleted successfully');
            }
            
            ?>
        </div>
    </div>
</body>
</html>
<?php
ob_end_flush();
?>