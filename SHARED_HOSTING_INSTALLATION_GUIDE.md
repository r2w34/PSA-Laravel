# 🚀 PSA Sports Academy - Shared Hosting Installation Guide

## 📦 What You Have
Your complete PSA Sports Academy Laravel application is ready for deployment with:
- **Deployment Package**: `deployment/shared-hosting/psa-sports-academy-shared-hosting.zip` (48MB)
- **Complete Laravel 11 Application** with all dependencies
- **WhatsApp Bot Integration** with mock service
- **Installation Wizard** for easy setup
- **Production-ready configuration**

## 🎯 Quick Installation Steps

### Step 1: Download the Deployment Package
1. Go to your GitHub repository: `https://github.com/r2w34/PSA-NASHIK`
2. Navigate to `deployment/shared-hosting/`
3. Download `psa-sports-academy-shared-hosting.zip`

### Step 2: Prepare Your Shared Hosting
**Requirements:**
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer (most shared hosts have this)
- At least 100MB disk space

### Step 3: Upload and Extract
1. **Upload** the ZIP file to your hosting account
2. **Extract** it in your hosting root directory
3. You'll see these folders:
   ```
   ├── psa-laravel-app/          # Main Laravel application
   ├── whatsapp-bot/             # WhatsApp service
   ├── config/                   # Configuration files
   ├── database/                 # Database structure & sample data
   ├── install.sh               # Installation script
   └── README.md                # Documentation
   ```

### Step 4: Setup File Structure
**For cPanel/Shared Hosting:**
1. **Move Laravel app** outside public_html:
   ```
   /home/yourusername/psa-laravel-app/
   ```

2. **Copy public folder contents** to public_html:
   ```
   /home/yourusername/public_html/
   ```

3. **Update index.php** in public_html:
   ```php
   require __DIR__.'/../psa-laravel-app/vendor/autoload.php';
   $app = require_once __DIR__.'/../psa-laravel-app/bootstrap/app.php';
   ```

### Step 5: Database Setup
1. **Create MySQL Database** in cPanel
2. **Import database structure**:
   - Use phpMyAdmin or MySQL import
   - Import `database/sample-data.sql` for sample data

### Step 6: Environment Configuration
1. **Copy** `config/.env.example` to `psa-laravel-app/.env`
2. **Update** database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```
3. **Set your domain**:
   ```env
   APP_URL=https://yourdomain.com
   ```

### Step 7: Run Installation
1. **SSH into your hosting** (if available) or use cPanel Terminal
2. **Navigate** to your Laravel app directory
3. **Run installation**:
   ```bash
   cd psa-laravel-app
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```

### Step 8: Set Permissions
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
```

### Step 9: Complete Setup via Web Interface
1. **Visit**: `https://yourdomain.com/install`
2. **Follow the installation wizard**:
   - Database connection test
   - Admin account creation
   - System verification

## 🔐 Default Login Credentials
- **Email**: admin@psa.com
- **Password**: password
- **⚠️ Change immediately after first login!**

## 🤖 WhatsApp Bot Setup (Optional)
1. **Upload** `whatsapp-bot` folder to your server
2. **Install Node.js dependencies**:
   ```bash
   cd whatsapp-bot
   npm install
   ```
3. **Start the service**:
   ```bash
   node mock-service.js
   ```
4. **Configure in Laravel admin panel** → Settings → WhatsApp

## 🌐 Alternative: One-Click Installation

### If your host supports SSH:
```bash
# Extract and run the installation script
unzip psa-sports-academy-shared-hosting.zip
chmod +x install.sh
./install.sh
```

### If no SSH access:
1. Use cPanel File Manager to extract
2. Use phpMyAdmin for database setup
3. Use the web installation wizard at `/install`

## ⚙️ Configuration Files Included

### Apache (.htaccess)
- Copy `config/htaccess.txt` to `public_html/.htaccess`

### Nginx
- Use `config/nginx.conf` as reference for server configuration

## 🔧 Post-Installation Setup

### 1. Email Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
```

### 2. Payment Gateway (Razorpay)
```env
RAZORPAY_KEY_ID=your_razorpay_key_id
RAZORPAY_KEY_SECRET=your_razorpay_key_secret
```

### 3. WhatsApp Integration
```env
WHATSAPP_BOT_URL=http://localhost:3001
WHATSAPP_ENABLED=true
```

## 🚨 Troubleshooting

### Common Issues:

**1. 500 Internal Server Error**
- Check file permissions (755 for directories, 644 for files)
- Verify .env file exists and is readable
- Check error logs in cPanel

**2. Database Connection Error**
- Verify database credentials in .env
- Ensure database exists and user has permissions
- Check if host uses different port (not 3306)

**3. Composer Issues**
- Some shared hosts don't have Composer
- Upload vendor folder from local development
- Or use PHP 8.2+ compatible hosting

**4. Storage/Cache Issues**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📞 Support & Features

### What's Included:
✅ **Student Management** - Add, edit, search students
✅ **Fee Management** - Payment tracking with Razorpay
✅ **Coach Management** - Staff administration
✅ **Batch Scheduling** - Class management
✅ **WhatsApp Notifications** - Automated messaging
✅ **Reports & Analytics** - Comprehensive reporting
✅ **Role-based Access** - Admin, Coach, Student roles
✅ **Dark Theme UI** - Modern, responsive design
✅ **API Ready** - For future mobile app integration

### Admin Panel Access:
- **Dashboard**: Overview and statistics
- **Students**: Complete student management
- **Payments**: Fee collection and tracking
- **Coaches**: Staff management
- **Settings**: System configuration
- **Reports**: Analytics and insights

## 🎉 You're Ready!

After following these steps, your PSA Sports Academy will be fully operational on shared hosting with:
- Complete student management system
- Fee payment processing
- WhatsApp integration
- Professional admin panel
- Mobile-ready API

**Need help?** Check the included documentation or contact support.

---
**PSA Sports Academy Management System v1.0**  
*Built with Laravel 11 | Production Ready | Shared Hosting Optimized*