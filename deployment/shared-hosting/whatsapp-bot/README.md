# PSA WhatsApp Bot Service 📱

A comprehensive WhatsApp automation service for PSA Sports Academy Management Suite, built with Node.js and Puppeteer.

## 🌟 Features

### Core Functionality
- **Automated Fee Reminders**: Send payment reminders to students with outstanding fees
- **Session Notifications**: Notify students about upcoming training sessions
- **Attendance Alerts**: Alert parents about low attendance rates
- **Birthday Wishes**: Automated birthday messages for students
- **Payment Confirmations**: Send receipt confirmations after payments

### Technical Features
- **WhatsApp Web Integration**: Uses Puppeteer to automate WhatsApp Web
- **Session Persistence**: Maintains WhatsApp login sessions
- **Queue Management**: Handles message queuing and rate limiting
- **Cron Jobs**: Automated scheduling for recurring tasks
- **Health Monitoring**: Built-in health checks and monitoring
- **Laravel Integration**: Seamless integration with Laravel API
- **PM2 Support**: Production-ready process management

## 🚀 Quick Start

### Prerequisites
- Node.js 16+ 
- npm or yarn
- Chrome/Chromium browser
- Laravel PSA application running

### Installation

1. **Clone and Navigate**
   ```bash
   cd PSA-NASHIK/whatsapp-bot
   ```

2. **Install Dependencies**
   ```bash
   npm install
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   # Edit .env with your configuration
   ```

4. **Start the Service**
   ```bash
   ./start.sh
   ```

### Environment Configuration

```env
# WhatsApp Bot Configuration
PORT=3001
NODE_ENV=development

# Laravel API Configuration
LARAVEL_API_URL=http://localhost:51897/api/v1
LARAVEL_API_TOKEN=your-api-token-here

# WhatsApp Configuration
WHATSAPP_SESSION_PATH=./sessions
WHATSAPP_HEADLESS=true
WHATSAPP_TIMEOUT=60000

# Message Templates
ENABLE_FEE_REMINDERS=true
ENABLE_SESSION_NOTIFICATIONS=true
ENABLE_ATTENDANCE_ALERTS=true

# Cron Jobs
FEE_REMINDER_CRON=0 9 * * 1
SESSION_REMINDER_CRON=0 8 * * *
ATTENDANCE_ALERT_CRON=0 18 * * *

# Security
WEBHOOK_SECRET=your-webhook-secret-here
ALLOWED_ORIGINS=http://localhost:51897
```

## 📡 API Endpoints

### Health & Status
- `GET /health` - Service health check
- `GET /status` - Bot status and session info
- `GET /qr-code` - Get QR code for authentication

### Bot Management
- `POST /initialize` - Initialize WhatsApp bot
- `POST /send-message` - Send custom message
- `POST /send-fee-reminder` - Send fee reminder to student
- `POST /send-session-notification` - Send session notification to batch

### Webhooks
- `POST /webhook` - Receive events from Laravel application

## 🔄 Automated Jobs

### Fee Reminders
- **Schedule**: Every Monday at 9 AM
- **Function**: Sends payment reminders to students with overdue fees
- **Template**: Professional fee reminder with payment details

### Session Notifications
- **Schedule**: Every day at 8 AM
- **Function**: Notifies students about next day's training sessions
- **Template**: Session details with coach info and instructions

### Attendance Alerts
- **Schedule**: Every day at 6 PM
- **Function**: Alerts parents about students with low attendance
- **Template**: Attendance summary with encouragement message

### Birthday Wishes
- **Schedule**: Every day at 10 AM
- **Function**: Sends birthday wishes to students
- **Template**: Personalized birthday message with special offers

## 🛠️ Usage Examples

### Send Custom Message
```bash
curl -X POST http://localhost:3001/send-message \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "919876543210",
    "message": "Hello from PSA Sports Academy!",
    "type": "text"
  }'
```

### Send Fee Reminder
```bash
curl -X POST http://localhost:3001/send-fee-reminder \
  -H "Content-Type: application/json" \
  -d '{
    "student_id": 123,
    "payment_details": {
      "amount": 5000,
      "due_date": "2025-07-30"
    }
  }'
```

### Check Bot Status
```bash
curl http://localhost:3001/status
```

## 🔧 Management Commands

### Using PM2 (Production)
```bash
# Start service
pm2 start ecosystem.config.js

# View logs
pm2 logs psa-whatsapp-bot

# Restart service
pm2 restart psa-whatsapp-bot

# Stop service
pm2 stop psa-whatsapp-bot

# Monitor
pm2 monit
```

### Using Scripts
```bash
# Start service
./start.sh

# Stop service
./stop.sh
```

### Using npm
```bash
# Development mode
npm run dev

# Production mode
npm start
```

## 📱 WhatsApp Authentication

### First Time Setup
1. Start the service
2. Check logs for QR code or visit `/qr-code` endpoint
3. Scan QR code with WhatsApp mobile app
4. Service will automatically save session for future use

### Session Management
- Sessions are stored in `./sessions` directory
- Sessions persist across restarts
- If session expires, new QR code will be generated

## 🔍 Monitoring & Logging

### Log Files
- `./logs/whatsapp-bot.log` - Application logs
- `./logs/pm2-*.log` - PM2 process logs

### Health Checks
- Built-in health monitoring every 30 minutes
- Automatic log rotation and cleanup
- Integration with Laravel API for centralized logging

### Monitoring Endpoints
```bash
# Service health
curl http://localhost:3001/health

# Bot status
curl http://localhost:3001/status
```

## 🔐 Security Features

- **Webhook Signature Verification**: Validates incoming webhooks
- **CORS Protection**: Configurable allowed origins
- **Rate Limiting**: Prevents message spam
- **Session Security**: Secure session storage
- **Input Validation**: Validates all incoming data

## 🏗️ Architecture

```
PSA WhatsApp Bot Service
├── index.js                 # Main application entry
├── src/
│   ├── WhatsAppBot.js       # Core WhatsApp automation
│   ├── MessageTemplates.js  # Message template engine
│   ├── LaravelAPI.js        # Laravel API integration
│   ├── Logger.js            # Logging system
│   └── CronJobs.js          # Scheduled task manager
├── sessions/                # WhatsApp session storage
├── logs/                    # Application logs
└── temp/                    # Temporary files
```

## 🔄 Integration with Laravel

### API Authentication
The bot authenticates with Laravel using API tokens:
```javascript
// Set token in environment
LARAVEL_API_TOKEN=your-sanctum-token

// Or authenticate programmatically
await laravelAPI.authenticate('admin@psa.com', 'password');
```

### Webhook Events
Laravel can trigger bot actions via webhooks:
```php
// In Laravel controller
Http::post('http://localhost:3001/webhook', [
    'event' => 'fee_reminder',
    'data' => [
        'student_id' => $student->id,
        'payment_details' => $paymentDetails
    ]
]);
```

## 🚨 Troubleshooting

### Common Issues

**Bot not connecting to WhatsApp**
- Check if Chrome/Chromium is installed
- Verify session directory permissions
- Clear sessions and re-authenticate

**Messages not sending**
- Verify phone number format (+91XXXXXXXXXX)
- Check WhatsApp Web connection
- Review rate limiting settings

**Laravel API connection failed**
- Verify API URL and token
- Check Laravel application status
- Review CORS settings

### Debug Mode
```bash
# Enable debug logging
NODE_ENV=development npm start

# View detailed logs
tail -f logs/whatsapp-bot.log
```

## 📈 Performance Optimization

### Production Settings
- Use `WHATSAPP_HEADLESS=true` for better performance
- Configure appropriate timeouts
- Enable PM2 clustering if needed
- Set up log rotation

### Resource Usage
- Memory: ~200-500MB per instance
- CPU: Low usage, spikes during message sending
- Storage: Sessions and logs require minimal space

## 🔮 Future Enhancements

- **Multi-device Support**: Support multiple WhatsApp accounts
- **Rich Media**: Support for images, documents, and voice messages
- **Chatbot Features**: Interactive responses and commands
- **Analytics Dashboard**: Message delivery statistics
- **Template Builder**: Visual template creation interface

## 📞 Support

For issues and questions:
- Check logs in `./logs/` directory
- Review Laravel API connectivity
- Verify WhatsApp Web session status
- Contact development team

## 📄 License

This project is part of the PSA Sports Academy Management Suite.

---

**Version**: 1.0.0  
**Last Updated**: July 27, 2025  
**Node.js**: 16+  
**Dependencies**: Puppeteer, Express, Axios, Node-cron