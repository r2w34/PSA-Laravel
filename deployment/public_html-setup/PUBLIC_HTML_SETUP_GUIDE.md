# 🚀 PSA Sports Academy - Public_HTML Setup Guide

## 📋 Setup for Running Entire App in public_html Directory

Since you want to run the entire Laravel application directly from `public_html` on your main domain (psanashik.in), here's the complete setup guide:

## 🔧 **Step 1: File Structure Setup**

### Upload all Laravel files to public_html:
```
/home/u806902440/public_html/
├── .env                    # Your environment file
├── .htaccess              # Laravel routing rules
├── index.php              # Laravel entry point (NO changes needed)
├── artisan                # Laravel command line tool
├── composer.json          # Dependencies
├── app/                   # Application code
├── bootstrap/             # Laravel bootstrap
├── config/                # Configuration files
├── database/              # Database files and migrations
│   └── database.sqlite    # SQLite database file (create this)
├── public/                # Public assets (CSS, JS, images)
├── resources/             # Views, CSS, JS source
├── routes/                # Route definitions
├── storage/               # Storage and cache
├── vendor/                # Composer dependencies
└── whatsapp-bot/          # WhatsApp service (optional)
```

## 🗄️ **Step 2: SQLite Database Setup**

### Create SQLite database file:
1. **Create database directory** in public_html:
   ```bash
   mkdir /home/u806902440/public_html/database
   ```

2. **Create SQLite database file**:
   ```bash
   touch /home/u806902440/public_html/database/database.sqlite
   ```

3. **Set proper permissions**:
   ```bash
   chmod 664 /home/u806902440/public_html/database/database.sqlite
   chmod 755 /home/u806902440/public_html/database/
   ```

## ⚙️ **Step 3: Environment Configuration**

### Use this `.env` file (save as `/home/u806902440/public_html/.env`):

```env
APP_NAME="PSA Sports Academy"
APP_ENV=production
APP_KEY=base64:YXprNDdiN3RtaG54b2E0OHl1czl4eTd6bWQ3NDN1eXE=
APP_DEBUG=false
APP_TIMEZONE=Asia/Kolkata
APP_URL=https://psanashik.in

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# SQLite Database Configuration
DB_CONNECTION=sqlite
DB_DATABASE=/home/u806902440/public_html/database/database.sqlite

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

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="PSA Sports Academy"

# Razorpay Configuration
RAZORPAY_KEY_ID=your_razorpay_key_id
RAZORPAY_KEY_SECRET=your_razorpay_key_secret

# WhatsApp Bot Configuration
WHATSAPP_BOT_URL=http://localhost:3001
WHATSAPP_ENABLED=true
FEE_REMINDER_ENABLED=true
ATTENDANCE_NOTIFICATION_ENABLED=true
SESSION_NOTIFICATION_ENABLED=true
```

## 🔐 **Step 4: File Permissions**

Set the correct permissions for Laravel:

```bash
# Storage and cache directories
chmod -R 755 /home/u806902440/public_html/storage/
chmod -R 755 /home/u806902440/public_html/bootstrap/cache/

# Environment file
chmod 644 /home/u806902440/public_html/.env

# Make artisan executable
chmod +x /home/u806902440/public_html/artisan
```

## 🗃️ **Step 5: Database Migration**

### Using SSH/Terminal (if available):
```bash
cd /home/u806902440/public_html
php artisan migrate --seed
php artisan storage:link
```

### Using cPanel File Manager (if no SSH):
1. **Create database tables manually**:
   - Download SQLite browser or use online SQLite editor
   - Import the SQL structure from `database/migrations/`

### Or use the Installation Wizard:
Visit: `https://psanashik.in/install`

## 🌐 **Step 6: .htaccess Configuration**

Create/update `.htaccess` in public_html root:

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

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Frame-Options DENY
    Header always set X-Content-Type-Options nosniff
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

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
```

## 🚀 **Step 7: Final Setup**

### Option A: Automatic Setup (Recommended)
Visit: `https://psanashik.in/install`
- The installation wizard will handle database setup
- Create admin account
- Configure system settings

### Option B: Manual Setup
If you have SSH access:
```bash
cd /home/u806902440/public_html
php artisan migrate --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔑 **Default Login Credentials**
- **URL**: https://psanashik.in/login
- **Email**: admin@psa.com
- **Password**: password
- **⚠️ Change immediately after first login!**

## 🛠️ **Troubleshooting**

### Common Issues:

**1. SQLite Permission Error**
```bash
chmod 664 /home/u806902440/public_html/database/database.sqlite
chmod 755 /home/u806902440/public_html/database/
```

**2. Storage Permission Error**
```bash
chmod -R 755 /home/u806902440/public_html/storage/
chmod -R 755 /home/u806902440/public_html/bootstrap/cache/
```

**3. 500 Internal Server Error**
- Check `.env` file exists and has correct APP_KEY
- Verify file permissions
- Check error logs in cPanel

**4. Database Connection Error**
- Ensure SQLite file exists and is writable
- Check database path in `.env` file
- Verify SQLite extension is enabled in PHP

## 📁 **File Upload Instructions**

1. **Extract the Laravel app** from the deployment package
2. **Upload ALL files** to `/home/u806902440/public_html/`
3. **Replace the `.env` file** with the one provided above
4. **Create the SQLite database file** as instructed
5. **Set file permissions** as specified
6. **Visit** `https://psanashik.in/install` to complete setup

## ✅ **Verification**

After setup, you should be able to:
- ✅ Visit https://psanashik.in (see login page)
- ✅ Login with admin credentials
- ✅ Access admin dashboard
- ✅ Manage students, coaches, and fees
- ✅ Use WhatsApp integration
- ✅ Generate reports

Your PSA Sports Academy will be fully operational on your main domain!