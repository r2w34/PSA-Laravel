# 🚀 PSA-NASHIK VPS Deployment Instructions

## 📋 Prerequisites

Before deploying to your VPS server, ensure you have:

1. **VPS Server Requirements:**
   - Ubuntu 22.04 LTS (recommended)
   - Minimum 4GB RAM (8GB recommended)
   - 2+ vCPUs
   - 50GB+ SSD storage
   - Root or sudo access

2. **Domain Setup:**
   - Domain name pointing to your VPS IP address
   - DNS A record configured

3. **Access Information:**
   - VPS IP address or hostname
   - SSH access credentials

## 🎯 Deployment Options

### Option 1: Automated Installation (Recommended)

**Step 1:** Upload the deployment package to your VPS
```bash
# On your local machine, create a tar file
tar -czf psa-nashik-deployment.tar.gz deployment-package/

# Upload to your VPS (replace with your details)
scp psa-nashik-deployment.tar.gz user@your-server-ip:/home/user/
```

**Step 2:** SSH into your VPS and extract
```bash
ssh user@your-server-ip
tar -xzf psa-nashik-deployment.tar.gz
cd deployment-package
```

**Step 3:** Run the automated installer
```bash
chmod +x vps-installer.sh
./vps-installer.sh
```

The script will prompt you for:
- Domain name (e.g., sports.yourdomain.com)
- Database password
- Optional API keys (Gemini, WhatsApp, Stripe)

### Option 2: Manual Installation

Follow the detailed steps in `VPS_DEPLOYMENT_GUIDE.md` for complete control over the installation process.

## 🔧 What the Installer Does

The automated installer will:

1. ✅ **Update system packages**
2. ✅ **Install Node.js 20 and npm**
3. ✅ **Install PostgreSQL database**
4. ✅ **Create database and user**
5. ✅ **Install and configure Nginx**
6. ✅ **Setup SSL certificate (Let's Encrypt)**
7. ✅ **Install PM2 process manager**
8. ✅ **Configure firewall (UFW)**
9. ✅ **Setup automated database backups**
10. ✅ **Start the application**

## 📊 Post-Deployment Verification

After installation, verify everything is working:

### 1. Check Application Status
```bash
pm2 status
pm2 logs parmanand-sports-academy
```

### 2. Test Database Connection
```bash
curl http://localhost:3000/api/health
```

### 3. Test HTTPS Access
```bash
curl https://yourdomain.com/api/health
```

### 4. Access Admin Panel
- Open: `https://yourdomain.com`
- Login with: `admin@psa-nashik.com` / `admin123`

## 🛠️ Management Commands

### Application Management
```bash
# Check status
pm2 status

# View logs
pm2 logs

# Restart application
pm2 restart parmanand-sports-academy

# Stop application
pm2 stop parmanand-sports-academy

# Start application
pm2 start parmanand-sports-academy
```

### Database Management
```bash
# Manual backup
~/backup-db.sh

# Connect to database
psql -U parmanand_user -d parmanand_sports -h localhost

# View database size
psql -U parmanand_user -d parmanand_sports -h localhost -c "\l+"
```

### System Management
```bash
# Check disk space
df -h

# Check memory usage
free -h

# Check system logs
sudo journalctl -f

# Check Nginx status
sudo systemctl status nginx

# Restart Nginx
sudo systemctl restart nginx
```

## 🔒 Security Features

The deployment includes:

- ✅ **SSL/TLS encryption** (Let's Encrypt)
- ✅ **Firewall configuration** (UFW)
- ✅ **Security headers** in Nginx
- ✅ **Non-root application user**
- ✅ **Database user isolation**
- ✅ **Session security**
- ✅ **CORS protection**

## 📈 Performance Optimization

### Nginx Optimizations
- Gzip compression enabled
- Static file caching
- Proxy buffering
- Security headers

### PM2 Optimizations
- Cluster mode (multi-process)
- Automatic restarts
- Memory limit monitoring
- Log rotation

### Database Optimizations
- Connection pooling
- Query optimization
- Regular backups
- Index optimization

## 🔄 Updates and Maintenance

### Application Updates
```bash
cd /home/parmanand/parmanand-sports-academy

# Pull latest changes
git pull origin main

# Install new dependencies
npm install

# Build application
npm run build

# Run database migrations
npm run db:push

# Restart application
pm2 restart parmanand-sports-academy
```

### System Updates
```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Update Node.js (if needed)
sudo npm install -g npm@latest

# Update PM2
sudo npm install -g pm2@latest
pm2 update
```

## 🚨 Troubleshooting

### Common Issues and Solutions

#### 1. Application Won't Start
```bash
# Check logs
pm2 logs

# Common causes:
# - Database connection failed
# - Port already in use
# - Missing environment variables
```

#### 2. Database Connection Error
```bash
# Check PostgreSQL status
sudo systemctl status postgresql

# Restart PostgreSQL
sudo systemctl restart postgresql

# Check database credentials in .env.production
```

#### 3. SSL Certificate Issues
```bash
# Check certificate status
sudo certbot certificates

# Renew certificate manually
sudo certbot renew

# Check Nginx configuration
sudo nginx -t
```

#### 4. High Memory Usage
```bash
# Check memory usage
free -h
htop

# Restart application to clear memory
pm2 restart parmanand-sports-academy
```

#### 5. Disk Space Full
```bash
# Check disk usage
df -h

# Clean old logs
pm2 flush

# Clean old backups
find ~/backups -name "*.sql" -mtime +30 -delete
```

## 📞 Support

### Log Files Locations
- **Application logs:** `~/parmanand-sports-academy/logs/`
- **PM2 logs:** `~/.pm2/logs/`
- **Nginx logs:** `/var/log/nginx/`
- **System logs:** `/var/log/syslog`

### Useful Commands for Support
```bash
# System information
uname -a
lsb_release -a

# Application status
pm2 status
pm2 info parmanand-sports-academy

# Database status
sudo systemctl status postgresql
psql -U parmanand_user -d parmanand_sports -h localhost -c "SELECT version();"

# Network status
sudo netstat -tulpn | grep :3000
sudo netstat -tulpn | grep :80
sudo netstat -tulpn | grep :443
```

## 🎉 Success!

Once deployed successfully, your PSA-NASHIK Sports Academy will be:

- ✅ **Accessible at:** `https://yourdomain.com`
- ✅ **Secured with SSL**
- ✅ **Running in production mode**
- ✅ **Automatically backed up daily**
- ✅ **Monitored by PM2**
- ✅ **Protected by firewall**

**Default Admin Access:**
- **URL:** `https://yourdomain.com`
- **Username:** `admin@psa-nashik.com`
- **Password:** `admin123`

**⚠️ Important:** Change the default admin password immediately after first login!

## 💰 Estimated Costs

- **VPS Server:** $10-30/month (depending on specs)
- **Domain Name:** $10-15/year
- **SSL Certificate:** Free (Let's Encrypt)
- **Total:** ~$15-35/month

Your sports academy management system is now ready for production use! 🎊