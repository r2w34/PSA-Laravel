#!/bin/bash

# PSA-NASHIK Production Deployment Script
# Complete deployment with authentication system

set -e

echo "🚀 PSA-NASHIK Production Deployment Starting..."
echo "📅 $(date)"
echo ""

# Configuration
APP_DIR="/var/www/PSA-NASHIK"
SERVICE_NAME="psa-nashik"
DB_NAME="psa_nashik"
DB_USER="psa_user"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

log() {
    echo -e "${BLUE}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

success() {
    echo -e "${GREEN}✅ $1${NC}"
}

warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

error() {
    echo -e "${RED}❌ $1${NC}"
}

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    error "Please run this script as root (use sudo)"
    exit 1
fi

# Create application directory
log "Creating application directory..."
mkdir -p "$APP_DIR"
cd "$APP_DIR"

# Install system dependencies
log "Installing system dependencies..."
apt update
apt install -y nodejs npm postgresql postgresql-contrib nginx git curl

# Install Node.js 18+ if needed
NODE_VERSION=$(node --version | cut -d'v' -f2 | cut -d'.' -f1)
if [ "$NODE_VERSION" -lt 18 ]; then
    log "Installing Node.js 18..."
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
    apt-get install -y nodejs
fi

# Clone or update repository
if [ -d ".git" ]; then
    log "Updating existing repository..."
    git pull origin main
else
    log "Cloning repository..."
    git clone https://github.com/r2w34/PSA-NASHIK.git .
fi

# Install application dependencies
log "Installing application dependencies..."
npm install

# Build application
log "Building application..."
npm run build

# Setup PostgreSQL database
log "Setting up PostgreSQL database..."
sudo -u postgres psql << EOF
-- Create database and user if they don't exist
SELECT 'CREATE DATABASE $DB_NAME' WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = '$DB_NAME')\gexec
DO \$\$
BEGIN
    IF NOT EXISTS (SELECT FROM pg_catalog.pg_roles WHERE rolname = '$DB_USER') THEN
        CREATE USER $DB_USER WITH PASSWORD 'secure_password_change_me';
    END IF;
END
\$\$;
GRANT ALL PRIVILEGES ON DATABASE $DB_NAME TO $DB_USER;
ALTER USER $DB_USER CREATEDB;
EOF

# Create environment file
log "Creating environment configuration..."
cat > .env << EOF
# Database Configuration
DATABASE_URL=postgresql://$DB_USER:secure_password_change_me@localhost:5432/$DB_NAME

# Application Configuration
NODE_ENV=production
PORT=5000
HTTPS=false

# Session Configuration
SESSION_SECRET=$(openssl rand -base64 32)

# WhatsApp Configuration (configure these with your credentials)
WHATSAPP_API_URL=https://api.whatsapp.com
WHATSAPP_TOKEN=your_whatsapp_token_here

# Email Configuration (configure these with your SMTP settings)
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your_email@gmail.com
SMTP_PASS=your_app_password

# Application URLs
FRONTEND_URL=http://your-domain.com
API_URL=http://your-domain.com/api
EOF

# Run database migrations
log "Running database migrations..."
npm run db:push

# Create admin user
log "Creating admin user..."
node -e "
const bcrypt = require('bcrypt');
const { Client } = require('pg');

async function createAdmin() {
  const client = new Client({
    connectionString: process.env.DATABASE_URL || 'postgresql://$DB_USER:secure_password_change_me@localhost:5432/$DB_NAME'
  });
  
  try {
    await client.connect();
    const hashedPassword = await bcrypt.hash('admin123', 10);
    
    await client.query(\`
      INSERT INTO users (email, password, name, role, phone, created_at, updated_at)
      VALUES (\$1, \$2, \$3, \$4, \$5, NOW(), NOW())
      ON CONFLICT (email) DO UPDATE SET
        password = \$2,
        updated_at = NOW()
    \`, ['admin@psa-nashik.com', hashedPassword, 'Admin User', 'admin', '+919999999999']);
    
    console.log('Admin user created/updated successfully');
  } catch (error) {
    console.error('Error creating admin user:', error);
  } finally {
    await client.end();
  }
}

createAdmin();
"

# Create systemd service
log "Creating systemd service..."
cat > /etc/systemd/system/$SERVICE_NAME.service << EOF
[Unit]
Description=PSA Nashik Sports Academy Management System
After=network.target postgresql.service

[Service]
Type=simple
User=www-data
WorkingDirectory=$APP_DIR
Environment=NODE_ENV=production
EnvironmentFile=$APP_DIR/.env
ExecStart=/usr/bin/node dist/index.js
Restart=always
RestartSec=10
StandardOutput=syslog
StandardError=syslog
SyslogIdentifier=$SERVICE_NAME

[Install]
WantedBy=multi-user.target
EOF

# Configure nginx
log "Configuring nginx..."
cat > /etc/nginx/sites-available/$SERVICE_NAME << EOF
server {
    listen 80;
    server_name _;
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_proxied expired no-cache no-store private must-revalidate auth;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/javascript;

    # API routes
    location /api {
        proxy_pass http://localhost:5000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade \$http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_cache_bypass \$http_upgrade;
        proxy_read_timeout 86400;
    }

    # WebSocket support
    location /ws {
        proxy_pass http://localhost:5000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade \$http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }

    # Static files
    location / {
        proxy_pass http://localhost:5000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade \$http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_cache_bypass \$http_upgrade;
    }

    # Security
    location ~ /\. {
        deny all;
    }
}
EOF

# Enable nginx site
ln -sf /etc/nginx/sites-available/$SERVICE_NAME /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test nginx configuration
nginx -t

# Set proper permissions
chown -R www-data:www-data "$APP_DIR"
chmod -R 755 "$APP_DIR"

# Enable and start services
log "Starting services..."
systemctl daemon-reload
systemctl enable postgresql
systemctl enable nginx
systemctl enable $SERVICE_NAME

systemctl start postgresql
systemctl start nginx
systemctl start $SERVICE_NAME

# Wait for services to start
sleep 5

# Test the deployment
log "Testing deployment..."

# Test database connection
if sudo -u postgres psql -d $DB_NAME -c "SELECT 1;" > /dev/null 2>&1; then
    success "Database connection successful"
else
    error "Database connection failed"
fi

# Test application health
if curl -f http://localhost:5000/api/health > /dev/null 2>&1; then
    success "Application health check passed"
else
    warning "Application health check failed - checking logs..."
    systemctl status $SERVICE_NAME --no-pager
fi

# Test authentication
AUTH_RESULT=$(curl -s -X POST http://localhost:5000/api/auth/login \
    -H "Content-Type: application/json" \
    -d '{"email":"admin@psa-nashik.com","password":"admin123"}' || echo "failed")

if echo "$AUTH_RESULT" | grep -q "success"; then
    success "Authentication system working"
else
    warning "Authentication test failed: $AUTH_RESULT"
fi

# Test nginx
if curl -f http://localhost/ > /dev/null 2>&1; then
    success "Nginx proxy working"
else
    warning "Nginx proxy test failed"
fi

echo ""
echo "🎉 PSA-NASHIK Deployment Summary:"
echo "   ✅ System dependencies installed"
echo "   ✅ Application built and configured"
echo "   ✅ PostgreSQL database setup"
echo "   ✅ Admin user created"
echo "   ✅ Systemd service configured"
echo "   ✅ Nginx reverse proxy configured"
echo "   ✅ Services started and enabled"
echo ""
echo "🌐 Access Information:"
echo "   - Application: http://your-server-ip"
echo "   - API: http://your-server-ip/api"
echo "   - Health Check: http://your-server-ip/api/health"
echo ""
echo "🔐 Admin Credentials:"
echo "   - Email: admin@psa-nashik.com"
echo "   - Password: admin123"
echo ""
echo "📋 Next Steps:"
echo "   1. Update the domain name in nginx configuration"
echo "   2. Configure SSL certificate (recommended)"
echo "   3. Update WhatsApp and email credentials in .env"
echo "   4. Change default admin password"
echo "   5. Configure firewall rules"
echo ""
echo "🔧 Useful Commands:"
echo "   - Check service status: systemctl status $SERVICE_NAME"
echo "   - View logs: journalctl -u $SERVICE_NAME -f"
echo "   - Restart service: systemctl restart $SERVICE_NAME"
echo "   - Update application: cd $APP_DIR && git pull && npm run build && systemctl restart $SERVICE_NAME"
echo ""

if echo "$AUTH_RESULT" | grep -q "success"; then
    success "🎊 PSA-NASHIK is successfully deployed and running!"
else
    warning "⚠️  Deployment completed but authentication needs verification"
    echo "Check logs: journalctl -u $SERVICE_NAME -f"
fi

echo ""
echo "🏁 Deployment completed at $(date)"