#!/bin/bash

# PSA Sports Academy - Shared Hosting Package Creator
# This script creates a production-ready package for shared hosting deployment

echo "🚀 Creating PSA Sports Academy Shared Hosting Package..."

# Set variables
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(dirname "$SCRIPT_DIR")"
LARAVEL_APP="$PROJECT_ROOT/laravel-app"
PACKAGE_DIR="$SCRIPT_DIR/shared-hosting"
TEMP_DIR="$PACKAGE_DIR/temp"

# Create package directory structure
echo "📁 Creating package structure..."
mkdir -p "$PACKAGE_DIR"
mkdir -p "$TEMP_DIR/psa-laravel-app"
mkdir -p "$TEMP_DIR/whatsapp-bot"
mkdir -p "$TEMP_DIR/database"
mkdir -p "$TEMP_DIR/config"

# Copy Laravel application (excluding unnecessary files)
echo "📦 Copying Laravel application..."
cd "$LARAVEL_APP"

# Copy all Laravel files except development files
rsync -av --progress \
    --exclude='node_modules' \
    --exclude='.git' \
    --exclude='.env' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='tests' \
    --exclude='.phpunit.result.cache' \
    --exclude='vite.config.js' \
    --exclude='package.json' \
    --exclude='package-lock.json' \
    . "$TEMP_DIR/psa-laravel-app/"

# Copy WhatsApp bot
echo "🤖 Copying WhatsApp bot..."
cp -r "$PROJECT_ROOT/whatsapp-bot" "$TEMP_DIR/"

# Create database export
echo "🗄️ Creating database structure..."
cd "$LARAVEL_APP"
php artisan schema:dump --database=sqlite --path="$TEMP_DIR/database/structure.sql"

# Create sample data export
echo "📊 Creating sample data..."
cat > "$TEMP_DIR/database/sample-data.sql" << 'EOF'
-- Sample data for PSA Sports Academy
-- Insert sample sports
INSERT INTO sports (name, description, is_active, created_at, updated_at) VALUES
('Cricket', 'Cricket training and coaching', 1, NOW(), NOW()),
('Football', 'Football training and coaching', 1, NOW(), NOW()),
('Basketball', 'Basketball training and coaching', 1, NOW(), NOW());

-- Insert sample batches
INSERT INTO batches (name, sport_id, coach_id, start_time, end_time, days_of_week, max_students, skill_level, fee_amount, is_active, created_at, updated_at) VALUES
('Cricket Beginners', 1, 1, '06:00:00', '07:30:00', 'Monday,Wednesday,Friday', 20, 'beginner', 2000.00, 1, NOW(), NOW()),
('Football Intermediate', 2, 2, '07:30:00', '09:00:00', 'Tuesday,Thursday,Saturday', 15, 'intermediate', 2500.00, 1, NOW(), NOW()),
('Basketball Advanced', 3, 3, '09:00:00', '10:30:00', 'Monday,Wednesday,Friday', 12, 'advanced', 3000.00, 1, NOW(), NOW());

-- Insert sample coaches
INSERT INTO coaches (name, email, phone, specialization, experience_years, qualification, salary, status, created_at, updated_at) VALUES
('John Smith', 'john@psa.com', '9876543210', 'Cricket', 5, 'B.P.Ed', 25000.00, 'active', NOW(), NOW()),
('Mike Johnson', 'mike@psa.com', '9876543211', 'Football', 7, 'M.P.Ed', 30000.00, 'active', NOW(), NOW()),
('Sarah Wilson', 'sarah@psa.com', '9876543212', 'Basketball', 4, 'B.P.Ed', 22000.00, 'active', NOW(), NOW());
EOF

# Create configuration files
echo "⚙️ Creating configuration files..."

# Create .env.example
cat > "$TEMP_DIR/config/.env.example" << 'EOF'
APP_NAME="PSA Sports Academy"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=Asia/Kolkata
APP_URL=https://yourdomain.com

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="PSA Sports Academy"

# Razorpay Configuration
RAZORPAY_KEY_ID=your_razorpay_key_id
RAZORPAY_KEY_SECRET=your_razorpay_key_secret

# WhatsApp Bot Configuration
WHATSAPP_BOT_URL=http://localhost:3001
WHATSAPP_ENABLED=true
FEE_REMINDER_ENABLED=true
ATTENDANCE_NOTIFICATION_ENABLED=true
SESSION_NOTIFICATION_ENABLED=true
EOF

# Create .htaccess for Apache
cat > "$TEMP_DIR/config/htaccess.txt" << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOF

# Create nginx configuration
cat > "$TEMP_DIR/config/nginx.conf" << 'EOF'
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /path/to/your/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# Create installation script
cat > "$TEMP_DIR/install.sh" << 'EOF'
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
if [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# Generate application key
if [ ! -f ".env" ]; then
    echo "⚙️ Creating environment file..."
    cp config/.env.example .env
    php artisan key:generate
fi

# Set permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Create symbolic link for storage
if [ ! -L "public/storage" ]; then
    php artisan storage:link
fi

echo "✅ Installation completed!"
echo "🌐 Visit your domain/install to complete the setup wizard"
EOF

chmod +x "$TEMP_DIR/install.sh"

# Create ZIP package
echo "📦 Creating ZIP package..."
cd "$TEMP_DIR"
zip -r "../psa-sports-academy-shared-hosting.zip" . -x "*.DS_Store" "*.git*"

# Clean up temp directory
rm -rf "$TEMP_DIR"

echo "✅ Package created successfully!"
echo "📁 Location: $PACKAGE_DIR/psa-sports-academy-shared-hosting.zip"
echo "📖 Documentation: $PACKAGE_DIR/README.md"
echo ""
echo "🎉 Ready for shared hosting deployment!"
EOF