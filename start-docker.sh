#!/bin/bash

# Start the application with Docker Compose
echo "🚀 Starting Parmanand Sports Academy with Docker Compose..."

# Check if .env file exists
if [ ! -f .env ]; then
  echo "⚠️ .env file not found. Creating a sample .env file..."
  cp .env.production .env
  echo "✅ Created .env file. Please edit it with your actual values."
fi

# Build and start the containers
echo "🔧 Building and starting containers..."
docker-compose up -d

# Check if containers are running
echo "🔍 Checking container status..."
docker-compose ps

echo "✅ Application started successfully!"
echo "📊 Dashboard: http://localhost"
echo "🔍 Health check: http://localhost/api/health"
echo "📝 Logs: docker-compose logs -f"
echo "🛑 Stop: docker-compose down"