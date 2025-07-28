# 🖥️ PSA Sports Academy - Putty SSH Deployment Guide

## 🔐 **SSH Connection Setup**

### **Connection Details:**
- **Host**: 46.202.161.4 (or psanashik.in)
- **Port**: 22 (SSH) or 21 (FTP)
- **Username**: u806902440
- **Password**: Kalilinux@2812
- **Home Directory**: /home/u806902440/
- **Web Directory**: /home/u806902440/public_html/

---

## 🚀 **Method 1: SSH Connection (Recommended)**

### **Step 1: Connect via Putty**
1. **Open Putty**
2. **Host Name**: 46.202.161.4 or psanashik.in
3. **Port**: 22
4. **Connection Type**: SSH
5. **Click Open**
6. **Login as**: u806902440
7. **Password**: Kalilinux@2812

### **Step 2: Navigate to Web Directory**
```bash
cd /home/u806902440/public_html/
ls -la
```

### **Step 3: Backup Your Current Files**
```bash
# Create a backup of current files (excluding your backup folder)
mkdir -p /home/u806902440/backups/
cp -r /home/u806902440/public_html/backup /home/u806902440/backups/backup_$(date +%Y%m%d_%H%M%S)

# List current files
ls -la /home/u806902440/public_html/
```

### **Step 4: Download PSA Sports Academy**
```bash
# Go to public_html
cd /home/u806902440/public_html/

# Download the deployment package
wget https://github.com/r2w34/PSA-Laravel/raw/psa-laravel-complete/deployment/psa-sports-academy-public-html.zip

# Or if wget doesn't work, use curl:
curl -L -o psa-sports-academy-public-html.zip https://github.com/r2w34/PSA-Laravel/raw/psa-laravel-complete/deployment/psa-sports-academy-public-html.zip
```

### **Step 5: Extract and Deploy**
```bash
# Extract the ZIP file
unzip psa-sports-academy-public-html.zip

# Move files from extracted folder to public_html root
mv public_html-ready/* ./
mv public_html-ready/.* ./ 2>/dev/null || true

# Remove extracted folder and ZIP
rm -rf public_html-ready/
rm psa-sports-academy-public-html.zip

# Restore your backup folder if it was overwritten
if [ -d "/home/u806902440/backups/" ]; then
    cp -r /home/u806902440/backups/backup_* ./backup/
fi
```

### **Step 6: Set Proper Permissions**
```bash
# Set directory permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 755 database/

# Set file permissions
chmod 664 database/database.sqlite
chmod 644 .env
chmod 644 .htaccess
chmod +x artisan

# Create database file if it doesn't exist
touch database/database.sqlite
chmod 664 database/database.sqlite
```

### **Step 7: Run Installation**
```bash
# Check if PHP is available
php -v

# Run Laravel installation
php artisan migrate --seed --force

# Or if that doesn't work, try:
php install.php
```

---

## 🔧 **Method 2: SFTP via Putty (Alternative)**

### **Step 1: Use PSFTP (Putty SFTP)**
1. **Open Command Prompt/Terminal**
2. **Run**: `psftp 46.202.161.4`
3. **Login**: u806902440
4. **Password**: Kalilinux@2812

### **Step 2: Navigate and Upload**
```bash
# Navigate to public_html
cd public_html

# Upload your local PSA files
put psa-sports-academy-public-html.zip

# Exit PSFTP
quit
```

### **Step 3: Connect via SSH and Extract**
```bash
# Connect via SSH (as in Method 1)
cd /home/u806902440/public_html/
unzip psa-sports-academy-public-html.zip
# Continue with steps from Method 1
```

---

## 🛠️ **Troubleshooting Commands**

### **Check System Information**
```bash
# Check PHP version
php -v

# Check available disk space
df -h

# Check current directory
pwd

# List all files including hidden
ls -la

# Check file permissions
ls -l
```

### **Fix Common Issues**
```bash
# If storage permissions are wrong
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# If database file is missing
touch database/database.sqlite
chmod 664 database/database.sqlite

# If .env file has wrong permissions
chmod 644 .env

# Clear Laravel cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### **Manual Database Setup**
```bash
# If automatic migration fails
php artisan migrate --force
php artisan db:seed --force

# Create admin user manually
php artisan tinker
# Then in tinker:
# User::create(['name' => 'Admin', 'email' => 'admin@psa.com', 'password' => bcrypt('password'), 'role' => 'admin']);
# exit
```

---

## 📋 **Complete Deployment Script**

Here's a complete script you can run after SSH connection:

```bash
#!/bin/bash

# Navigate to web directory
cd /home/u806902440/public_html/

# Backup existing backup folder
if [ -d "backup" ]; then
    cp -r backup /home/u806902440/backup_safe_$(date +%Y%m%d_%H%M%S)
    echo "✅ Backup folder preserved"
fi

# Download PSA Sports Academy
echo "📥 Downloading PSA Sports Academy..."
wget -O psa-sports-academy-public-html.zip https://github.com/r2w34/PSA-Laravel/raw/psa-laravel-complete/deployment/psa-sports-academy-public-html.zip

# Extract files
echo "📦 Extracting files..."
unzip -q psa-sports-academy-public-html.zip

# Move files to root
echo "📁 Moving files..."
cp -r public_html-ready/* ./
cp -r public_html-ready/.* ./ 2>/dev/null || true

# Restore backup folder
if [ -d "/home/u806902440/backup_safe_"* ]; then
    cp -r /home/u806902440/backup_safe_* ./backup/
    echo "✅ Backup folder restored"
fi

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 755 database/
chmod 664 database/database.sqlite
chmod 644 .env
chmod 644 .htaccess
chmod +x artisan

# Clean up
rm -rf public_html-ready/
rm psa-sports-academy-public-html.zip

echo "🎉 Deployment complete!"
echo "🌐 Visit: https://psanashik.in/install.php"
echo "🔑 Login: admin@psa.com / password"
```

---

## 🔑 **After Deployment**

1. **Visit**: https://psanashik.in/install.php
2. **Complete installation**
3. **Login with**:
   - Email: admin@psa.com
   - Password: password
4. **Change password immediately**

---

## 📞 **If You Need Help**

1. **Run diagnostic**: https://psanashik.in/debug.php
2. **Check error logs**: `tail -f /home/u806902440/public_html/storage/logs/laravel.log`
3. **Share any error messages** with me

**Your backup folder will be completely safe throughout this process!**