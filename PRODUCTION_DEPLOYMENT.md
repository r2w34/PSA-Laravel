# 🚀 PSA-NASHIK Production Deployment Guide

## 📋 Overview

PSA-NASHIK is a comprehensive Sports Academy Management System with complete authentication, student management, payment tracking, and advanced features like AI insights, gamification, and campaign automation.

## ✅ Features Included

### Core Features
- ✅ **Complete Authentication System** (Session-based)
- ✅ **Student Management** (Registration, profiles, batch assignment)
- ✅ **Payment Tracking** (Fees, installments, revenue analytics)
- ✅ **Attendance Management** (Student and coach tracking)
- ✅ **Sports & Batch Management** (Multiple sports, flexible batching)
- ✅ **Coach Management** (Profiles, assignments, attendance)

### Advanced Features
- ✅ **AI-Powered Insights** (Student performance, revenue analysis)
- ✅ **Gamification System** (Badges, achievements, leaderboards)
- ✅ **Campaign Automation** (WhatsApp notifications, email campaigns)
- ✅ **Real-time Dashboard** (WebSocket updates, live statistics)
- ✅ **Location Tracking** (Geofencing, attendance verification)
- ✅ **Custom Reports** (Advanced analytics, data export)
- ✅ **Mobile API** (Complete mobile app support)

### Security & Performance
- ✅ **Production-Ready Security** (Session management, CORS, headers)
- ✅ **Database Optimization** (Indexed queries, connection pooling)
- ✅ **Error Handling** (Comprehensive logging, graceful failures)
- ✅ **Performance Monitoring** (Request logging, health checks)

## 🛠️ System Requirements

### Server Requirements
- **OS**: Ubuntu 20.04+ or similar Linux distribution
- **RAM**: Minimum 2GB, Recommended 4GB+
- **Storage**: Minimum 20GB SSD
- **CPU**: 2+ cores recommended
- **Network**: Public IP with ports 80, 443 accessible

### Software Dependencies
- **Node.js**: 18.x or higher
- **PostgreSQL**: 12.x or higher
- **Nginx**: Latest stable version
- **Git**: For repository management

## 🚀 Quick Deployment

### Option 1: One-Command Deployment

```bash
# Connect to your VPS
ssh root@your-server-ip

# Run the production deployment script
curl -fsSL https://raw.githubusercontent.com/r2w34/PSA-NASHIK/main/production-deploy.sh | bash
```

### Option 2: Manual Deployment

```bash
# 1. Clone repository
git clone https://github.com/r2w34/PSA-NASHIK.git
cd PSA-NASHIK

# 2. Make deployment script executable
chmod +x production-deploy.sh

# 3. Run deployment
sudo ./production-deploy.sh
```

## 🔧 Configuration

### Environment Variables

The deployment script creates a `.env` file with the following configuration:

```env
# Database Configuration
DATABASE_URL=postgresql://psa_user:secure_password_change_me@localhost:5432/psa_nashik

# Application Configuration
NODE_ENV=production
PORT=5000
HTTPS=false

# Session Configuration
SESSION_SECRET=randomly_generated_secret

# WhatsApp Configuration (configure with your credentials)
WHATSAPP_API_URL=https://api.whatsapp.com
WHATSAPP_TOKEN=your_whatsapp_token_here

# Email Configuration (configure with your SMTP settings)
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your_email@gmail.com
SMTP_PASS=your_app_password
```

### Post-Deployment Configuration

1. **Update Domain Name**:
   ```bash
   sudo nano /etc/nginx/sites-available/psa-nashik
   # Change server_name from _ to your domain
   sudo systemctl reload nginx
   ```

2. **Configure SSL Certificate** (Recommended):
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com
   ```

3. **Update WhatsApp & Email Credentials**:
   ```bash
   sudo nano /var/www/PSA-NASHIK/.env
   # Update WHATSAPP_TOKEN, SMTP_USER, SMTP_PASS
   sudo systemctl restart psa-nashik
   ```

## 🔐 Default Admin Access

After deployment, you can access the system with:

- **URL**: `http://your-server-ip`
- **Admin Email**: `admin@psa-nashik.com`
- **Admin Password**: `admin123`

**⚠️ Important**: Change the default admin password immediately after first login!

## 🧪 Testing the Deployment

### 1. Health Check
```bash
curl http://your-server-ip/api/health
# Expected: {"status":"OK","timestamp":"..."}
```

### 2. Authentication Test
```bash
curl -X POST http://your-server-ip/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@psa-nashik.com","password":"admin123"}'
# Expected: {"success":true,"user":{...}}
```

### 3. Frontend Access
```bash
curl -I http://your-server-ip
# Expected: HTTP/1.1 200 OK
```

## 📊 Service Management

### Check Service Status
```bash
sudo systemctl status psa-nashik
sudo systemctl status nginx
sudo systemctl status postgresql
```

### View Logs
```bash
# Application logs
sudo journalctl -u psa-nashik -f

# Nginx logs
sudo tail -f /var/log/nginx/access.log
sudo tail -f /var/log/nginx/error.log
```

### Restart Services
```bash
sudo systemctl restart psa-nashik
sudo systemctl restart nginx
```

### Update Application
```bash
cd /var/www/PSA-NASHIK
git pull origin main
npm install
npm run build
sudo systemctl restart psa-nashik
```

## 🔒 Security Considerations

### Firewall Configuration
```bash
# Allow SSH, HTTP, and HTTPS
sudo ufw allow ssh
sudo ufw allow 80
sudo ufw allow 443
sudo ufw enable
```

### Database Security
```bash
# Change default database password
sudo -u postgres psql
ALTER USER psa_user WITH PASSWORD 'your_secure_password';
\q

# Update .env file with new password
sudo nano /var/www/PSA-NASHIK/.env
sudo systemctl restart psa-nashik
```

### Session Security
- Session secret is automatically generated during deployment
- Sessions expire after 24 hours
- HTTP-only cookies prevent XSS attacks
- Secure cookies enabled for HTTPS

## 📈 Performance Optimization

### Database Optimization
```bash
# Optimize PostgreSQL for production
sudo nano /etc/postgresql/*/main/postgresql.conf
# Adjust shared_buffers, effective_cache_size, work_mem
sudo systemctl restart postgresql
```

### Nginx Optimization
```bash
# Enable gzip compression (already configured)
# Enable caching for static assets
# Configure rate limiting if needed
```

## 🔧 Troubleshooting

### Common Issues

1. **404 Error**:
   ```bash
   # Check if service is running
   sudo systemctl status psa-nashik
   # Check nginx configuration
   sudo nginx -t
   ```

2. **Database Connection Error**:
   ```bash
   # Check PostgreSQL status
   sudo systemctl status postgresql
   # Test database connection
   sudo -u postgres psql -d psa_nashik -c "SELECT 1;"
   ```

3. **Authentication Not Working**:
   ```bash
   # Check if admin user exists
   sudo -u postgres psql -d psa_nashik -c "SELECT * FROM users WHERE email='admin@psa-nashik.com';"
   # Check session configuration in logs
   sudo journalctl -u psa-nashik -n 50
   ```

### Log Analysis
```bash
# Check for errors in application logs
sudo journalctl -u psa-nashik --since "1 hour ago" | grep -i error

# Monitor real-time logs
sudo journalctl -u psa-nashik -f
```

## 📞 Support

### Useful Commands
```bash
# Service management
sudo systemctl {start|stop|restart|status} psa-nashik

# Database access
sudo -u postgres psql -d psa_nashik

# Application directory
cd /var/www/PSA-NASHIK

# Configuration files
/etc/nginx/sites-available/psa-nashik
/etc/systemd/system/psa-nashik.service
/var/www/PSA-NASHIK/.env
```

### Monitoring
- Application logs: `journalctl -u psa-nashik -f`
- Nginx access logs: `/var/log/nginx/access.log`
- Database logs: `journalctl -u postgresql -f`
- System resources: `htop`, `df -h`, `free -h`

## 🎉 Success Indicators

After successful deployment, you should have:

- ✅ **Frontend accessible** at `http://your-server-ip`
- ✅ **API endpoints working** at `http://your-server-ip/api`
- ✅ **Authentication system functional**
- ✅ **Database connected and populated**
- ✅ **All services running and enabled**
- ✅ **Admin user created and accessible**
- ✅ **No 404 or authentication errors**

## 🚀 Next Steps

1. **Configure your domain name and SSL certificate**
2. **Set up WhatsApp and email integrations**
3. **Customize the application branding**
4. **Import your existing student data**
5. **Train your staff on the system**
6. **Set up regular backups**

---

**PSA-NASHIK is now ready for production use! 🎊**

For additional support or customization, refer to the application documentation or contact the development team.