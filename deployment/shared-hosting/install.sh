#!/bin/bash

echo "🚀 PSA Sports Academy Installation Script"
echo "========================================"

# Check PHP version
php_version=$(php -v | head -n 1 | cut -d " " -f 2 | cut -d "." -f 1,2)
required_version="8.2"

if [ "$(printf '%s\n' "$required_version" "$php_version" | sort -V | head -n1)" != "$required_version" ]; then
    echo "❌ PHP $required_version or higher is required. Current version: $php_version"
    exit 1
fi

echo "✅ PHP version check passed: $php_version"

# Install Composer dependencies
if [ ! -f "psa-laravel-app/vendor/autoload.php" ]; then
    echo "📦 Installing Composer dependencies..."
    cd psa-laravel-app
    composer install --no-dev --optimize-autoloader
    cd ..
fi

# Create environment file
if [ ! -f "psa-laravel-app/.env" ]; then
    echo "⚙️ Creating environment file..."
    cp config/.env.example psa-laravel-app/.env
    cd psa-laravel-app
    php artisan key:generate
    cd ..
fi

# Set permissions
echo "🔐 Setting file permissions..."
chmod -R 755 psa-laravel-app/storage/
chmod -R 755 psa-laravel-app/bootstrap/cache/

# Create symbolic link for storage
if [ ! -L "psa-laravel-app/public/storage" ]; then
    cd psa-laravel-app
    php artisan storage:link
    cd ..
fi

echo "✅ Installation completed!"
echo "🌐 Visit your domain/install to complete the setup wizard"