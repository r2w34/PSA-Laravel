#!/bin/bash

echo "🔧 Deploying PaymentRecorder blank page bug fix..."

# Copy the fixed files to production
echo "📁 Copying updated files..."
cp -r dist/public/* /var/www/parmanand-sports-academy/public/
cp dist/index.js /var/www/parmanand-sports-academy/

# Restart the application
echo "🔄 Restarting application..."
pm2 restart parmanand-sports-academy

# Check status
echo "✅ Deployment complete! Checking status..."
pm2 status parmanand-sports-academy

echo "🎉 Bug fix deployed successfully!"
echo "🌐 Application available at: http://194.238.23.217"