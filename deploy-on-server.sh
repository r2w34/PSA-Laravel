#!/bin/bash

# PSA Nashik - Server Deployment Script
# Run this script directly on your VPS server (45.194.46.109)

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
APP_PATH="/var/www/psa-nashik"
BACKUP_PATH="/tmp/psa-backup-$(date +%Y%m%d-%H%M%S)"
DEPLOYMENT_PACKAGE="psa-nashik-complete-deployment.tar.gz"

echo
print_status "🚀 PSA Nashik Server Deployment Script"
print_status "This script will deploy the PSA Nashik application on this server"
echo

# Check if deployment package exists
if [ ! -f "$DEPLOYMENT_PACKAGE" ]; then
    print_error "Deployment package '$DEPLOYMENT_PACKAGE' not found!"
    print_status "Please upload the deployment package to this directory first:"
    print_status "1. Download: psa-nashik-complete-deployment.tar.gz"
    print_status "2. Upload to server: scp psa-nashik-complete-deployment.tar.gz root@45.194.46.109:/root/"
    print_status "3. Run this script: ./deploy-on-server.sh"
    exit 1
fi

# Create backup of current deployment
if [ -d "$APP_PATH" ]; then
    print_status "Creating backup of current deployment..."
    mkdir -p $BACKUP_PATH
    cp -r $APP_PATH/* $BACKUP_PATH/ 2>/dev/null || true
    print_success "Backup created at $BACKUP_PATH"
fi

# Stop existing application
print_status "Stopping existing application..."
pkill -f "node.*psa-nashik" || true
pkill -f "node.*index.js" || true
sleep 3

# Create application directory
print_status "Setting up application directory..."
mkdir -p $APP_PATH
cd $APP_PATH

# Extract new deployment
print_status "Extracting deployment package..."
tar -xzf ~/$DEPLOYMENT_PACKAGE

# Install dependencies if needed
if [ ! -d "node_modules" ]; then
    print_status "Installing Node.js dependencies..."
    npm install --production --silent
fi

# Set up environment
if [ ! -f ".env" ]; then
    print_status "Setting up environment configuration..."
    cp .env.production .env
    
    # Generate secure values
    DB_PASS="psa_$(openssl rand -hex 16)"
    SESSION_SECRET="psa_session_$(openssl rand -hex 32)"
    
    # Update environment with production values
    sed -i "s/your_secure_db_password/$DB_PASS/g" .env
    sed -i "s/your_very_secure_session_secret_change_this/$SESSION_SECRET/g" .env
    
    print_success "Environment configured with secure defaults"
    print_warning "Database password: $DB_PASS"
    print_warning "Please save these credentials securely!"
fi

# Set permissions
print_status "Setting file permissions..."
chown -R www-data:www-data $APP_PATH 2>/dev/null || true
chmod +x start-production.sh

# Start the application
print_status "Starting PSA Nashik application..."
cd dist

# Start with nohup
nohup node index.js > /var/log/psa-nashik.log 2>&1 &
PID=$!
echo $PID > /var/run/psa-nashik.pid

print_status "Application started with PID: $PID"

# Wait and check if application started
print_status "Checking application status..."
sleep 5

if kill -0 $PID 2>/dev/null; then
    print_success "✅ PSA Nashik deployed and running successfully!"
    
    # Test the application
    if curl -s http://localhost:5000/api/health > /dev/null; then
        print_success "🌐 Application is responding to HTTP requests"
    else
        print_warning "⚠️  Application may still be starting up"
    fi
    
    echo
    print_success "🎉 Deployment completed successfully!"
    print_success "📱 Application URL: http://45.194.46.109"
    print_success "🔍 Process ID: $PID"
    print_success "📋 Logs: tail -f /var/log/psa-nashik.log"
    
    echo
    print_status "🔧 Management Commands:"
    echo "  View logs: tail -f /var/log/psa-nashik.log"
    echo "  Stop app: kill \$(cat /var/run/psa-nashik.pid)"
    echo "  Restart: pkill -f node && cd $APP_PATH/dist && nohup node index.js > /var/log/psa-nashik.log 2>&1 &"
    echo "  Check status: ps aux | grep node"
    
    echo
    print_status "🎯 Next Steps:"
    echo "1. Test the application: http://45.194.46.109"
    echo "2. Configure your database connection in .env"
    echo "3. Set up SSL certificates for HTTPS"
    echo "4. Configure domain name if needed"
    echo "5. Set up automated backups"
    
else
    print_error "❌ Failed to start application!"
    print_error "Check the logs for details:"
    tail -20 /var/log/psa-nashik.log
    exit 1
fi

# Clean up
rm -f ~/$DEPLOYMENT_PACKAGE

echo
print_success "✨ PSA Nashik Sports Academy is now live and ready to use!"
print_success "🌐 Visit: http://45.194.46.109"