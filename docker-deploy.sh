#!/bin/bash

# Docker Deployment Script for Dork Search Generator
echo "🐳 Docker Deployment for Dork Search Generator"

# Configuration
CONTAINER_NAME="dork-search-generator"
IMAGE_NAME="dork-generator"
DOMAIN="localhost"
PORT="80"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    print_error "Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    print_warning "Docker Compose not found. Trying docker compose..."
    if ! docker compose version &> /dev/null; then
        print_error "Docker Compose is not available. Please install Docker Compose."
        exit 1
    fi
    COMPOSE_CMD="docker compose"
else
    COMPOSE_CMD="docker-compose"
fi

print_status "Docker and Docker Compose are available"

# Function to show usage
show_usage() {
    echo "Usage: $0 [COMMAND] [OPTIONS]"
    echo ""
    echo "Commands:"
    echo "  build     Build the Docker image"
    echo "  start     Start the containers"
    echo "  stop      Stop the containers"
    echo "  restart   Restart the containers"
    echo "  logs      Show container logs"
    echo "  shell     Open shell in container"
    echo "  clean     Remove containers and images"
    echo "  status    Show container status"
    echo "  deploy    Full deployment (build + start)"
    echo ""
    echo "Options:"
    echo "  -d, --domain DOMAIN   Set domain name (default: localhost)"
    echo "  -p, --port PORT       Set port (default: 80)"
    echo "  -h, --help           Show this help"
}

# Parse command line arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        -d|--domain)
            DOMAIN="$2"
            shift 2
            ;;
        -p|--port)
            PORT="$2"
            shift 2
            ;;
        -h|--help)
            show_usage
            exit 0
            ;;
        build|start|stop|restart|logs|shell|clean|status|deploy)
            COMMAND="$1"
            shift
            ;;
        *)
            echo "Unknown option: $1"
            show_usage
            exit 1
            ;;
    esac
done

# Default command
if [ -z "$COMMAND" ]; then
    COMMAND="deploy"
fi

# Create necessary directories
create_directories() {
    print_info "Creating necessary directories..."
    mkdir -p logs cache sessions
    chmod 755 logs cache sessions
    print_status "Directories created"
}

# Build Docker image
build_image() {
    print_info "Building Docker image..."
    if docker build -t $IMAGE_NAME .; then
        print_status "Docker image built successfully"
    else
        print_error "Failed to build Docker image"
        exit 1
    fi
}

# Start containers
start_containers() {
    print_info "Starting containers..."
    create_directories
    
    # Update docker-compose.yml with custom domain and port
    if [ "$DOMAIN" != "localhost" ] || [ "$PORT" != "80" ]; then
        print_info "Updating configuration for domain: $DOMAIN, port: $PORT"
        # Create a temporary docker-compose override
        cat > docker-compose.override.yml << EOF
services:
  dork-generator:
    ports:
      - "$PORT:80"
    environment:
      - VIRTUAL_HOST=$DOMAIN
      - LETSENCRYPT_HOST=$DOMAIN
EOF
    fi
    
    if $COMPOSE_CMD up -d; then
        print_status "Containers started successfully"
        
        # Wait for container to be healthy
        print_info "Waiting for container to be ready..."
        for i in {1..30}; do
            if docker exec $CONTAINER_NAME curl -f http://localhost/health.php >/dev/null 2>&1; then
                print_status "Container is healthy and ready!"
                break
            fi
            sleep 2
            echo -n "."
        done
        echo ""
        
        print_status "🌐 Dork Generator is available at:"
        print_info "   http://$DOMAIN:$PORT"
        if [ "$DOMAIN" != "localhost" ]; then
            print_info "   http://$(curl -s ifconfig.me 2>/dev/null || hostname -I | awk '{print $1}'):$PORT"
        fi
        print_info "   Health check: http://$DOMAIN:$PORT/health.php"
        
    else
        print_error "Failed to start containers"
        exit 1
    fi
}

# Stop containers
stop_containers() {
    print_info "Stopping containers..."
    if $COMPOSE_CMD down; then
        print_status "Containers stopped successfully"
    else
        print_error "Failed to stop containers"
        exit 1
    fi
}

# Show logs
show_logs() {
    print_info "Showing container logs..."
    $COMPOSE_CMD logs -f
}

# Open shell in container
open_shell() {
    print_info "Opening shell in container..."
    docker exec -it $CONTAINER_NAME /bin/sh
}

# Clean up
clean_up() {
    print_warning "This will remove all containers, images, and volumes. Are you sure? (y/N)"
    read -r response
    if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
        print_info "Cleaning up..."
        $COMPOSE_CMD down -v --rmi all
        docker system prune -f
        rm -f docker-compose.override.yml
        print_status "Cleanup completed"
    else
        print_info "Cleanup cancelled"
    fi
}

# Show status
show_status() {
    print_info "Container status:"
    docker ps -a --filter "name=$CONTAINER_NAME"
    echo ""
    
    if docker ps --filter "name=$CONTAINER_NAME" --filter "status=running" | grep -q $CONTAINER_NAME; then
        print_status "Container is running"
        
        # Show resource usage
        print_info "Resource usage:"
        docker stats --no-stream --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.NetIO}}" $CONTAINER_NAME
        
        # Test health endpoint
        if docker exec $CONTAINER_NAME curl -f http://localhost/health.php >/dev/null 2>&1; then
            print_status "Health check: PASSED"
        else
            print_error "Health check: FAILED"
        fi
    else
        print_warning "Container is not running"
    fi
}

# Execute command
case $COMMAND in
    build)
        build_image
        ;;
    start)
        start_containers
        ;;
    stop)
        stop_containers
        ;;
    restart)
        stop_containers
        start_containers
        ;;
    logs)
        show_logs
        ;;
    shell)
        open_shell
        ;;
    clean)
        clean_up
        ;;
    status)
        show_status
        ;;
    deploy)
        build_image
        start_containers
        ;;
    *)
        print_error "Unknown command: $COMMAND"
        show_usage
        exit 1
        ;;
esac

print_status "Operation completed successfully!"

# Security reminder
echo ""
print_warning "Security Reminders:"
print_info "• Change default passwords if using databases"
print_info "• Use HTTPS in production (configure SSL certificates)"
print_info "• Monitor logs regularly: docker logs $CONTAINER_NAME"
print_info "• Keep Docker images updated"
print_info "• Use this tool responsibly and ethically"
