#!/bin/bash

# Server-side deployment script
echo "Starting PSA Nashik deployment..."

# Download the updated files
cd /tmp
wget -O psa-fix.tar.gz "http://31.97.61.137:8080/psa-fix.tar.gz"

if [ $? -eq 0 ]; then
    echo "Files downloaded successfully"
    
    # Extract and deploy
    tar -xzf psa-fix.tar.gz
    
    # Backup current deployment
    cp -r /var/www/psa-nashik/dist /var/www/psa-nashik/dist.backup.$(date +%Y%m%d_%H%M%S)
    
    # Deploy new files
    cp -r dist/* /var/www/psa-nashik/dist/
    
    # Restart application
    echo "Restarting application..."
    pkill -f "node.*psa-nashik"
    
    cd /var/www/psa-nashik/dist
    nohup node index.js > /var/log/psa-nashik.log 2>&1 &
    
    sleep 3
    
    # Check if application started
    if pgrep -f "node.*psa-nashik" > /dev/null; then
        echo "✅ Application restarted successfully"
        echo "PID: $(pgrep -f 'node.*psa-nashik')"
    else
        echo "❌ Application failed to start"
        echo "Last 10 lines of log:"
        tail -10 /var/log/psa-nashik.log
    fi
    
    # Cleanup
    rm -f /tmp/psa-fix.tar.gz
    rm -rf /tmp/dist
    
else
    echo "❌ Failed to download files"
fi