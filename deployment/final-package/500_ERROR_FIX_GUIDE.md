# 🚨 PSA Sports Academy - 500 Error Fix Guide

## Quick Fix Steps

### 1. 🔧 Run the Automatic Fix Tool
Visit: `https://psanashik.in/fix-500-error.php`

This tool will automatically:
- ✅ Fix file permissions
- ✅ Create SQLite database
- ✅ Clear Laravel caches
- ✅ Test database connection
- ✅ Run migrations if possible

### 2. 🔄 Alternative Installation Methods

If the main installer fails, try these alternatives:

**Option A: Simple PHP Installer**
- Visit: `https://psanashik.in/install.php`

**Option B: Laravel Web Installer**
- Visit: `https://psanashik.in/install`

**Option C: Debug Tool**
- Visit: `https://psanashik.in/debug.php`

## Manual Fix Steps (If Automatic Fix Fails)

### Step 1: File Permissions via cPanel File Manager

1. **Login to cPanel** → File Manager
2. **Navigate to public_html**
3. **Right-click on folders** and select "Change Permissions":

```
storage/                → 755
storage/logs/           → 755
storage/framework/      → 755
storage/framework/cache → 755
bootstrap/cache/        → 755
database/               → 755
```

4. **Right-click on files** and set permissions:
```
.env                    → 644
database/database.sqlite → 664
```

### Step 2: Create Missing Database File

If `database/database.sqlite` is missing:

1. **In cPanel File Manager:**
   - Navigate to `public_html/database/`
   - Click "New File"
   - Name it: `database.sqlite`
   - Set permissions to `664`

### Step 3: Clear Laravel Caches

Delete these files if they exist:
```
bootstrap/cache/config.php
bootstrap/cache/routes.php
bootstrap/cache/services.php
bootstrap/cache/packages.php
```

### Step 4: Check .env Configuration

Ensure your `.env` file contains:
```
APP_NAME="PSA Sports Academy"
APP_ENV=production
APP_KEY=base64:XDA5GLXZPoys+kSeKAPorosXJAkDC/7nMGak7gHjqvw=
APP_DEBUG=false
APP_URL=https://psanashik.in

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

## Common 500 Error Causes & Solutions

### ❌ Cause 1: Missing index.php
**Solution:** Ensure `index.php` exists in your root directory (public_html)

### ❌ Cause 2: Wrong file permissions
**Solution:** Set proper permissions as shown above

### ❌ Cause 3: SQLite database issues
**Solution:** 
- Ensure `database/database.sqlite` exists
- Set permissions to 664
- Ensure database directory is writable

### ❌ Cause 4: Laravel cache conflicts
**Solution:** Clear all cache files in `bootstrap/cache/`

### ❌ Cause 5: Missing .env file
**Solution:** Ensure `.env` file exists with correct configuration

### ❌ Cause 6: PHP version compatibility
**Solution:** Ensure PHP 8.1+ is enabled in cPanel

## SSH Commands (If Available)

If you have SSH access, run these commands:

```bash
# Navigate to your directory
cd /home/u806902440/domains/psanashik.in/public_html

# Fix permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 664 database/database.sqlite
chmod 644 .env

# Clear caches
rm -f bootstrap/cache/*.php

# Run Laravel commands
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
php artisan db:seed --force
```

## Verification Steps

After applying fixes:

1. **Test Homepage:** `https://psanashik.in/`
2. **Test Installer:** `https://psanashik.in/install`
3. **Test Login:** `https://psanashik.in/login`

## Default Login Credentials

After successful installation:
- **Email:** admin@psa.com
- **Password:** password

⚠️ **Change these immediately after first login!**

## Still Getting 500 Errors?

### Check Error Logs
1. **cPanel → Error Logs**
2. **Check:** `storage/logs/laravel.log`
3. **Look for:** Specific error messages

### Contact Support
If all else fails, provide:
- Error log contents
- Results from `debug.php`
- Results from `fix-500-error.php`

## Security Note

🔒 **After fixing the issue, delete these files for security:**
- `fix-500-error.php`
- `debug.php`
- `install.php` (after successful installation)

## Success Indicators

✅ **Installation Successful When:**
- Homepage loads without errors
- Login page is accessible
- Can login with admin credentials
- Dashboard displays properly

---

**Need Help?** Run the automatic fix tool first: `https://psanashik.in/fix-500-error.php`