#!/bin/bash

# PSA WhatsApp Bot Stop Script

echo "🛑 Stopping PSA WhatsApp Bot Service..."

# Check if PM2 is available and process is running
if command -v pm2 &> /dev/null; then
    if pm2 list | grep -q "psa-whatsapp-bot"; then
        echo "🔄 Stopping PM2 process..."
        pm2 stop psa-whatsapp-bot
        pm2 delete psa-whatsapp-bot
        echo "✅ PSA WhatsApp Bot stopped successfully"
    else
        echo "⚠️  No PM2 process found for psa-whatsapp-bot"
    fi
else
    echo "⚠️  PM2 not found. Attempting to kill Node.js processes..."
    
    # Find and kill Node.js processes running the bot
    PIDS=$(ps aux | grep "node.*index.js" | grep -v grep | awk '{print $2}')
    
    if [ -n "$PIDS" ]; then
        echo "🔍 Found processes: $PIDS"
        echo "$PIDS" | xargs kill -TERM
        sleep 2
        
        # Force kill if still running
        REMAINING=$(ps aux | grep "node.*index.js" | grep -v grep | awk '{print $2}')
        if [ -n "$REMAINING" ]; then
            echo "💀 Force killing remaining processes..."
            echo "$REMAINING" | xargs kill -KILL
        fi
        
        echo "✅ Processes terminated"
    else
        echo "ℹ️  No running processes found"
    fi
fi

echo "🏁 Stop script completed"