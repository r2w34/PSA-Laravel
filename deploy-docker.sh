#!/bin/bash

# PSA Nashik Docker Deployment Script
# This script deploys the PSA Nashik application using Docker Compose

set -e

echo "🚀 Starting PSA Nashik Docker Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

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

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    print_error "Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    print_error "Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

# Create environment file if it doesn't exist
if [ ! -f .env ]; then
    print_status "Creating .env file from template..."
    cat > .env << EOF
# PSA Nashik Production Environment
NODE_ENV=production
PORT=5000

# Database Configuration
DB_PASSWORD=psa_secure_password_$(date +%s)
DATABASE_URL=postgresql://parmanand_user:\${DB_PASSWORD}@db:5432/parmanand_sports

# Session Configuration
SESSION_SECRET=psa_session_secret_$(openssl rand -hex 32)

# Optional API Keys (add your own)
GEMINI_API_KEY=
STRIPE_SECRET_KEY=
VITE_STRIPE_PUBLIC_KEY=
WHATSAPP_API_KEY=
RAZORPAY_KEY_ID=
RAZORPAY_KEY_SECRET=
PAYPAL_CLIENT_ID=
PAYPAL_CLIENT_SECRET=
EOF
    print_success "Created .env file with secure defaults"
else
    print_status "Using existing .env file"
fi

# Build the application
print_status "Building the application..."
npm run build

# Stop existing containers
print_status "Stopping existing containers..."
docker-compose down --remove-orphans

# Remove old images to ensure fresh build
print_status "Removing old images..."
docker-compose build --no-cache

# Start the services
print_status "Starting services..."
docker-compose up -d

# Wait for services to be ready
print_status "Waiting for services to start..."
sleep 10

# Check if services are running
if docker-compose ps | grep -q "Up"; then
    print_success "Services are running!"
    
    # Show running containers
    echo ""
    print_status "Running containers:"
    docker-compose ps
    
    # Show application URL
    echo ""
    print_success "🎉 PSA Nashik is now deployed!"
    print_success "📱 Application URL: http://localhost"
    print_success "🗄️  Database: PostgreSQL on port 5432"
    print_success "🔄 Redis: Available on port 6379"
    
    echo ""
    print_status "To view logs: docker-compose logs -f"
    print_status "To stop: docker-compose down"
    print_status "To restart: docker-compose restart"
    
else
    print_error "Some services failed to start. Check logs with: docker-compose logs"
    exit 1
fi

echo ""
print_success "Deployment completed successfully! 🚀"