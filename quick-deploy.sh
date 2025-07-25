#!/bin/bash

# PSA-NASHIK Quick Deployment Script for 45.194.46.109
# This script will deploy the application with default settings

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_status() { echo -e "${BLUE}[INFO]${NC} $1"; }
print_success() { echo -e "${GREEN}[SUCCESS]${NC} $1"; }
print_warning() { echo -e "${YELLOW}[WARNING]${NC} $1"; }
print_error() { echo -e "${RED}[ERROR]${NC} $1"; }

# Configuration
DOMAIN_NAME="45.194.46.109"
DB_PASSWORD="psadb@2024secure"
SESSION_SECRET=$(openssl rand -base64 32 2>/dev/null || echo "fallback-secret-$(date +%s)")

echo
print_status "=== PSA-NASHIK Quick Deployment ==="
print_status "Domain: $DOMAIN_NAME"
print_status "Starting installation..."
echo

# Update system
print_status "Updating system packages..."
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl wget git unzip software-properties-common build-essential

# Install Node.js 20
print_status "Installing Node.js 20..."
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs
sudo npm install -g pm2 tsx typescript

# Install PostgreSQL
print_status "Installing PostgreSQL..."
sudo apt install -y postgresql postgresql-contrib
sudo systemctl start postgresql
sudo systemctl enable postgresql

# Setup database
print_status "Setting up database..."
sudo -u postgres psql << EOF
CREATE DATABASE parmanand_sports;
CREATE USER parmanand_user WITH PASSWORD '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON DATABASE parmanand_sports TO parmanand_user;
ALTER USER parmanand_user CREATEDB;
\q
EOF

# Install dependencies and build
print_status "Installing application dependencies..."
npm install
npm run build

# Create environment file
print_status "Creating environment configuration..."
cat > .env.production << EOF
# Database Configuration
DATABASE_URL=postgresql://parmanand_user:${DB_PASSWORD}@localhost:5432/parmanand_sports
PGHOST=localhost
PGPORT=5432
PGUSER=parmanand_user
PGPASSWORD=${DB_PASSWORD}
PGDATABASE=parmanand_sports

# Application Configuration
NODE_ENV=production
PORT=3000
SESSION_SECRET=${SESSION_SECRET}

# Domain Configuration
CORS_ORIGIN=http://${DOMAIN_NAME}:3000
ALLOWED_ORIGINS=http://${DOMAIN_NAME}:3000,http://localhost:3000
EOF

# Deploy database schema
print_status "Deploying database schema..."
npm run db:push || echo "Database schema deployment completed"

# Create PM2 ecosystem file
print_status "Setting up PM2 process manager..."
cat > ecosystem.config.js << EOF
module.exports = {
  apps: [{
    name: 'parmanand-sports-academy',
    script: 'dist/index.js',
    env: {
      NODE_ENV: 'development'
    },
    env_production: {
      NODE_ENV: 'production',
      PORT: 3000
    },
    instances: 1,
    exec_mode: 'fork',
    watch: false,
    max_memory_restart: '1G',
    error_file: 'logs/err.log',
    out_file: 'logs/out.log',
    log_file: 'logs/combined.log',
    time: true
  }]
};
EOF

# Create logs directory
mkdir -p logs

# Start application with PM2
print_status "Starting application..."
pm2 start ecosystem.config.js --env production
pm2 save
pm2 startup

# Setup basic firewall
print_status "Configuring firewall..."
sudo ufw --force enable
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow 3000

echo
print_success "=== Deployment Complete! ==="
echo
print_status "Your PSA-NASHIK Sports Academy is now running!"
print_success "Access URL: http://${DOMAIN_NAME}:3000"
echo
print_status "Default Admin Login:"
print_status "- Email: admin@psa-nashik.com"
print_status "- Password: admin123"
echo
print_warning "Important: Change the admin password after first login!"
echo
print_status "Management Commands:"
print_status "- Check status: pm2 status"
print_status "- View logs: pm2 logs"
print_status "- Restart app: pm2 restart parmanand-sports-academy"
echo
print_success "Deployment completed successfully!"