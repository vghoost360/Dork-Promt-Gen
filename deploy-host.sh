#!/bin/bash
# Deploy Dork Generator on Docker Host
# Run this script on your Docker host

echo "🚀 Deploying Dork Search Generator..."

# Clone or pull latest
if [ -d "Dork-Promt-Gen" ]; then
    echo "📥 Pulling latest changes..."
    cd Dork-Promt-Gen
    git pull
else
    echo "📥 Cloning repository..."
    git clone https://github.com/vghoost360/Dork-Promt-Gen.git
    cd Dork-Promt-Gen
fi

# Create required directories
mkdir -p logs cache sessions

# Build and deploy
echo "🔨 Building and starting containers..."
docker-compose down
docker-compose up -d --build

# Show status
echo ""
echo "✅ Deployment complete!"
echo ""
echo "📊 Container status:"
docker-compose ps

echo ""
echo "🌐 Access your application at:"
echo "   http://$(hostname -I | awk '{print $1}'):580"
echo ""
echo "📝 View logs with: docker-compose logs -f"
