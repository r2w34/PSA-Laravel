#!/bin/bash

# Deploy the fixed student creation issue
echo "Deploying student creation fix..."

# Create a tar file of the dist directory
cd /workspace/PSA-NASHIK
tar -czf psa-fix.tar.gz dist/

# Copy to VPS
echo "Copying files to VPS..."
scp psa-fix.tar.gz root@45.194.46.109:/tmp/

# SSH to VPS and extract
echo "Extracting and restarting application..."
ssh root@45.194.46.109 << 'EOF'
cd /tmp
tar -xzf psa-fix.tar.gz
cp -r dist/* /var/www/psa-nashik/dist/
rm -f psa-fix.tar.gz

# Restart the application
echo "Restarting PSA application..."
pkill -f "node.*psa-nashik"
cd /var/www/psa-nashik/dist
nohup node index.js > /var/log/psa-nashik.log 2>&1 &
echo "Application restarted"

# Check if it's running
sleep 2
if pgrep -f "node.*psa-nashik" > /dev/null; then
    echo "✅ Application is running successfully"
    echo "PID: $(pgrep -f 'node.*psa-nashik')"
else
    echo "❌ Application failed to start"
    echo "Last 10 lines of log:"
    tail -10 /var/log/psa-nashik.log
fi
EOF

echo "Deployment completed!"