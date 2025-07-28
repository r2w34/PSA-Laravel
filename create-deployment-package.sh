#!/bin/bash

# PSA Sports Academy Management Suite - Deployment Package Creator
# This script creates a production-ready deployment package for shared hosting

echo "🏏 PSA Sports Academy - Creating Deployment Package"
echo "=================================================="

# Configuration
PACKAGE_NAME="psa-sports-academy-v$(date +%Y%m%d-%H%M%S)"
TEMP_DIR="/tmp/$PACKAGE_NAME"
CURRENT_DIR=$(pwd)

# Create temporary directory
echo "📁 Creating temporary directory..."
mkdir -p "$TEMP_DIR"

# Copy Laravel application
echo "📋 Copying Laravel application..."
cp -r laravel-app/* "$TEMP_DIR/"

# Copy WhatsApp bot
echo "🤖 Copying WhatsApp bot..."
cp -r whatsapp-bot "$TEMP_DIR/"

# Copy installer
echo "⚙️ Copying installer..."
cp install.php "$TEMP_DIR/"

# Create production .env template
echo "🔧 Creating production .env template..."
cat > "$TEMP_DIR/.env.example" << 'EOF'
APP_NAME="PSA Sports Academy"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# WhatsApp Bot Configuration
WHATSAPP_ENABLED=true
WHATSAPP_BOT_URL=http://localhost:3001
WHATSAPP_WEBHOOK_SECRET=your_webhook_secret
WHATSAPP_TIMEOUT=30
EOF

# Create deployment README
echo "📖 Creating deployment README..."
cat > "$TEMP_DIR/DEPLOYMENT_README.md" << 'EOF'
# PSA Sports Academy Management Suite - Deployment Guide

## 🚀 Quick Installation (Shared Hosting)

### Method 1: Web Installer (Recommended)
1. Upload all files to your hosting directory
2. Visit `http://yourdomain.com/install.php` in your browser
3. Follow the step-by-step installation wizard
4. Delete `install.php` after successful installation

### Method 2: Manual Installation
1. Upload all files to your hosting directory
2. Create database and user in cPanel
3. Copy `.env.example` to `.env` and configure database settings
4. Run: `php artisan key:generate`
5. Run: `php artisan migrate --seed`
6. Create admin user: `php artisan make:admin`

## 📋 Server Requirements

- PHP 8.2 or higher
- MySQL 5.7 or higher
- Extensions: PDO, OpenSSL, Mbstring, Tokenizer, XML
- Minimum 50MB disk space
- Writable storage and bootstrap/cache directories

## 🔧 Configuration

### Database Setup
1. Create MySQL database in cPanel
2. Create database user with full privileges
3. Update `.env` file with database credentials

### WhatsApp Bot Setup (Optional)
1. Install Node.js on your server
2. Navigate to `whatsapp-bot` directory
3. Run: `npm install`
4. Start bot: `npm start` or use PM2: `pm2 start ecosystem.config.js`

### Queue Workers (For WhatsApp Integration)
Add to crontab for queue processing:
```bash
* * * * * cd /path/to/your/project && php artisan queue:work --stop-when-empty
```

## 🏗️ Directory Structure

```
/
├── app/                    # Laravel application core
├── bootstrap/              # Laravel bootstrap files
├── config/                 # Configuration files
├── database/              # Migrations and seeders
├── public/                # Public web files (document root)
├── resources/             # Views, assets, language files
├── routes/                # Route definitions
├── storage/               # Logs, cache, uploads
├── whatsapp-bot/          # WhatsApp bot service
├── install.php            # Web installer (delete after use)
└── .env                   # Environment configuration
```

## 🔐 Security Checklist

- [ ] Change default admin password
- [ ] Set APP_DEBUG=false in production
- [ ] Configure proper file permissions (755 for directories, 644 for files)
- [ ] Set storage/ and bootstrap/cache/ to 775
- [ ] Enable HTTPS
- [ ] Configure firewall rules
- [ ] Regular database backups

## 📱 Mobile App Integration

The Laravel application includes a complete REST API for mobile app integration:
- Base URL: `https://yourdomain.com/api/v1/`
- Authentication: Laravel Sanctum tokens
- Documentation: Available at `/api/documentation`

## 🆘 Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check file permissions
   - Verify .env configuration
   - Check error logs in storage/logs/

2. **Database Connection Error**
   - Verify database credentials in .env
   - Ensure database exists and user has privileges
   - Check database server status

3. **WhatsApp Bot Not Working**
   - Ensure Node.js is installed
   - Check bot logs in whatsapp-bot/logs/
   - Verify WHATSAPP_BOT_URL in .env

4. **Queue Jobs Not Processing**
   - Set up cron job for queue worker
   - Check queue table exists (run migrations)
   - Verify QUEUE_CONNECTION=database in .env

### Support

For technical support, please contact:
- Email: support@psa-academy.com
- Documentation: https://docs.psa-academy.com
- GitHub Issues: https://github.com/your-repo/issues

## 📊 Default Login Credentials

After installation, use these credentials to login:
- Email: admin@psa.com
- Password: password (change immediately after first login)

## 🔄 Updates

To update the application:
1. Backup your database and files
2. Upload new application files
3. Run: `php artisan migrate`
4. Clear cache: `php artisan cache:clear`
5. Optimize: `php artisan optimize`

---

**PSA Sports Academy Management Suite v1.0**
*Complete sports academy management solution with WhatsApp integration*
EOF

# Set proper permissions
echo "🔐 Setting file permissions..."
find "$TEMP_DIR" -type f -exec chmod 644 {} \;
find "$TEMP_DIR" -type d -exec chmod 755 {} \;
chmod 775 "$TEMP_DIR/storage" "$TEMP_DIR/bootstrap/cache" 2>/dev/null || true

# Create deployment package
echo "📦 Creating deployment package..."
cd /tmp
tar -czf "$CURRENT_DIR/$PACKAGE_NAME.tar.gz" "$PACKAGE_NAME"
zip -r "$CURRENT_DIR/$PACKAGE_NAME.zip" "$PACKAGE_NAME" > /dev/null 2>&1

# Cleanup
echo "🧹 Cleaning up..."
rm -rf "$TEMP_DIR"

# Success message
echo ""
echo "✅ Deployment package created successfully!"
echo "📦 Package: $PACKAGE_NAME.tar.gz"
echo "📦 Package: $PACKAGE_NAME.zip"
echo ""
echo "🚀 Deployment Instructions:"
echo "1. Upload the package to your hosting account"
echo "2. Extract the files to your domain directory"
echo "3. Visit http://yourdomain.com/install.php"
echo "4. Follow the installation wizard"
echo "5. Delete install.php after successful installation"
echo ""
echo "📖 For detailed instructions, see DEPLOYMENT_README.md in the package"
echo ""
echo "🎉 PSA Sports Academy is ready for deployment!"