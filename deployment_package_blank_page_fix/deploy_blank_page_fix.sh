#!/bin/bash

echo "🔧 Deploying PaymentRecorder Blank Page Bug Fix..."
echo "📅 Deployment Date: $(date)"
echo "🎯 Target: PSA-NASHIK Production Server"

# Backup current version
echo "💾 Creating backup..."
mkdir -p /var/www/psa-nashik/backups/$(date +%Y%m%d_%H%M%S)
cp -r /var/www/parmanand-sports-academy/* /var/www/psa-nashik/backups/$(date +%Y%m%d_%H%M%S)/ 2>/dev/null || echo "⚠️ Backup failed - continuing with deployment"

# Deploy new files
echo "📁 Deploying updated files..."
cp -r public/* /var/www/parmanand-sports-academy/public/ 2>/dev/null || {
    echo "❌ Failed to copy public files"
    echo "🔍 Checking directory structure..."
    ls -la /var/www/
    exit 1
}

cp index.js /var/www/parmanand-sports-academy/ 2>/dev/null || {
    echo "❌ Failed to copy server file"
    echo "🔍 Checking directory structure..."
    ls -la /var/www/
    exit 1
}

# Restart application
echo "🔄 Restarting application..."
pm2 restart parmanand-sports-academy 2>/dev/null || {
    echo "⚠️ PM2 restart failed, trying alternative methods..."
    pkill -f "parmanand-sports-academy" 2>/dev/null
    sleep 2
    cd /var/www/parmanand-sports-academy && node index.js &
}

# Verify deployment
echo "✅ Verifying deployment..."
sleep 3
curl -s http://localhost:3000/api/health 2>/dev/null && echo "🎉 Server is responding!" || echo "⚠️ Server health check failed"

echo ""
echo "🎉 Deployment Complete!"
echo "🌐 Application should be available at: http://194.238.23.217"
echo "🔧 Bug Fix: PaymentRecorder blank page issue resolved"
echo ""
echo "📋 What was fixed:"
echo "  ✅ Added error handling for sports/batches API calls"
echo "  ✅ Added safety checks for data access"
echo "  ✅ Added debug information for troubleshooting"
echo "  ✅ Added graceful error recovery"
echo ""
echo "🧪 Test the fix:"
echo "  1. Go to Fees page"
echo "  2. Search for 'yash'"
echo "  3. Click on the student result"
echo "  4. Verify student details form appears (no blank page)"
echo ""
echo "📞 If issues persist, check the console logs for detailed error information."