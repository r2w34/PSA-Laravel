#!/bin/bash

# Dokploy Deployment Script for Parmanand Sports Academy
set -e

echo "🚀 Starting Dokploy deployment for Parmanand Sports Academy..."

# Set production environment variables
echo "🔧 Setting NODE_ENV and PORT environment variables..."
export NODE_ENV=production
export PORT=${PORT:-5000}
echo "   ✅ NODE_ENV=$NODE_ENV"
echo "   ✅ PORT=$PORT"

# Build the application
echo "🔧 Building application..."
npm run build
echo "   ✅ Application built successfully"

# Start the application
echo "🚀 Starting production application..."
echo "   Application will be available at port $PORT"
echo "   Health check: http://localhost:$PORT/api/health"
echo ""

# Start the application with proper environment
NODE_ENV=production PORT=$PORT npm start