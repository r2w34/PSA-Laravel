#!/bin/bash

# PSA-NASHIK Sports Academy - VPS Deployment Script
# Run this script on your VPS server as a non-root user with sudo privileges

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_status() { echo -e "${BLUE}[INFO]${NC} $1"; }
print_success() { echo -e "${GREEN}[SUCCESS]${NC} $1"; }
print_warning() { echo -e "${YELLOW}[WARNING]${NC} $1"; }
print_error() { echo -e "${RED}[ERROR]${NC} $1"; }

# Configuration
APP_NAME="parmanand-sports-academy"
APP_USER="parmanand"
NODE_VERSION="20"

# Check if running as root
if [[ $EUID -eq 0 ]]; then
    print_error "This script should not be run as root for security reasons"
    print_status "Please run as a regular user with sudo privileges"
    exit 1
fi

# Welcome message
echo
print_status "=== PSA-NASHIK Sports Academy VPS Installer ==="
print_status "This script will install and configure your sports academy management system"
echo

# Get configuration from user
get_configuration() {
    print_status "Please provide the following information:"
    echo
    
    # Domain name
    read -p "Enter your domain name (e.g., sports.example.com): " DOMAIN_NAME
    while [[ -z "$DOMAIN_NAME" ]]; do
        print_error "Domain name is required"
        read -p "Enter your domain name: " DOMAIN_NAME
    done
    
    # Database password
    read -s -p "Enter a secure database password: " DB_PASSWORD
    echo
    while [[ -z "$DB_PASSWORD" ]]; do
        print_error "Database password is required"
        read -s -p "Enter a secure database password: " DB_PASSWORD
        echo
    done
    
    # Generate session secret
    SESSION_SECRET=$(openssl rand -base64 32 2>/dev/null || echo "fallback-secret-$(date +%s)")
    
    # Optional API keys
    echo
    print_status "Optional API Keys (press Enter to skip):"
    read -p "Google Gemini API Key (for AI features): " GEMINI_API_KEY
    read -p "WhatsApp API Key (for notifications): " WHATSAPP_API_KEY
    read -p "Stripe Secret Key (for payments): " STRIPE_SECRET_KEY
    read -p "Stripe Public Key: " STRIPE_PUBLIC_KEY
    
    echo
    print_success "Configuration collected successfully!"
}

# Update system packages
update_system() {
    print_status "Updating system packages..."
    sudo apt update && sudo apt upgrade -y
    sudo apt install -y curl wget git unzip software-properties-common build-essential
    print_success "System updated successfully"
}

# Install Node.js
install_nodejs() {
    print_status "Installing Node.js ${NODE_VERSION}..."
    curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | sudo -E bash -
    sudo apt-get install -y nodejs
    
    # Install global packages
    sudo npm install -g pm2 tsx typescript
    
    print_success "Node.js installed successfully"
    node --version
    npm --version
}

# Install PostgreSQL
install_postgresql() {
    print_status "Installing PostgreSQL..."
    sudo apt install -y postgresql postgresql-contrib
    
    # Start and enable PostgreSQL
    sudo systemctl start postgresql
    sudo systemctl enable postgresql
    
    print_success "PostgreSQL installed successfully"
}

# Setup database
setup_database() {
    print_status "Setting up database..."
    
    # Create database and user
    sudo -u postgres psql << EOF
CREATE DATABASE parmanand_sports;
CREATE USER parmanand_user WITH PASSWORD '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON DATABASE parmanand_sports TO parmanand_user;
ALTER USER parmanand_user CREATEDB;
\q
EOF
    
    print_success "Database setup completed"
}

# Clone and setup application
setup_application() {
    print_status "Setting up application..."
    
    # Create application directory
    APP_DIR="/home/$(whoami)/${APP_NAME}"
    
    # Clone repository (you'll need to replace this with your actual repo)
    if [ -d "$APP_DIR" ]; then
        print_warning "Application directory exists, updating..."
        cd "$APP_DIR"
        git pull origin main
    else
        print_status "Cloning application repository..."
        # For now, we'll create the directory and copy files
        mkdir -p "$APP_DIR"
        cd "$APP_DIR"
        
        # You would normally clone from your repository:
        # git clone https://github.com/your-username/parmanand-sports-academy.git .
        
        print_warning "Please upload your application files to $APP_DIR"
        print_status "Or clone from your repository:"
        print_status "git clone https://github.com/your-username/parmanand-sports-academy.git ."
    fi
    
    # Install dependencies and build (if package.json exists)
    if [ -f "package.json" ]; then
        print_status "Installing dependencies..."
        npm install
        
        print_status "Building application..."
        npm run build
    fi
    
    print_success "Application setup completed"
}

# Create environment file
create_environment() {
    print_status "Creating environment configuration..."
    
    cat > .env.production << EOF
# Database Configuration
DATABASE_URL=postgresql://parmanand_user:${DB_PASSWORD}@localhost:5432/parmanand_sports
PGHOST=localhost
PGPORT=5432
PGUSER=parmanand_user
PGPASSWORD=${DB_PASSWORD}
PGDATABASE=parmanand_sports

# Application Configuration
NODE_ENV=production
PORT=3000
SESSION_SECRET=${SESSION_SECRET}

# Domain Configuration
CORS_ORIGIN=https://${DOMAIN_NAME}
ALLOWED_ORIGINS=https://${DOMAIN_NAME},https://www.${DOMAIN_NAME}

# API Keys
GEMINI_API_KEY=${GEMINI_API_KEY}
WHATSAPP_API_KEY=${WHATSAPP_API_KEY}
STRIPE_SECRET_KEY=${STRIPE_SECRET_KEY}
VITE_STRIPE_PUBLIC_KEY=${STRIPE_PUBLIC_KEY}
EOF
    
    print_success "Environment configuration created"
}

# Install and configure Nginx
setup_nginx() {
    print_status "Installing and configuring Nginx..."
    
    sudo apt install -y nginx
    
    # Create Nginx configuration
    sudo tee /etc/nginx/sites-available/${APP_NAME} > /dev/null << EOF
server {
    listen 80;
    server_name ${DOMAIN_NAME} www.${DOMAIN_NAME};
    return 301 https://\$server_name\$request_uri;
}

server {
    listen 443 ssl http2;
    server_name ${DOMAIN_NAME} www.${DOMAIN_NAME};
    
    # SSL certificates (will be configured with Let's Encrypt)
    ssl_certificate /etc/letsencrypt/live/${DOMAIN_NAME}/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/${DOMAIN_NAME}/privkey.pem;
    
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
        proxy_set_header Upgrade \$http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_cache_bypass \$http_upgrade;
    }
}
EOF
    
    # Enable site
    sudo ln -sf /etc/nginx/sites-available/${APP_NAME} /etc/nginx/sites-enabled/
    sudo rm -f /etc/nginx/sites-enabled/default
    
    # Test configuration
    sudo nginx -t
    sudo systemctl restart nginx
    sudo systemctl enable nginx
    
    print_success "Nginx configured successfully"
}

# Setup SSL certificate
setup_ssl() {
    print_status "Setting up SSL certificate..."
    
    # Install Certbot
    sudo apt install -y certbot python3-certbot-nginx
    
    # Get SSL certificate
    print_status "Obtaining SSL certificate for ${DOMAIN_NAME}..."
    sudo certbot --nginx -d ${DOMAIN_NAME} -d www.${DOMAIN_NAME} --non-interactive --agree-tos --email admin@${DOMAIN_NAME}
    
    # Test automatic renewal
    sudo certbot renew --dry-run
    
    print_success "SSL certificate configured successfully"
}

# Setup PM2 and start application
setup_pm2() {
    print_status "Setting up PM2 process manager..."
    
    # Create PM2 ecosystem file
    cat > ecosystem.config.js << EOF
module.exports = {
  apps: [{
    name: '${APP_NAME}',
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
EOF
    
    # Create logs directory
    mkdir -p logs
    
    # Start application with PM2
    pm2 start ecosystem.config.js --env production
    pm2 save
    pm2 startup
    
    print_success "PM2 configured and application started"
}

# Setup firewall
setup_firewall() {
    print_status "Configuring firewall..."
    
    sudo ufw --force enable
    sudo ufw default deny incoming
    sudo ufw default allow outgoing
    sudo ufw allow ssh
    sudo ufw allow 'Nginx Full'
    
    print_success "Firewall configured successfully"
}

# Create backup script
setup_backup() {
    print_status "Setting up automated backups..."
    
    cat > ~/backup-db.sh << 'EOF'
#!/bin/bash
BACKUP_DIR="/home/$(whoami)/backups"
DATE=$(date +"%Y%m%d_%H%M%S")
DB_NAME="parmanand_sports"
DB_USER="parmanand_user"

mkdir -p $BACKUP_DIR
pg_dump -U $DB_USER -h localhost $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql
find $BACKUP_DIR -name "db_backup_*.sql" -type f -mtime +7 -delete

echo "Database backup completed: $BACKUP_DIR/db_backup_$DATE.sql"
EOF
    
    chmod +x ~/backup-db.sh
    
    # Add to crontab
    (crontab -l 2>/dev/null; echo "0 2 * * * /home/$(whoami)/backup-db.sh") | crontab -
    
    print_success "Backup system configured"
}

# Main installation function
main() {
    print_status "Starting PSA-NASHIK Sports Academy installation..."
    
    get_configuration
    update_system
    install_nodejs
    install_postgresql
    setup_database
    setup_application
    create_environment
    setup_nginx
    setup_ssl
    setup_pm2
    setup_firewall
    setup_backup
    
    echo
    print_success "=== Installation Complete! ==="
    echo
    print_status "Your PSA-NASHIK Sports Academy is now running at:"
    print_success "https://${DOMAIN_NAME}"
    echo
    print_status "Admin Panel Access:"
    print_status "- URL: https://${DOMAIN_NAME}"
    print_status "- Default Admin: admin@psa-nashik.com"
    print_status "- Default Password: admin123"
    echo
    print_warning "Important Next Steps:"
    print_status "1. Change the default admin password"
    print_status "2. Configure your API keys in the admin panel"
    print_status "3. Add your sports, coaches, and students"
    print_status "4. Test all functionality"
    echo
    print_status "Useful Commands:"
    print_status "- Check application status: pm2 status"
    print_status "- View logs: pm2 logs"
    print_status "- Restart application: pm2 restart ${APP_NAME}"
    print_status "- Manual backup: ~/backup-db.sh"
    echo
    print_success "Deployment completed successfully!"
}

# Run main function
main "$@"