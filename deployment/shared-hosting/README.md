# PSA Sports Academy - Shared Hosting Deployment Guide

## Overview
This package contains the complete PSA Sports Academy Management System built with Laravel 11, ready for deployment on shared hosting platforms like cPanel.

## Features
- ✅ Laravel 11 with MySQL database
- ✅ Dark theme UI with responsive design
- ✅ Role-based access (Admin, Coach, Student)
- ✅ Student management with search functionality
- ✅ Fee payment system with Razorpay integration
- ✅ WhatsApp bot integration for notifications
- ✅ Comprehensive settings management
- ✅ RESTful API for mobile app support
- ✅ Installation wizard for easy setup

## System Requirements
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Node.js 18+ (for WhatsApp bot)
- Composer
- Web server (Apache/Nginx)

## Installation Steps

### 1. Upload Files
1. Extract the `psa-laravel-app.zip` to your hosting account
2. Upload the contents of `public` folder to your domain's public_html directory
3. Upload the rest of the Laravel application to a folder outside public_html (e.g., `laravel-app`)

### 2. Configure File Permissions
Set the following permissions:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
```

### 3. Update Public Path
Edit `public_html/index.php` and update the paths:
```php
require __DIR__.'/../laravel-app/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel-app/bootstrap/app.php';
```

### 4. Run Installation Wizard
1. Visit your domain: `https://yourdomain.com/install`
2. Follow the step-by-step installation wizard:
   - Database configuration
   - Environment setup
   - Admin account creation
   - System verification

### 5. WhatsApp Bot Setup (Optional)
1. Upload `whatsapp-bot` folder to your server
2. Install Node.js dependencies: `npm install`
3. Configure WhatsApp settings in Laravel admin panel
4. Start the bot service: `node mock-service.js` (or setup with PM2)

## Default Login Credentials
- **Email:** admin@psa.com
- **Password:** password

**⚠️ Important:** Change the default password immediately after first login!

## Configuration Files Included
- `.env.example` - Environment configuration template
- `database.sql` - Database structure and sample data
- `nginx.conf` - Nginx configuration (if applicable)
- `htaccess.txt` - Apache configuration (rename to .htaccess)

## Post-Installation
1. Update `.env` file with your database credentials
2. Configure mail settings for notifications
3. Set up Razorpay keys for payment processing
4. Configure WhatsApp bot settings
5. Test all functionality

## Support
For technical support or customization requests, please contact the development team.

## Security Notes
- Keep Laravel and dependencies updated
- Use strong passwords
- Enable HTTPS
- Regular database backups
- Monitor error logs

---
**PSA Sports Academy Management System v1.0**
Built with Laravel 11 | Developed for Production Use