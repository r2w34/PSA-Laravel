#!/bin/bash

# PSA-NASHIK Search Functionality Fixes Deployment Script
# Run this script on the production server (194.238.23.217)

echo "🔍 Deploying PSA-NASHIK search functionality fixes..."

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
    echo "✅ Frontend backup created: $BACKUP_DIR/public_backup_$TIMESTAMP"
fi

if [ -f "$PROD_DIR/dist/index.js" ]; then
    cp "$PROD_DIR/dist/index.js" "$BACKUP_DIR/index_backup_$TIMESTAMP.js"
    echo "✅ Backend backup created: $BACKUP_DIR/index_backup_$TIMESTAMP.js"
fi

# Deploy frontend fixes
echo "🎨 Deploying frontend search fixes..."
if [ -d "./public" ]; then
    cp -r ./public/* "$PROD_DIR/dist/public/"
    echo "✅ Frontend files with search fixes deployed"
else
    echo "❌ Error: ./public directory not found"
    echo "Please ensure you've uploaded the deployment package correctly"
    exit 1
fi

# Deploy backend fixes
echo "🔧 Deploying backend search fixes..."
if [ -f "./index.js" ]; then
    cp "./index.js" "$PROD_DIR/dist/index.js"
    echo "✅ Backend files with search fixes deployed"
else
    echo "❌ Error: ./index.js file not found"
    echo "Please ensure you've uploaded the deployment package correctly"
    exit 1
fi

# Set proper permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data "$PROD_DIR/dist"
chmod -R 755 "$PROD_DIR/dist"

# Restart the service to apply changes
echo "🔄 Restarting PSA service..."
systemctl restart psa-nashik

# Wait for service to start
sleep 10

# Check service status
if systemctl is-active --quiet psa-nashik; then
    echo "✅ PSA service is running"
    
    # Get service details
    SERVICE_STATUS=$(systemctl status psa-nashik --no-pager -l | head -10)
    echo "Service status: $SERVICE_STATUS"
else
    echo "❌ PSA service failed to start"
    echo "Check logs with: journalctl -u psa-nashik -f"
    echo "Restore frontend backup: cp -r $BACKUP_DIR/public_backup_$TIMESTAMP/* $PROD_DIR/dist/public/"
    echo "Restore backend backup: cp $BACKUP_DIR/index_backup_$TIMESTAMP.js $PROD_DIR/dist/index.js"
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

# Test API endpoints
API_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:5000/api/students || echo "000")
if [ "$API_STATUS" = "200" ]; then
    echo "✅ Students API is responding (HTTP $API_STATUS)"
else
    echo "⚠️  Students API returned HTTP $API_STATUS"
fi

# Test search functionality
SEARCH_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:5000/api/students?search=Test" || echo "000")
if [ "$SEARCH_STATUS" = "200" ]; then
    echo "✅ Student search API is responding (HTTP $SEARCH_STATUS)"
else
    echo "⚠️  Student search API returned HTTP $SEARCH_STATUS"
fi

echo ""
echo "🎉 Search functionality fixes deployment completed!"
echo ""
echo "🔧 FIXES APPLIED:"
echo "✅ Student Search: Fixed database-level search with LIKE queries"
echo "✅ Payment Search: Implemented JOIN-based search for payment records"
echo "✅ Debug Logging: Added comprehensive debug information in frontend"
echo "✅ React Query: Proper search query configuration with enabled conditions"
echo "✅ API Endpoints: Enhanced error handling and response logging"
echo ""
echo "🧪 TESTING STEPS:"
echo "1. Visit http://194.238.23.217/fees"
echo "   - Click on 'Quick Record' tab"
echo "   - Type 'Test' in the search box"
echo "   - Should see debug information and search results"
echo ""
echo "2. Visit http://194.238.23.217/fees?tab=overview"
echo "   - Type in the payment search box"
echo "   - Should see filtered payment records"
echo ""
echo "3. Check browser console for debug logs:"
echo "   - Open Developer Tools (F12)"
echo "   - Look for search-related console messages"
echo ""
echo "🚨 ROLLBACK (if needed):"
echo "Frontend: cp -r $BACKUP_DIR/public_backup_$TIMESTAMP/* $PROD_DIR/dist/public/"
echo "Backend: cp $BACKUP_DIR/index_backup_$TIMESTAMP.js $PROD_DIR/dist/index.js"
echo "systemctl restart psa-nashik"
echo ""
echo "📊 LOGS:"
echo "Service logs: journalctl -u psa-nashik -f"
echo "Nginx logs: tail -f /var/log/nginx/error.log"
echo "Application logs: tail -f $PROD_DIR/logs/*.log"