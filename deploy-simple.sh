#!/bin/bash

# Simple deployment script
echo "Deploying PSA Nashik fixes..."

# Copy the tar file to the server
echo "Copying files to server..."
scp psa-fix.tar.gz root@45.194.46.109:/tmp/psa-fix.tar.gz

echo "Files copied. Now SSH to the server and run:"
echo "cd /tmp && tar -xzf psa-fix.tar.gz && cp -r dist/* /var/www/psa-nashik/dist/ && pkill -f 'node.*psa-nashik' && cd /var/www/psa-nashik/dist && nohup node index.js > /var/log/psa-nashik.log 2>&1 &"