#!/bin/bash

# PSA-NASHIK Production VPS Deployment Script
# This script deploys the application to a VPS server via SSH

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
APP_NAME="psa-nashik"
REPO_URL="https://github.com/r2w34/PSA-NASHIK.git"
DEPLOY_DIR="/var/www/psa-nashik"
SERVICE_NAME="psa-nashik"
PORT="3000"

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to check if SSH connection works
check_ssh_connection() {
    print_status "Testing SSH connection to $SSH_HOST..."
    if ssh -o ConnectTimeout=10 -o BatchMode=yes "$SSH_USER@$SSH_HOST" exit 2>/dev/null; then
        print_success "SSH connection successful"
        return 0
    else
        print_error "SSH connection failed"
        return 1
    fi
}

# Function to deploy to VPS
deploy_to_vps() {
    local ssh_host="$1"
    local ssh_user="$2"
    local ssh_key="$3"
    
    print_status "Starting deployment to VPS: $ssh_host"
    
    # SSH options
    SSH_OPTS="-o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null"
    if [ -n "$ssh_key" ]; then
        SSH_OPTS="$SSH_OPTS -i $ssh_key"
    fi
    
    # Create deployment script to run on VPS
    cat > /tmp/vps_deploy.sh << 'EOF'
#!/bin/bash
set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_status() { echo -e "${BLUE}[VPS]${NC} $1"; }
print_success() { echo -e "${GREEN}[VPS]${NC} $1"; }
print_error() { echo -e "${RED}[VPS]${NC} $1"; }

DEPLOY_DIR="/var/www/psa-nashik"
SERVICE_NAME="psa-nashik"
PORT="3000"

print_status "Starting VPS deployment process..."

# Update system packages
print_status "Updating system packages..."
sudo apt update && sudo apt upgrade -y

# Install required packages
print_status "Installing required packages..."
sudo apt install -y curl git nginx postgresql postgresql-contrib

# Install Node.js 18.x
print_status "Installing Node.js..."
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Install PM2 globally
print_status "Installing PM2..."
sudo npm install -g pm2

# Create application directory
print_status "Setting up application directory..."
sudo mkdir -p $DEPLOY_DIR
sudo chown -R $USER:$USER $DEPLOY_DIR

# Clone or update repository
if [ -d "$DEPLOY_DIR/.git" ]; then
    print_status "Updating existing repository..."
    cd $DEPLOY_DIR
    git fetch origin
    git reset --hard origin/main
else
    print_status "Cloning repository..."
    git clone https://github.com/r2w34/PSA-NASHIK.git $DEPLOY_DIR
    cd $DEPLOY_DIR
fi

# Install dependencies
print_status "Installing dependencies..."
npm install

# Build the application
print_status "Building application..."
npm run build

# Setup PostgreSQL database
print_status "Setting up PostgreSQL database..."
sudo -u postgres psql -c "CREATE DATABASE psa_nashik_prod;" 2>/dev/null || true
sudo -u postgres psql -c "CREATE USER psa_user WITH PASSWORD 'psa_password';" 2>/dev/null || true
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE psa_nashik_prod TO psa_user;" 2>/dev/null || true

# Create environment file
print_status "Creating environment configuration..."
cat > $DEPLOY_DIR/.env << 'ENVEOF'
NODE_ENV=production
PORT=3000
DATABASE_URL=postgresql://psa_user:psa_password@localhost:5432/psa_nashik_prod
SESSION_SECRET=your-super-secret-session-key-change-this-in-production
ENVEOF

# Run database migrations
print_status "Running database migrations..."
npm run db:push 2>/dev/null || true

# Create PM2 ecosystem file
print_status "Creating PM2 configuration..."
cat > $DEPLOY_DIR/ecosystem.config.js << 'PMEOF'
module.exports = {
  apps: [{
    name: 'psa-nashik',
    script: './dist/index.js',
    instances: 1,
    exec_mode: 'cluster',
    env: {
      NODE_ENV: 'production',
      PORT: 3000
    },
    error_file: './logs/err.log',
    out_file: './logs/out.log',
    log_file: './logs/combined.log',
    time: true
  }]
};
PMEOF

# Create logs directory
mkdir -p $DEPLOY_DIR/logs

# Stop existing PM2 process
print_status "Managing PM2 processes..."
pm2 stop $SERVICE_NAME 2>/dev/null || true
pm2 delete $SERVICE_NAME 2>/dev/null || true

# Start application with PM2
print_status "Starting application..."
pm2 start $DEPLOY_DIR/ecosystem.config.js
pm2 save
pm2 startup

# Configure Nginx
print_status "Configuring Nginx..."
sudo tee /etc/nginx/sites-available/psa-nashik > /dev/null << 'NGINXEOF'
server {
    listen 80;
    server_name _;

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
NGINXEOF

# Enable Nginx site
sudo ln -sf /etc/nginx/sites-available/psa-nashik /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t && sudo systemctl reload nginx

# Enable services
print_status "Enabling services..."
sudo systemctl enable nginx
sudo systemctl enable postgresql

print_success "Deployment completed successfully!"
print_status "Application is running on: http://$(curl -s ifconfig.me):80"
print_status "PM2 status:"
pm2 status
EOF

    # Copy deployment script to VPS and execute
    print_status "Copying deployment script to VPS..."
    scp $SSH_OPTS /tmp/vps_deploy.sh "$ssh_user@$ssh_host:/tmp/"
    
    print_status "Executing deployment on VPS..."
    ssh $SSH_OPTS "$ssh_user@$ssh_host" "chmod +x /tmp/vps_deploy.sh && /tmp/vps_deploy.sh"
    
    print_success "VPS deployment completed!"
    
    # Get server IP
    SERVER_IP=$(ssh $SSH_OPTS "$ssh_user@$ssh_host" "curl -s ifconfig.me" 2>/dev/null || echo "$ssh_host")
    
    print_success "🚀 Application deployed successfully!"
    echo ""
    echo "📋 Deployment Summary:"
    echo "  • Server: $ssh_host"
    echo "  • Application URL: http://$SERVER_IP"
    echo "  • Status: Running with PM2"
    echo "  • Database: PostgreSQL"
    echo "  • Web Server: Nginx"
    echo ""
    echo "🔧 Management Commands:"
    echo "  • Check status: ssh $ssh_user@$ssh_host 'pm2 status'"
    echo "  • View logs: ssh $ssh_user@$ssh_host 'pm2 logs psa-nashik'"
    echo "  • Restart app: ssh $ssh_user@$ssh_host 'pm2 restart psa-nashik'"
}

# Main deployment function
main() {
    echo "🚀 PSA-NASHIK VPS Deployment Script"
    echo "===================================="
    echo ""
    
    # Check if parameters are provided
    if [ $# -lt 2 ]; then
        echo "Usage: $0 <ssh_host> <ssh_user> [ssh_key_path]"
        echo ""
        echo "Examples:"
        echo "  $0 192.168.1.100 root"
        echo "  $0 myserver.com ubuntu ~/.ssh/id_rsa"
        echo ""
        exit 1
    fi
    
    SSH_HOST="$1"
    SSH_USER="$2"
    SSH_KEY="$3"
    
    print_status "Deployment Configuration:"
    echo "  • SSH Host: $SSH_HOST"
    echo "  • SSH User: $SSH_USER"
    echo "  • SSH Key: ${SSH_KEY:-"(using default)"}"
    echo ""
    
    # Test SSH connection
    export SSH_HOST SSH_USER
    if ! check_ssh_connection; then
        print_error "Cannot connect to VPS. Please check:"
        echo "  • SSH host and user are correct"
        echo "  • SSH key is properly configured"
        echo "  • Server is accessible"
        exit 1
    fi
    
    # Confirm deployment
    read -p "Continue with deployment? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        print_warning "Deployment cancelled"
        exit 0
    fi
    
    # Start deployment
    deploy_to_vps "$SSH_HOST" "$SSH_USER" "$SSH_KEY"
}

# Run main function with all arguments
main "$@"