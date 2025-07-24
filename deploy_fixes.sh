#!/bin/bash

# PSA-NASHIK Deployment Script for Data Sync & Logo Fixes
# Run this script on the production server (194.238.23.217)

echo "🚀 Deploying PSA-NASHIK fixes for data synchronization and logo issues..."

# Set variables
PROD_DIR="/var/www/psa-nashik"
BACKUP_DIR="/var/www/psa-nashik/backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

# Create backup directory if it doesn't exist
mkdir -p "$BACKUP_DIR"

# Backup current files
echo "📦 Creating backup..."
if [ -d "$PROD_DIR/dist/public" ]; then
    cp -r "$PROD_DIR/dist/public" "$BACKUP_DIR/public_backup_$TIMESTAMP"
    echo "✅ Backup created: $BACKUP_DIR/public_backup_$TIMESTAMP"
else
    echo "⚠️  No existing public directory found"
fi

# Copy new files (assuming deployment package is in current directory)
echo "📁 Deploying fixed files..."
if [ -d "./public" ]; then
    # Copy the new built files with fixes
    cp -r ./public/* "$PROD_DIR/dist/public/"
    echo "✅ Fixed frontend files deployed"
    
    # Verify logo file exists
    if [ -f "$PROD_DIR/dist/public/assets/psa-logo-"*.png ]; then
        echo "✅ Logo file deployed successfully"
    else
        echo "⚠️  Logo file not found in deployment"
    fi
else
    echo "❌ Error: ./public directory not found"
    echo "Please ensure you've uploaded the deployment package with:"
    echo "  - public/index.html"
    echo "  - public/assets/psa-logo-CLas-00W.png"
    echo "  - public/assets/index-CAV9p-Wn.js"
    echo "  - public/assets/index-D7E52AxT.css"
    exit 1
fi

# Set proper permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data "$PROD_DIR/dist/public"
chmod -R 755 "$PROD_DIR/dist/public"

# Restart the service to apply changes
echo "🔄 Restarting PSA service..."
systemctl restart psa-nashik

# Wait for service to start
sleep 5

# Check service status
if systemctl is-active --quiet psa-nashik; then
    echo "✅ PSA service is running"
    
    # Get service details
    SERVICE_STATUS=$(systemctl status psa-nashik --no-pager -l | head -10)
    echo "Service status: $SERVICE_STATUS"
else
    echo "❌ PSA service failed to start"
    echo "Check logs with: journalctl -u psa-nashik -f"
    echo "Restore backup with: cp -r $BACKUP_DIR/public_backup_$TIMESTAMP/* $PROD_DIR/dist/public/"
    exit 1
fi

# Verify deployment
echo "🔍 Verifying deployment..."

# Test if the application is responding
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:5000 || echo "000")
if [ "$HTTP_STATUS" = "200" ]; then
    echo "✅ Application is responding (HTTP $HTTP_STATUS)"
else
    echo "⚠️  Application returned HTTP $HTTP_STATUS"
fi

# Test API endpoint
API_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:5000/api/students || echo "000")
if [ "$API_STATUS" = "200" ]; then
    echo "✅ Students API is responding (HTTP $API_STATUS)"
else
    echo "⚠️  Students API returned HTTP $API_STATUS"
fi

echo ""
echo "🎉 Deployment completed!"
echo ""
echo "🔧 FIXES APPLIED:"
echo "✅ Data Synchronization: React Query cache fixed (staleTime: 0)"
echo "✅ Logo Display: Proper Vite asset import implemented"
echo "✅ Manual Refresh: Added refresh button for cache invalidation"
echo "✅ Auto Refresh: Enabled refetch on window focus"
echo ""
echo "🧪 TESTING STEPS:"
echo "1. Visit http://194.238.23.217"
echo "   - Logo should display correctly (no broken image)"
echo ""
echo "2. Visit http://194.238.23.217/students"
echo "   - Should show real database data:"
echo "     • Rahul Sharma (PSA001)"
echo "     • Priya Patel (PSA002)"
echo "     • Amit Kumar (PSA003)"
echo "   - Click 'Refresh' button to test cache invalidation"
echo ""
echo "3. Clear browser cache (Ctrl+F5) if needed"
echo ""
echo "🚨 ROLLBACK (if needed):"
echo "cp -r $BACKUP_DIR/public_backup_$TIMESTAMP/* $PROD_DIR/dist/public/"
echo "systemctl restart psa-nashik"
echo ""
echo "📊 LOGS:"
echo "Service logs: journalctl -u psa-nashik -f"
echo "Nginx logs: tail -f /var/log/nginx/error.log"