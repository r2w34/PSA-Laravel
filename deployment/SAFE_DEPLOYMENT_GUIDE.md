# 🚀 PSA Sports Academy - Safe Deployment Guide

## ⚠️ **IMPORTANT: Backup Preservation**

This guide will help you deploy the PSA Sports Academy app while **keeping your existing backup folder safe**.

---

## 📋 **Pre-Deployment Checklist**

### **Step 1: Backup Current Files (Optional but Recommended)**
Before starting, create an additional backup of your current public_html:
1. **Login to cPanel File Manager**
2. **Compress** your current public_html folder
3. **Download** the compressed file as extra backup

### **Step 2: Download PSA Sports Academy Package**
1. **Go to**: https://github.com/r2w34/PSA-Laravel
2. **Navigate to**: `deployment/psa-sports-academy-public-html.zip`
3. **Download** the ZIP file (37MB)

---

## 🔧 **Safe Deployment Process**

### **Method 1: Using cPanel File Manager (Recommended)**

#### **Step 1: Access cPanel**
1. **Login to cPanel** for psanashik.in
2. **Open File Manager**
3. **Navigate to** `/public_html/`

#### **Step 2: Preserve Backup Folder**
1. **Locate your backup folder** in public_html
2. **Right-click** → **Copy** or **Cut**
3. **Move it temporarily** to parent directory (`/home/u806902440/`)
4. **Note the exact name** of your backup folder

#### **Step 3: Clear public_html (Except Backup)**
1. **Select all files/folders** in public_html EXCEPT your backup folder
2. **Delete** selected items
3. **Keep only** your backup folder

#### **Step 4: Upload PSA Sports Academy**
1. **Click Upload** in File Manager
2. **Select** `psa-sports-academy-public-html.zip`
3. **Upload** the file to public_html
4. **Right-click** the ZIP → **Extract**
5. **Move all extracted files** from `public_html-ready/` to `public_html/` root
6. **Delete** the empty `public_html-ready/` folder and ZIP file

#### **Step 5: Restore Backup Folder**
1. **Go back** to parent directory (`/home/u806902440/`)
2. **Cut/Copy** your backup folder
3. **Paste it back** into `/public_html/`
4. **Verify** backup folder is intact

### **Method 2: Using FTP Client**

#### **FTP Connection Details:**
- **Host**: 46.202.161.4
- **Username**: u806902440.psanashik.in
- **Password**: Kalilinux@2812
- **Port**: 21
- **Directory**: public_html

#### **Step 1: Connect via FTP**
1. **Use FTP client** (FileZilla, WinSCP, etc.)
2. **Connect** with provided credentials
3. **Navigate to** public_html folder

#### **Step 2: Backup Preservation**
1. **Download your backup folder** to local computer
2. **Keep it safe** during deployment

#### **Step 3: Upload PSA Files**
1. **Extract** `psa-sports-academy-public-html.zip` on your computer
2. **Upload all files** from `public_html-ready/` folder to FTP public_html
3. **Maintain directory structure**

#### **Step 4: Restore Backup**
1. **Upload your backup folder** back to public_html
2. **Verify** it's in the correct location

---

## 🔧 **Post-Deployment Setup**

### **Step 1: Set File Permissions**
Using cPanel File Manager or FTP:
```
storage/ → 755 (recursive)
bootstrap/cache/ → 755 (recursive)
database/database.sqlite → 664
.env → 644
.htaccess → 644
```

### **Step 2: Test Installation**
Visit these URLs in order:
1. **https://psanashik.in/debug.php** - System diagnostic
2. **https://psanashik.in/install.php** - Alternative installer
3. **https://psanashik.in/install** - Laravel installer (if working)

### **Step 3: Complete Installation**
1. **Follow installation wizard**
2. **Create admin account** or use default:
   - Email: admin@psa.com
   - Password: password
3. **Login** and change password immediately

---

## 📁 **Final Directory Structure**

Your public_html should look like this:
```
/public_html/
├── backup/                 # ✅ Your preserved backup folder
├── .env                   # ✅ PSA configuration
├── .htaccess             # ✅ Laravel routing
├── index.php             # ✅ Laravel entry point
├── artisan               # ✅ Laravel CLI
├── app/                  # ✅ Application code
├── bootstrap/            # ✅ Laravel bootstrap
├── config/               # ✅ Configuration
├── database/             # ✅ Database files
├── public/               # ✅ Public assets
├── resources/            # ✅ Views and assets
├── routes/               # ✅ Route definitions
├── storage/              # ✅ Storage and cache
├── vendor/               # ✅ Dependencies
├── debug.php             # ✅ Diagnostic tool
└── install.php           # ✅ Alternative installer
```

---

## 🚨 **Troubleshooting**

### **If Installation Fails:**
1. **Check debug.php** output
2. **Verify file permissions**
3. **Check PHP version** (needs 8.1+)
4. **Contact hosting support** if needed

### **If Backup Folder Missing:**
1. **Check parent directory** (`/home/u806902440/`)
2. **Look in cPanel Trash/Recycle Bin**
3. **Restore from your additional backup**

### **Common Issues:**
- **500 Error**: Check file permissions and .env file
- **Page Not Found**: Verify .htaccess file exists
- **Database Error**: Ensure SQLite file is writable

---

## 📞 **Support**

If you encounter issues:
1. **Share debug.php output**
2. **Describe specific error messages**
3. **Confirm backup folder is safe**

---

## ✅ **Success Checklist**

- [ ] Backup folder preserved in public_html
- [ ] PSA Sports Academy files uploaded
- [ ] File permissions set correctly
- [ ] Installation completed successfully
- [ ] Admin login working
- [ ] All features accessible

**🎉 Your PSA Sports Academy will be running while keeping your backup folder completely safe!**