# 🚀 PSA Sports Academy - Public_HTML Installation Guide

## 📦 **READY-TO-UPLOAD PACKAGE**

This ZIP contains the complete PSA Sports Academy Laravel application configured for direct upload to your `public_html` directory.

---

## ⚡ **QUICK INSTALLATION STEPS**

### **Step 1: Upload Files**
1. **Extract this ZIP** to your computer
2. **Upload ALL files** to `/home/u806902440/public_html/`
3. **Maintain the directory structure** exactly as provided

### **Step 2: Set File Permissions**
Using cPanel File Manager or SSH:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 664 database/database.sqlite
chmod 755 database/
chmod 644 .env
chmod 644 .htaccess
```

### **Step 3: Complete Installation**
Visit: **https://psanashik.in/install**

The installation wizard will:
- ✅ Test database connection
- ✅ Run migrations and seeders
- ✅ Create admin account
- ✅ Configure system settings

---

## 🔑 **DEFAULT LOGIN CREDENTIALS**

After installation, login with:
- **URL**: https://psanashik.in/login
- **Email**: admin@psa.com
- **Password**: password
- **⚠️ IMPORTANT**: Change password immediately after first login!

---

## 📋 **PRE-CONFIGURED SETTINGS**

### ✅ **Environment Configuration**:
- **Domain**: https://psanashik.in
- **APP_KEY**: Your provided key (base64:YXprNDdiN3RtaG54b2E0OHl1czl4eTd6bWQ3NDN1eXE=)
- **Database**: SQLite (/home/u806902440/public_html/database/database.sqlite)
- **Environment**: Production-ready
- **Debug**: Disabled for security

### ✅ **Security Features**:
- CSRF protection enabled
- XSS protection headers
- Secure file permissions
- Hidden sensitive files (.env, composer files)
- SQL injection prevention

### ✅ **Included Features**:
- Complete student management system
- Coach and staff management
- Fee collection and payment tracking
- WhatsApp integration for notifications
- Razorpay payment gateway support
- Comprehensive reporting system
- Role-based access control

---

## 🛠️ **TROUBLESHOOTING**

### **If you get HTTP 500 Error:**
1. **Check file permissions** (see Step 2 above)
2. **Verify PHP version** is 8.1 or higher in cPanel
3. **Check cPanel Error Logs** for specific error messages
4. **Ensure SQLite database file exists** and is writable

### **If installation wizard doesn't work:**
1. **Manually run migrations** via SSH:
   ```bash
   cd /home/u806902440/public_html
   php artisan migrate --seed
   ```
2. **Or import database manually** using the provided SQL files

### **Common Issues:**
- **Missing PHP extensions**: Enable SQLite, PDO, OpenSSL in cPanel
- **Memory limit**: Increase PHP memory limit to 256MB+
- **File permissions**: Ensure storage/ and bootstrap/cache/ are writable

---

## 📁 **FILE STRUCTURE**

Your public_html should contain:
```
/home/u806902440/public_html/
├── .env                    # ✅ Environment configuration
├── .htaccess              # ✅ Apache rewrite rules
├── index.php              # ✅ Laravel entry point
├── artisan                # ✅ Laravel CLI tool
├── composer.json          # ✅ Dependencies
├── app/                   # ✅ Application code
├── bootstrap/             # ✅ Laravel bootstrap
├── config/                # ✅ Configuration files
├── database/              # ✅ Database and migrations
│   └── database.sqlite    # ✅ SQLite database file
├── public/                # ✅ Public assets (CSS, JS, images)
├── resources/             # ✅ Views and frontend assets
├── routes/                # ✅ Route definitions
├── storage/               # ✅ Storage and cache (must be writable)
├── vendor/                # ✅ Composer dependencies
└── whatsapp-bot/          # ✅ WhatsApp service (optional)
```

---

## 🎯 **WHAT'S INCLUDED**

### **Core Features:**
- ✅ Student registration and management
- ✅ Coach and staff management
- ✅ Batch and class scheduling
- ✅ Fee collection and payment tracking
- ✅ Attendance management
- ✅ WhatsApp notifications
- ✅ Comprehensive reporting
- ✅ Role-based access control

### **Payment Integration:**
- ✅ Razorpay gateway support
- ✅ Multiple payment methods
- ✅ Receipt generation
- ✅ Payment history tracking

### **WhatsApp Features:**
- ✅ Fee reminder notifications
- ✅ Session and class alerts
- ✅ Bulk messaging capabilities
- ✅ Automated notifications

### **Admin Features:**
- ✅ Complete dashboard with analytics
- ✅ User management
- ✅ System settings
- ✅ Report generation
- ✅ Data export capabilities

---

## 🔧 **SYSTEM REQUIREMENTS**

### **Server Requirements:**
- **PHP**: 8.1 or higher
- **MySQL/SQLite**: SQLite 3.8+ (included)
- **Web Server**: Apache with mod_rewrite
- **Memory**: 256MB+ PHP memory limit
- **Storage**: 100MB+ disk space

### **PHP Extensions Required:**
- BCMath, Ctype, Fileinfo, JSON, Mbstring
- OpenSSL, PDO, PDO_SQLite, Tokenizer, XML

---

## 📞 **SUPPORT**

If you encounter any issues:

1. **Check cPanel Error Logs** first
2. **Verify file permissions** are set correctly
3. **Ensure PHP version** is 8.1 or higher
4. **Test with the diagnostic tool** (upload test.php from repository)

---

## 🎉 **READY TO GO!**

Your PSA Sports Academy Management System is now ready for deployment. Simply upload, set permissions, and visit the installation wizard to get started!

**🌐 Installation URL**: https://psanashik.in/install
**📧 Admin Email**: admin@psa.com
**🔑 Admin Password**: password (change immediately!)

**Happy managing your sports academy! 🏆**