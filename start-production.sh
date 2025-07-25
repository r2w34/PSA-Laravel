#!/bin/bash

# PSA Nashik Production Startup Script

set -e

echo "🚀 Starting PSA Nashik in Production Mode..."

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m'

print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "dist/index.js" ]; then
    print_error "dist/index.js not found. Please run 'npm run build' first."
    exit 1
fi

# Set production environment
export NODE_ENV=production
export PORT=${PORT:-5000}

# Check if .env file exists
if [ ! -f ".env" ]; then
    print_status "Creating .env file from production template..."
    if [ -f ".env.production" ]; then
        cp .env.production .env
        print_status "Please edit .env file with your configuration before starting."
        exit 1
    else
        print_error ".env.production template not found."
        exit 1
    fi
fi

# Load environment variables
if [ -f ".env" ]; then
    export $(cat .env | grep -v '^#' | xargs)
fi

# Check if port is available
if lsof -Pi :$PORT -sTCP:LISTEN -t >/dev/null 2>&1; then
    print_error "Port $PORT is already in use. Please stop the existing process or change the PORT."
    exit 1
fi

# Create logs directory
mkdir -p logs

# Start the application
print_status "Starting PSA Nashik on port $PORT..."

cd dist

# Start with PM2 if available, otherwise use nohup
if command -v pm2 &> /dev/null; then
    print_status "Starting with PM2..."
    pm2 start index.js --name "psa-nashik" --env production
    pm2 save
    print_success "Application started with PM2!"
    print_status "Use 'pm2 status' to check status"
    print_status "Use 'pm2 logs psa-nashik' to view logs"
    print_status "Use 'pm2 stop psa-nashik' to stop"
else
    print_status "Starting with nohup..."
    nohup node index.js > ../logs/psa-nashik.log 2>&1 &
    PID=$!
    echo $PID > ../psa-nashik.pid
    print_success "Application started with PID: $PID"
    print_status "Logs: tail -f logs/psa-nashik.log"
    print_status "Stop: kill \$(cat psa-nashik.pid)"
fi

# Wait a moment and check if the process is running
sleep 3

if command -v pm2 &> /dev/null; then
    if pm2 list | grep -q "psa-nashik.*online"; then
        print_success "✅ PSA Nashik is running successfully!"
    else
        print_error "❌ Failed to start PSA Nashik. Check PM2 logs."
        exit 1
    fi
else
    if [ -f "../psa-nashik.pid" ] && kill -0 $(cat ../psa-nashik.pid) 2>/dev/null; then
        print_success "✅ PSA Nashik is running successfully!"
    else
        print_error "❌ Failed to start PSA Nashik. Check logs."
        exit 1
    fi
fi

echo ""
print_success "🎉 PSA Nashik is now running in production mode!"
print_success "📱 Application URL: http://localhost:$PORT"
print_success "🗄️  Make sure your database is running and accessible"

echo ""
print_status "Next steps:"
echo "1. Configure your reverse proxy (Nginx/Apache) to point to port $PORT"
echo "2. Set up SSL certificates for HTTPS"
echo "3. Configure your domain name"
echo "4. Set up database backups"
echo "5. Configure monitoring and alerts"