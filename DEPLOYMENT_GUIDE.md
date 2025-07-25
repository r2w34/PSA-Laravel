# PSA Nashik - Complete Deployment Guide

## 🚀 Quick Start (Recommended: Docker)

### Prerequisites
- Docker and Docker Compose installed
- Git installed
- 4GB+ RAM, 20GB+ storage

### One-Command Deployment
```bash
git clone <your-repo-url> psa-nashik && cd psa-nashik && ./deploy-docker.sh
```

## 📋 Deployment Options

### Option 1: Docker Deployment (Recommended)

**Advantages:**
- Complete isolated environment
- Includes PostgreSQL, Redis, and Nginx
- Easy to scale and maintain
- Consistent across different servers

**Steps:**
1. Clone the repository
2. Run the deployment script:
   ```bash
   ./deploy-docker.sh
   ```
3. Access the application at `http://localhost`

**Services Included:**
- **App**: PSA Nashik application (Port 5000)
- **Database**: PostgreSQL 15 (Port 5432)
- **Cache**: Redis 7 (Port 6379)
- **Web Server**: Nginx (Ports 80/443)

### Option 2: VPS Deployment

**For existing VPS with Node.js:**
```bash
# Build the application
npm run build

# Copy dist folder to your server
scp -r dist/ user@your-server:/var/www/psa-nashik/

# SSH to server and start
ssh user@your-server
cd /var/www/psa-nashik/dist
nohup node index.js > /var/log/psa-nashik.log 2>&1 &
```

### Option 3: Cloud Platform Deployment

**Dokploy/Railway/Render:**
1. Connect your Git repository
2. Set environment variables (see below)
3. Deploy with one click

## 🔧 Environment Configuration

### Required Environment Variables
```env
NODE_ENV=production
PORT=5000
DATABASE_URL=postgresql://user:password@host:port/database
SESSION_SECRET=your-secure-session-secret
```

### Optional API Keys
```env
# AI Features
GEMINI_API_KEY=your-gemini-api-key

# Payment Gateways
STRIPE_SECRET_KEY=sk_live_...
VITE_STRIPE_PUBLIC_KEY=pk_live_...
RAZORPAY_KEY_ID=rzp_live_...
RAZORPAY_KEY_SECRET=your-razorpay-secret
PAYPAL_CLIENT_ID=your-paypal-client-id
PAYPAL_CLIENT_SECRET=your-paypal-secret

# Communication
WHATSAPP_API_KEY=your-whatsapp-api-key

# Firebase (for mobile app)
VITE_FIREBASE_API_KEY=your-firebase-api-key
VITE_FIREBASE_PROJECT_ID=your-project-id
VITE_FIREBASE_APP_ID=your-app-id
```

## 🗄️ Database Setup

### Automatic Setup (Docker)
Database is automatically created and configured with Docker deployment.

### Manual Setup
```sql
-- Create database
CREATE DATABASE parmanand_sports;

-- Create user
CREATE USER parmanand_user WITH PASSWORD 'your_password';

-- Grant permissions
GRANT ALL PRIVILEGES ON DATABASE parmanand_sports TO parmanand_user;
```

## 🔒 Security Configuration

### SSL/HTTPS Setup
1. Obtain SSL certificates (Let's Encrypt recommended)
2. Update `nginx.conf` with certificate paths
3. Restart Nginx container

### Firewall Configuration
```bash
# Allow HTTP and HTTPS
ufw allow 80
ufw allow 443

# Allow SSH (if needed)
ufw allow 22

# Enable firewall
ufw enable
```

## 📊 Monitoring and Maintenance

### View Logs
```bash
# Docker deployment
docker-compose logs -f

# VPS deployment
tail -f /var/log/psa-nashik.log
```

### Health Checks
- Application: `http://your-domain/api/health`
- Database: Check container status
- Redis: Check container status

### Backup Database
```bash
# Docker deployment
docker-compose exec db pg_dump -U parmanand_user parmanand_sports > backup.sql

# Restore
docker-compose exec -T db psql -U parmanand_user parmanand_sports < backup.sql
```

## 🔄 Updates and Maintenance

### Update Application
```bash
# Pull latest changes
git pull origin main

# Rebuild and restart
docker-compose build --no-cache
docker-compose up -d
```

### Scale Services
```bash
# Scale app instances
docker-compose up -d --scale app=3
```

## 🆘 Troubleshooting

### Common Issues

**Port Already in Use:**
```bash
# Find process using port
lsof -i :5000
# Kill process
kill -9 <PID>
```

**Database Connection Issues:**
- Check DATABASE_URL format
- Verify database is running
- Check network connectivity

**Build Failures:**
- Clear node_modules: `rm -rf node_modules && npm install`
- Clear Docker cache: `docker system prune -a`

### Support Commands
```bash
# Check container status
docker-compose ps

# View container logs
docker-compose logs <service-name>

# Restart specific service
docker-compose restart <service-name>

# Access container shell
docker-compose exec <service-name> sh
```

## 📱 Mobile App Deployment

The React Native mobile app can be deployed separately:
1. Follow `REACT_NATIVE_SETUP.md`
2. Configure Firebase
3. Build and deploy to app stores

## 🎯 Production Checklist

- [ ] Environment variables configured
- [ ] Database backup scheduled
- [ ] SSL certificates installed
- [ ] Monitoring setup
- [ ] Firewall configured
- [ ] Domain name configured
- [ ] Email notifications setup
- [ ] Payment gateways tested
- [ ] WhatsApp integration tested
- [ ] Mobile app connected

## 📞 Support

For deployment support:
1. Check logs first
2. Review this guide
3. Check GitHub issues
4. Contact support team

---

**🎉 Congratulations! Your PSA Nashik application is now deployed and ready to use!**