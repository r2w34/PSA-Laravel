# ⚡ PSA Sports Academy - Quick Deployment Steps

## 🎯 **FASTEST WAY TO GET YOUR APP RUNNING**

### **Option 1: cPanel File Manager (Easiest)**

1. **Login to cPanel** → **File Manager**
2. **Go to public_html**
3. **Move your backup folder** to a safe location temporarily
4. **Upload** `psa-sports-academy-public-html.zip`
5. **Extract** the ZIP file
6. **Move all files** from extracted folder to public_html root
7. **Put your backup folder back**
8. **Visit** https://psanashik.in/install.php

### **Option 2: FTP Upload**

**FTP Details:**
- Host: 46.202.161.4
- User: u806902440.psanashik.in
- Pass: Kalilinux@2812
- Port: 21

**Steps:**
1. **Connect via FTP client** (FileZilla recommended)
2. **Download your backup folder** to keep it safe
3. **Upload all PSA files** to public_html
4. **Upload your backup folder back**
5. **Visit** https://psanashik.in/install.php

---

## 🔧 **Essential File Permissions**

Set these permissions after upload:
```
storage/ → 755
bootstrap/cache/ → 755
database/database.sqlite → 664
.env → 644
.htaccess → 644
```

---

## 🚀 **Installation URLs**

Try these in order:
1. **https://psanashik.in/debug.php** - Check what's wrong
2. **https://psanashik.in/install.php** - Simple installer
3. **https://psanashik.in/install** - Laravel installer

---

## 🔑 **Default Login**

After installation:
- **URL**: https://psanashik.in/login
- **Email**: admin@psa.com
- **Password**: password

**⚠️ Change password immediately!**

---

## 📞 **Need Help?**

If something goes wrong:
1. **Visit debug.php** first
2. **Share the output** with me
3. **I'll give you specific fixes**

**Your backup folder will be 100% safe throughout this process!**