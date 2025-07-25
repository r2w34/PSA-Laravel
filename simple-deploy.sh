#!/bin/bash

echo "🚀 Deploying to production server..."

# Create a simple HTTP server to serve the deployment package
echo "📦 Starting temporary file server..."
python3 -m http.server 8080 &
SERVER_PID=$!

echo "📋 Deployment package available at: http://localhost:8080/deployment.tar.gz"
echo "🔗 You can now download this file to the production server using:"
echo "   wget http://YOUR_LOCAL_IP:8080/deployment.tar.gz"
echo ""
echo "📝 On the production server, run:"
echo "   cd /var/www/psa-nashik"
echo "   wget http://YOUR_LOCAL_IP:8080/deployment.tar.gz"
echo "   tar -xzf deployment.tar.gz"
echo "   npm install --production"
echo "   pm2 restart psa-nashik || pm2 start dist/index.js --name psa-nashik"
echo ""
echo "Press Ctrl+C to stop the file server when deployment is complete."

# Wait for user to stop
wait $SERVER_PID