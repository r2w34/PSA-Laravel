# Deploy PSA-NASHIK to Your VPS Server

## Quick Deployment Options

### Option 1: One-Line Installation (Recommended)
```bash
# On your VPS server, run as non-root user:
curl -fsSL https://raw.githubusercontent.com/your-repo/main/install.sh | bash
```

### Option 2: Manual Step-by-Step Deployment
Follow the detailed steps below for complete control over the deployment process.

## Prerequisites

### VPS Requirements
- **OS**: Ubuntu 22.04 LTS (recommended)
- **RAM**: Minimum 4GB (8GB recommended)
- **CPU**: 2+ vCPUs
- **Storage**: 50GB+ SSD
- **Network**: Good internet connection

### Before You Start
1. **Domain Setup**: Point your domain's A record to your VPS IP
2. **SSH Access**: Ensure you can SSH into your VPS
3. **Non-root User**: Create a non-root user with sudo privileges

## Step-by-Step Manual Deployment

### Step 1: Connect to Your VPS
```bash
# SSH into your VPS
ssh your-username@your-server-ip

# Or if using a domain:
ssh your-username@yourdomain.com
```

### Step 2: System Preparation
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install essential packages
sudo apt install -y curl wget git unzip software-properties-common build-essential

# Create application user (if not exists)
sudo adduser parmanand
sudo usermod -aG sudo parmanand
su - parmanand
```

### Step 3: Install Node.js 20
```bash
# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install global packages
sudo npm install -g pm2 tsx typescript

# Verify installation
node --version
npm --version
```

### Step 4: Install PostgreSQL
```bash
# Install PostgreSQL
sudo apt install -y postgresql postgresql-contrib

# Start PostgreSQL service
sudo systemctl start postgresql
sudo systemctl enable postgresql

# Create database and user
sudo -u postgres psql
```

```sql
-- In PostgreSQL prompt:
CREATE DATABASE parmanand_sports;
CREATE USER parmanand_user WITH PASSWORD 'your_secure_password_here';
GRANT ALL PRIVILEGES ON DATABASE parmanand_sports TO parmanand_user;
ALTER USER parmanand_user CREATEDB;
\q
```

### Step 5: Clone and Setup Application
```bash
# Clone the repository (replace with your actual repo URL)
git clone https://github.com/your-username/parmanand-sports-academy.git
cd parmanand-sports-academy

# Install dependencies
npm install

# Build the application
npm run build
```

### Step 6: Environment Configuration
```bash
# Create production environment file
cp .env.example .env.production

# Edit the environment file
nano .env.production
```

**Environment Variables (.env.production):**
```env
# Database Configuration
DATABASE_URL=postgresql://parmanand_user:your_secure_password_here@localhost:5432/parmanand_sports
PGHOST=localhost
PGPORT=5432
PGUSER=parmanand_user
PGPASSWORD=your_secure_password_here
PGDATABASE=parmanand_sports

# Application Configuration
NODE_ENV=production
PORT=3000
SESSION_SECRET=your_very_secure_session_secret_here

# Domain Configuration
CORS_ORIGIN=https://yourdomain.com
ALLOWED_ORIGINS=https://yourdomain.com,https://www.yourdomain.com

# Optional API Keys (add if you have them)
GEMINI_API_KEY=your_gemini_api_key
WHATSAPP_API_KEY=your_whatsapp_api_key
STRIPE_SECRET_KEY=your_stripe_secret_key
VITE_STRIPE_PUBLIC_KEY=your_stripe_public_key
```

### Step 7: Database Migration
```bash
# Deploy database schema
npm run db:push

# Create admin user (optional)
npm run create-admin
```

### Step 8: Install and Configure Nginx
```bash
# Install Nginx
sudo apt install -y nginx

# Create site configuration
sudo nano /etc/nginx/sites-available/parmanand-sports
```

**Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    
    # SSL certificates (will be configured with Let's Encrypt)
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubdomains" always;
    
    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
    
    # Proxy to Node.js application
    location / {
        proxy_pass http://localhost:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_cache_bypass $http_upgrade;
    }
}
```

```bash
# Enable the site
sudo ln -s /etc/nginx/sites-available/parmanand-sports /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### Step 9: SSL Certificate Setup
```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Get SSL certificate (replace yourdomain.com with your actual domain)
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Test automatic renewal
sudo certbot renew --dry-run
```

### Step 10: Start Application with PM2
```bash
# Create PM2 ecosystem file
nano ecosystem.config.js
```

```javascript
module.exports = {
  apps: [{
    name: 'parmanand-sports-academy',
    script: 'dist/index.js',
    env: {
      NODE_ENV: 'development'
    },
    env_production: {
      NODE_ENV: 'production',
      PORT: 3000
    },
    instances: 'max',
    exec_mode: 'cluster',
    watch: false,
    max_memory_restart: '1G',
    error_file: 'logs/err.log',
    out_file: 'logs/out.log',
    log_file: 'logs/combined.log',
    time: true
  }]
};
```

```bash
# Create logs directory
mkdir -p logs

# Start application
pm2 start ecosystem.config.js --env production

# Save PM2 configuration
pm2 save
pm2 startup

# Check status
pm2 status
```

### Step 11: Configure Firewall
```bash
# Setup UFW firewall
sudo ufw enable
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw status
```

## Verification Steps

After deployment, verify everything is working:

1. **Check Application Status:**
   ```bash
   pm2 status
   pm2 logs
   ```

2. **Test Database Connection:**
   ```bash
   curl http://localhost:3000/api/health
   ```

3. **Test HTTPS:**
   ```bash
   curl https://yourdomain.com/api/health
   ```

4. **Access Admin Panel:**
   - Go to https://yourdomain.com
   - Login with admin credentials

## Troubleshooting

### Common Issues:

1. **Application won't start:**
   ```bash
   pm2 logs
   # Check for database connection errors
   ```

2. **Database connection failed:**
   ```bash
   sudo systemctl status postgresql
   # Verify database credentials in .env.production
   ```

3. **SSL certificate issues:**
   ```bash
   sudo certbot certificates
   sudo nginx -t
   ```

4. **Port conflicts:**
   ```bash
   sudo netstat -tulpn | grep :3000
   ```

## Backup Setup

Create automated backups:

```bash
# Create backup script
nano ~/backup-db.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/home/parmanand/backups"
DATE=$(date +"%Y%m%d_%H%M%S")
DB_NAME="parmanand_sports"
DB_USER="parmanand_user"

mkdir -p $BACKUP_DIR
pg_dump -U $DB_USER -h localhost $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql
find $BACKUP_DIR -name "db_backup_*.sql" -type f -mtime +7 -delete

echo "Database backup completed: $BACKUP_DIR/db_backup_$DATE.sql"
```

```bash
chmod +x ~/backup-db.sh

# Add to crontab for daily backups at 2 AM
crontab -e
# Add: 0 2 * * * /home/parmanand/backup-db.sh
```

## Post-Deployment

1. **Update DNS:** Ensure your domain points to the VPS IP
2. **Test all features:** Login, student management, payments, etc.
3. **Configure API keys:** Add Gemini, WhatsApp, Stripe keys as needed
4. **Set up monitoring:** Consider adding monitoring tools
5. **Regular updates:** Keep system and application updated

## Support

If you encounter issues:
1. Check PM2 logs: `pm2 logs`
2. Check Nginx logs: `sudo tail -f /var/log/nginx/error.log`
3. Check system logs: `sudo journalctl -f`

Your PSA-NASHIK Sports Academy is now ready for production use!