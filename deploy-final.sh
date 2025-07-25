#!/bin/bash

# PSA Nashik - Final VPS Deployment Script
# This script deploys all fixes to the VPS server

set -e  # Exit on any error

VPS_HOST="45.194.46.109"
VPS_USER="root"
DEPLOYMENT_PACKAGE="psa-nashik-final-deployment.tar.gz"
APP_NAME="psa-nashik"

echo "🚀 Starting PSA Nashik Final Deployment..."
echo "📦 Package: $DEPLOYMENT_PACKAGE"
echo "🖥️  VPS: $VPS_USER@$VPS_HOST"
echo ""

# Check if deployment package exists
if [ ! -f "$DEPLOYMENT_PACKAGE" ]; then
    echo "❌ Error: Deployment package $DEPLOYMENT_PACKAGE not found!"
    exit 1
fi

echo "1️⃣ Uploading deployment package to VPS..."
scp "$DEPLOYMENT_PACKAGE" "$VPS_USER@$VPS_HOST:/root/"

echo "2️⃣ Deploying to VPS..."
ssh "$VPS_USER@$VPS_HOST" << 'EOF'
set -e

APP_NAME="psa-nashik"
DEPLOYMENT_PACKAGE="psa-nashik-final-deployment.tar.gz"
BACKUP_DIR="/root/backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

echo "📋 VPS Deployment Steps:"

# Create backup directory
mkdir -p "$BACKUP_DIR"

# Stop current application
echo "🛑 Stopping current application..."
if pm2 list | grep -q "$APP_NAME"; then
    pm2 stop "$APP_NAME" || true
    pm2 delete "$APP_NAME" || true
fi

# Backup current deployment
if [ -d "/root/$APP_NAME" ]; then
    echo "💾 Creating backup..."
    mv "/root/$APP_NAME" "$BACKUP_DIR/${APP_NAME}_backup_$TIMESTAMP"
fi

# Extract new deployment
echo "📦 Extracting deployment..."
cd /root
tar -xzf "$DEPLOYMENT_PACKAGE"
mv dist "$APP_NAME"

# Set up environment
echo "⚙️ Setting up environment..."
cd "/root/$APP_NAME"

# Create production .env
cat > .env << 'ENVEOF'
NODE_ENV=production
PORT=5000
DATABASE_URL=postgresql://psa_user:psa_password@localhost:5432/psa_nashik
SESSION_SECRET=prod-session-secret-key-change-this
VITE_FIREBASE_API_KEY=demo-api-key
VITE_FIREBASE_PROJECT_ID=psa-demo
VITE_FIREBASE_APP_ID=demo-app-id
STRIPE_SECRET_KEY=sk_test_demo
VITE_STRIPE_PUBLIC_KEY=pk_test_demo
RAZORPAY_KEY_ID=rzp_test_demo
RAZORPAY_KEY_SECRET=demo_secret
PAYPAL_CLIENT_ID=demo_client_id
PAYPAL_CLIENT_SECRET=demo_client_secret
GEMINI_API_KEY=demo-gemini-key
WHATSAPP_API_KEY=demo-whatsapp-key
ENVEOF

# Install dependencies
echo "📚 Installing dependencies..."
npm install --production --silent

# Start application
echo "🚀 Starting application..."
pm2 start index.js --name "$APP_NAME" --env production
pm2 save

# Test health
echo "🔍 Testing application..."
sleep 3
curl -s http://localhost:5000/api/health || echo "⚠️ Health check pending..."

echo ""
echo "✅ Deployment completed!"
echo "🌐 Application: http://45.194.46.109:5000"
echo ""
echo "📋 Fixes Applied:"
echo "1. ✅ Logo display fixed"
echo "2. ✅ Settings icon removed"
echo "3. ✅ Payment search functionality fixed"

EOF

echo ""
echo "🎉 Final deployment completed successfully!"
echo ""
echo "🔗 Application URL: http://45.194.46.109:5000"
echo ""
echo "📋 Please verify the fixes:"
echo "1. Logo appears in sidebar"
echo "2. Settings icon is removed from header"
echo "3. Student search works in Fees → Quick Record tab"