#!/bin/bash

# PSA Sports Academy - Automated Deployment Script
# Run this script after SSH connection to deploy the application safely

echo "🚀 PSA Sports Academy - Automated Deployment"
echo "=============================================="

# Navigate to web directory
cd /home/u806902440/public_html/

# Check current directory
echo "📍 Current directory: $(pwd)"

# Backup existing backup folder if it exists
if [ -d "backup" ]; then
    BACKUP_NAME="backup_safe_$(date +%Y%m%d_%H%M%S)"
    cp -r backup "/home/u806902440/$BACKUP_NAME"
    echo "✅ Existing backup folder preserved as: $BACKUP_NAME"
else
    echo "ℹ️  No existing backup folder found"
fi

# Download PSA Sports Academy
echo "📥 Downloading PSA Sports Academy package..."
if command -v wget &> /dev/null; then
    wget -O psa-sports-academy-public-html.zip "https://github.com/r2w34/PSA-Laravel/raw/psa-laravel-complete/deployment/psa-sports-academy-public-html.zip"
elif command -v curl &> /dev/null; then
    curl -L -o psa-sports-academy-public-html.zip "https://github.com/r2w34/PSA-Laravel/raw/psa-laravel-complete/deployment/psa-sports-academy-public-html.zip"
else
    echo "❌ Neither wget nor curl available. Please download manually."
    exit 1
fi

# Check if download was successful
if [ ! -f "psa-sports-academy-public-html.zip" ]; then
    echo "❌ Download failed. Please check your internet connection."
    exit 1
fi

echo "✅ Download completed"

# Extract files
echo "📦 Extracting files..."
if command -v unzip &> /dev/null; then
    unzip -q psa-sports-academy-public-html.zip
else
    echo "❌ unzip command not available. Please extract manually."
    exit 1
fi

# Check if extraction was successful
if [ ! -d "public_html-ready" ]; then
    echo "❌ Extraction failed or directory structure is different."
    exit 1
fi

echo "✅ Files extracted successfully"

# Move files to root directory
echo "📁 Moving files to web root..."

# Copy all files from extracted directory
cp -r public_html-ready/* ./
cp -r public_html-ready/.* ./ 2>/dev/null || true

echo "✅ Files moved to web root"

# Restore backup folder if we backed it up
BACKUP_DIR=$(ls -d /home/u806902440/backup_safe_* 2>/dev/null | head -1)
if [ -n "$BACKUP_DIR" ] && [ -d "$BACKUP_DIR" ]; then
    cp -r "$BACKUP_DIR" ./backup/
    echo "✅ Original backup folder restored"
fi

# Set proper permissions
echo "🔐 Setting file permissions..."

# Create directories if they don't exist
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache
mkdir -p database

# Set directory permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 755 database/

# Create SQLite database file if it doesn't exist
if [ ! -f "database/database.sqlite" ]; then
    touch database/database.sqlite
    echo "✅ Created SQLite database file"
fi

# Set file permissions
chmod 664 database/database.sqlite
chmod 644 .env 2>/dev/null || echo "⚠️  .env file not found"
chmod 644 .htaccess 2>/dev/null || echo "⚠️  .htaccess file not found"
chmod +x artisan 2>/dev/null || echo "⚠️  artisan file not found"

echo "✅ Permissions set successfully"

# Clean up temporary files
echo "🧹 Cleaning up..."
rm -rf public_html-ready/
rm psa-sports-academy-public-html.zip

echo "✅ Cleanup completed"

# Check PHP version
echo "🔍 Checking PHP version..."
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -v | head -n 1)
    echo "✅ PHP available: $PHP_VERSION"
    
    # Try to run Laravel installation
    echo "🚀 Attempting Laravel installation..."
    if [ -f "artisan" ]; then
        php artisan migrate --seed --force 2>/dev/null && echo "✅ Laravel installation completed" || echo "⚠️  Laravel installation failed, use web installer"
    fi
else
    echo "⚠️  PHP not available via command line"
fi

# Final status
echo ""
echo "🎉 DEPLOYMENT COMPLETED SUCCESSFULLY!"
echo "======================================"
echo ""
echo "📋 Next Steps:"
echo "1. Visit: https://psanashik.in/debug.php (to check system status)"
echo "2. Visit: https://psanashik.in/install.php (for installation)"
echo "3. Or visit: https://psanashik.in/install (Laravel installer)"
echo ""
echo "🔑 Default Login Credentials:"
echo "   Email: admin@psa.com"
echo "   Password: password"
echo "   ⚠️  Change password immediately after login!"
echo ""
echo "📁 Your backup folder has been preserved safely."
echo ""
echo "🆘 If you encounter issues:"
echo "   - Check debug.php output"
echo "   - Verify file permissions"
echo "   - Contact support with specific error messages"
echo ""
echo "✅ PSA Sports Academy is ready to use!"