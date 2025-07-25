#!/bin/bash

# PSA Nashik - VPS Deployment Script
# Deploys the fixed application to VPS server 45.194.46.109

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
VPS_IP="45.194.46.109"
VPS_USER="root"
APP_PATH="/var/www/psa-nashik"
BACKUP_PATH="/tmp/psa-backup-$(date +%Y%m%d-%H%M%S)"

echo
print_status "🚀 Starting PSA Nashik VPS Deployment..."
print_status "Target Server: $VPS_IP"
print_status "Application Path: $APP_PATH"
echo

# Check if we have the deployment package
if [ ! -f "psa-nashik-complete-deployment.tar.gz" ]; then
    print_error "Deployment package not found. Creating it now..."
    
    # Build the application
    print_status "Building application..."
    npm run build
    
    # Create deployment package
    print_status "Creating deployment package..."
    tar --exclude=node_modules --exclude=.git --exclude=client/node_modules --exclude=server.log --exclude=dev.log -czf psa-nashik-complete-deployment.tar.gz \
      dist/ \
      package.json \
      package-lock.json \
      .env.production \
      docker-compose.yml \
      Dockerfile \
      nginx.conf \
      DEPLOYMENT_GUIDE.md \
      deploy-docker.sh \
      start-production.sh \
      drizzle.config.ts \
      shared/
    
    print_success "Deployment package created!"
fi

# Upload deployment package to VPS
print_status "Uploading deployment package to VPS..."
scp psa-nashik-complete-deployment.tar.gz $VPS_USER@$VPS_IP:/tmp/

# Deploy on VPS
print_status "Deploying on VPS server..."
ssh $VPS_USER@$VPS_IP << 'ENDSSH'
set -e

# Colors for remote output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_status() { echo -e "${BLUE}[REMOTE]${NC} $1"; }
print_success() { echo -e "${GREEN}[REMOTE]${NC} $1"; }
print_error() { echo -e "${RED}[REMOTE]${NC} $1"; }

APP_PATH="/var/www/psa-nashik"
BACKUP_PATH="/tmp/psa-backup-$(date +%Y%m%d-%H%M%S)"

print_status "Starting deployment on VPS..."

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
sleep 2

# Create application directory
mkdir -p $APP_PATH
cd $APP_PATH

# Extract new deployment
print_status "Extracting new deployment..."
tar -xzf /tmp/psa-nashik-complete-deployment.tar.gz

# Install dependencies if needed
if [ ! -d "node_modules" ]; then
    print_status "Installing dependencies..."
    npm install --production
fi

# Set up environment
if [ ! -f ".env" ]; then
    print_status "Setting up environment configuration..."
    cp .env.production .env
    
    # Update environment with production values
    sed -i 's/your_secure_db_password/psa_production_2024/g' .env
    sed -i 's/your_very_secure_session_secret_change_this/psa_session_$(openssl rand -hex 32)/g' .env
    
    print_success "Environment configured"
fi

# Set permissions
chown -R www-data:www-data $APP_PATH 2>/dev/null || true
chmod +x start-production.sh

# Start the application
print_status "Starting PSA Nashik application..."
cd dist

# Start with nohup
nohup node index.js > /var/log/psa-nashik.log 2>&1 &
PID=$!
echo $PID > /var/run/psa-nashik.pid

# Wait and check if application started
sleep 5

if kill -0 $PID 2>/dev/null; then
    print_success "✅ PSA Nashik deployed and running successfully!"
    print_success "📱 Application URL: http://45.194.46.109"
    print_success "🔍 Process ID: $PID"
    print_success "📋 Logs: tail -f /var/log/psa-nashik.log"
else
    print_error "❌ Failed to start application. Check logs:"
    tail -20 /var/log/psa-nashik.log
    exit 1
fi

# Clean up
rm -f /tmp/psa-nashik-complete-deployment.tar.gz

print_success "🎉 Deployment completed successfully!"
ENDSSH

if [ $? -eq 0 ]; then
    echo
    print_success "🎊 PSA Nashik has been successfully deployed to VPS!"
    print_success "🌐 Application URL: http://45.194.46.109"
    print_success "📊 Admin Panel: http://45.194.46.109/admin"
    print_success "📱 Students Page: http://45.194.46.109/students"
    print_success "💰 Fees Section: http://45.194.46.109/fees"
    
    echo
    print_status "🔧 Management Commands:"
    echo "  View logs: ssh $VPS_USER@$VPS_IP 'tail -f /var/log/psa-nashik.log'"
    echo "  Restart app: ssh $VPS_USER@$VPS_IP 'pkill -f node && cd /var/www/psa-nashik/dist && nohup node index.js > /var/log/psa-nashik.log 2>&1 &'"
    echo "  Check status: ssh $VPS_USER@$VPS_IP 'ps aux | grep node'"
    
    echo
    print_status "🎯 Next Steps:"
    echo "1. Test all features on http://45.194.46.109"
    echo "2. Configure domain name and SSL if needed"
    echo "3. Set up database backups"
    echo "4. Configure monitoring and alerts"
    
    echo
    print_success "✨ Your PSA Nashik Sports Academy is now live and ready to use!"
else
    print_error "❌ Deployment failed. Check the error messages above."
    exit 1
fi
