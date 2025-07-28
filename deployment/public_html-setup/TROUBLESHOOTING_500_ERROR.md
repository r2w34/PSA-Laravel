# 🚨 HTTP 500 Error - Troubleshooting Guide

## 🔍 **Common Causes & Solutions for HTTP 500 Error**

### **Step 1: Check Error Logs (Most Important)**
1. **In cPanel**: Go to **Error Logs** and check the latest entries
2. **Look for specific PHP errors** like:
   - Permission denied
   - Class not found
   - Memory limit exceeded
   - Missing extensions

### **Step 2: Verify File Structure**
Make sure you have the correct Laravel file structure in public_html:

```
/home/u806902440/public_html/
├── .env                    # ✅ Must exist with correct APP_KEY
├── .htaccess              # ✅ Laravel routing rules
├── index.php              # ✅ Laravel entry point (from public folder)
├── artisan                # ✅ Laravel CLI tool
├── composer.json          # ✅ Dependencies file
├── app/                   # ✅ Application code
├── bootstrap/             # ✅ Laravel bootstrap
├── config/                # ✅ Configuration files
├── database/              # ✅ Database files
├── public/                # ✅ Public assets (CSS, JS, images)
├── resources/             # ✅ Views and assets
├── routes/                # ✅ Route definitions
├── storage/               # ✅ Storage and cache (must be writable)
├── vendor/                # ✅ Composer dependencies
└── whatsapp-bot/          # ✅ WhatsApp service (optional)
```

### **Step 3: Check File Permissions**
Run these commands via SSH or cPanel Terminal:

```bash
# Navigate to your directory
cd /home/u806902440/public_html

# Set correct permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
chmod 644 index.php
chmod 644 .htaccess
chmod +x artisan

# Make sure database directory is writable
chmod 755 database/
chmod 664 database/database.sqlite
```

### **Step 4: Verify .env File**
Make sure your `.env` file exists and contains:

```env
APP_NAME="PSA Sports Academy"
APP_ENV=production
APP_KEY=base64:YXprNDdiN3RtaG54b2E0OHl1czl4eTd6bWQ3NDN1eXE=
APP_DEBUG=true
APP_TIMEZONE=Asia/Kolkata
APP_URL=https://psanashik.in

# SQLite Database Configuration
DB_CONNECTION=sqlite
DB_DATABASE=/home/u806902440/public_html/database/database.sqlite

# Other settings...
```

**⚠️ Temporarily set `APP_DEBUG=true` to see detailed error messages**

### **Step 5: Check PHP Version & Extensions**
Your hosting must support:
- **PHP 8.1 or higher** (Laravel 11 requirement)
- **Required PHP extensions**:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - SQLite (for your database)
  - Tokenizer
  - XML

### **Step 6: Verify Composer Dependencies**
If you have SSH access:
```bash
cd /home/u806902440/public_html
composer install --no-dev --optimize-autoloader
```

If no SSH, make sure you uploaded the complete `vendor/` folder.

### **Step 7: Clear Cache (if accessible)**
```bash
cd /home/u806902440/public_html
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### **Step 8: Check .htaccess File**
Make sure your `.htaccess` in public_html root contains:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### **Step 9: Test Basic PHP**
Create a test file `test.php` in public_html:

```php
<?php
phpinfo();
echo "PHP is working!";
?>
```

Visit `https://psanashik.in/test.php` to verify PHP is working.

### **Step 10: Check Laravel Entry Point**
Verify your `index.php` contains:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

## 🚨 **Most Likely Causes:**

### **1. Missing .env file or wrong APP_KEY**
- Solution: Upload the correct `.env` file with your APP_KEY

### **2. Wrong file permissions**
- Solution: Set storage/ and bootstrap/cache/ to 755

### **3. Missing vendor/ folder**
- Solution: Upload complete vendor/ directory or run composer install

### **4. PHP version too old**
- Solution: Upgrade to PHP 8.1+ in cPanel

### **5. Missing PHP extensions**
- Solution: Enable required extensions in cPanel or contact hosting support

### **6. Wrong file structure**
- Solution: Make sure all Laravel files are in public_html root

## 🔧 **Quick Diagnostic Steps:**

1. **Check cPanel Error Logs** - This will tell you the exact error
2. **Set APP_DEBUG=true** in .env to see detailed errors
3. **Test basic PHP** with a simple phpinfo() file
4. **Verify file permissions** especially storage/ and bootstrap/cache/
5. **Check if .env file exists** and has correct APP_KEY

## 📞 **If Still Not Working:**

1. **Share the exact error** from cPanel Error Logs
2. **Confirm PHP version** in cPanel
3. **Verify file structure** - make sure all files are uploaded correctly
4. **Check hosting requirements** - some shared hosts have restrictions

The error logs will give us the exact cause of the 500 error!