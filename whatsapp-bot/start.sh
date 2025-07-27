#!/bin/bash

# PSA WhatsApp Bot Startup Script

echo "🚀 Starting PSA WhatsApp Bot Service..."

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js 16+ first."
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "❌ npm is not installed. Please install npm first."
    exit 1
fi

# Create necessary directories
echo "📁 Creating directories..."
mkdir -p logs sessions temp

# Check if .env file exists
if [ ! -f .env ]; then
    echo "⚠️  .env file not found. Copying from .env.example..."
    if [ -f .env.example ]; then
        cp .env.example .env
        echo "✅ .env file created. Please configure it before running the bot."
        echo "📝 Edit .env file with your configuration:"
        echo "   - LARAVEL_API_URL"
        echo "   - LARAVEL_API_TOKEN"
        echo "   - WEBHOOK_SECRET"
        echo ""
        echo "After configuring .env, run this script again."
        exit 1
    else
        echo "❌ .env.example file not found. Please create .env file manually."
        exit 1
    fi
fi

# Install dependencies if node_modules doesn't exist
if [ ! -d "node_modules" ]; then
    echo "📦 Installing dependencies..."
    npm install
    if [ $? -ne 0 ]; then
        echo "❌ Failed to install dependencies."
        exit 1
    fi
fi

# Check if PM2 is installed globally
if command -v pm2 &> /dev/null; then
    echo "🔄 Using PM2 for process management..."
    
    # Stop existing instance if running
    pm2 stop psa-whatsapp-bot 2>/dev/null || true
    
    # Start with PM2
    pm2 start ecosystem.config.js
    
    # Save PM2 configuration
    pm2 save
    
    echo "✅ PSA WhatsApp Bot started with PM2"
    echo "📊 View logs: pm2 logs psa-whatsapp-bot"
    echo "📈 View status: pm2 status"
    echo "🛑 Stop service: pm2 stop psa-whatsapp-bot"
    
else
    echo "⚠️  PM2 not found. Starting in development mode..."
    echo "💡 For production, install PM2: npm install -g pm2"
    
    # Start in development mode
    npm start
fi

echo ""
echo "🌐 Service URL: http://localhost:3001"
echo "❤️  Health Check: http://localhost:3001/health"
echo "📱 Bot Status: http://localhost:3001/status"