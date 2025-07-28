# 🚀 PSA Sports Academy - Deployment Guide

## Quick Deployment Steps

### 1. Upload Files
- Extract the ZIP file to your computer
- Upload ALL files to your `public_html` directory via FTP/cPanel File Manager
- Make sure `.htaccess` and `.env` files are uploaded (they might be hidden)

### 2. Set File Permissions
```bash
chmod 755 public_html/
chmod 644 public_html/.htaccess
chmod 644 public_html/.env
chmod -R 755 public_html/storage/
chmod -R 755 public_html/bootstrap/cache/
chmod 664 public_html/database/database.sqlite
```

### 3. Installation Options

#### Option A: Laravel Installer (Recommended)
1. Visit: `https://psanashik.in/install`
2. Follow the step-by-step installation wizard
3. Create admin account when prompted

#### Option B: Simple PHP Installer (If Option A fails)
1. Visit: `https://psanashik.in/install.php`
2. Click "Install PSA Sports Academy"
3. Use default credentials: `admin@psa.com` / `password`

#### Option C: Manual Installation (SSH Access Required)
```bash
cd /home/u806902440/public_html
php artisan migrate --seed
```

### 4. Post-Installation
1. **Delete installer files** for security:
   - Delete `install.php`
   - Delete `debug.php`
2. **Change default password** immediately
3. **Configure email settings** in admin panel
4. **Set up WhatsApp bot** (optional)

## Default Login Credentials
- **Email:** admin@psa.com
- **Password:** password
- **⚠️ Change immediately after first login!**

## Troubleshooting

### If you see "Page Not Found" for /install:
1. Check if `.htaccess` file exists and has correct content
2. Ensure Apache mod_rewrite is enabled
3. Try direct access: `https://psanashik.in/index.php/install`
4. Use the alternative installer: `https://psanashik.in/install.php`

### If you see HTTP 500 errors:
1. Check file permissions (see step 2 above)
2. Ensure SQLite database file exists: `database/database.sqlite`
3. Run the debug tool: `https://psanashik.in/debug.php`
4. Check error logs in cPanel

### Database Issues:
- The app uses SQLite (no MySQL setup required)
- Database file: `database/database.sqlite`
- If missing, create empty file: `touch database/database.sqlite`

## Features Included

### ✅ Complete Laravel 11 Application
- Modern dark theme UI
- Role-based access (Admin, Coach, Student)
- Student management
- Fee tracking and payments
- Attendance system
- Batch management
- Sports and coach management

### ✅ Production Ready
- Optimized for shared hosting
- SQLite database (no MySQL required)
- Security headers configured
- Error handling and logging
- API ready for mobile apps

### ✅ Installation Tools
- Web-based installer
- Alternative PHP installer
- Debug diagnostic tool
- Comprehensive documentation

## Support

If you encounter any issues:
1. Run the debug tool: `https://psanashik.in/debug.php`
2. Check the deployment guide
3. Contact support with debug results

## Security Notes

- Delete `install.php` and `debug.php` after installation
- Change default admin password immediately
- Keep Laravel and dependencies updated
- Regular database backups recommended

---

**🎉 Your PSA Sports Academy is ready to use!**

Visit: https://psanashik.in/login