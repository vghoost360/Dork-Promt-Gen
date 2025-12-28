# Docker Deployment Guide

This guide explains how to deploy the Dork Search Generator using Docker containers.

## 📋 Prerequisites

- Docker Engine 20.10+
- Docker Compose 2.0+ (or legacy docker-compose 1.29+)
- 2GB+ RAM recommended
- Port 80 (and optionally 443 for HTTPS) available

## 🚀 Quick Start

### 1. Portainer Deployment (Recommended for GUI Management)

#### Method 1: Using Portainer Stacks (Easiest)
1. **Access Portainer** at `http://your-server:9000`
2. **Navigate to Stacks** → Click "Add Stack"
3. **Name your stack**: `dork-generator`
4. **Paste the docker-compose.yml content** or use Git repository
5. Click **"Deploy the stack"**
6. Access the application at `http://your-server`

#### Method 2: Using Portainer with Git Repository
1. In Portainer, go to **Stacks** → **Add Stack**
2. Choose **"Repository"** as build method
3. Enter repository details:
   - **Repository URL**: Your Git repository URL
   - **Repository reference**: `main` or `master`
   - **Compose path**: `docker-compose.yml`
4. Click **"Deploy the stack"**

#### Portainer Stack Configuration
When deploying in Portainer, use this stack configuration:

```yaml
version: '3.8'

services:
  dork-generator:
    image: dork-search-generator:latest
    build: 
      context: .
      dockerfile: Dockerfile
    container_name: dork-search-generator
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - dork-logs:/var/www/html/logs
      - dork-cache:/var/www/html/cache
      - dork-sessions:/var/www/html/sessions
    environment:
      - PHP_MEMORY_LIMIT=256M
      - PHP_MAX_EXECUTION_TIME=300
      - NGINX_WORKER_CONNECTIONS=1024
    healthcheck:
      test: ["CMD", "curl", "-f", "http://localhost/"]
      interval: 30s
      timeout: 10s
      retries: 3
      start_period: 40s
    networks:
      - dork-network

networks:
  dork-network:
    driver: bridge

volumes:
  dork-logs:
  dork-cache:
  dork-sessions:
```

#### Managing in Portainer
- **View Logs**: Stacks → dork-generator → Container → Logs
- **Update Stack**: Stacks → dork-generator → Editor → Update
- **Restart**: Stacks → dork-generator → Stop/Start buttons
- **Console Access**: Containers → dork-search-generator → Console

### 2. Command Line Deployment

#### One-Command Deployment
```bash
# Make script executable and deploy
chmod +x docker-deploy.sh
./docker-deploy.sh deploy
```

#### Manual Docker Compose
```bash
# Build and start
docker-compose up -d --build

# Check status
docker-compose ps

# View logs
docker-compose logs -f
```

### 3. Custom Domain/Port
```bash
# Deploy with custom domain and port
./docker-deploy.sh deploy --domain example.com --port 8080
```

## 🐳 Portainer Deployment Guide

### Prerequisites
- Portainer CE or EE installed and running
- Access to Portainer web interface (typically port 9000 or 9443)
- Docker environment connected to Portainer

### Step-by-Step Portainer Deployment

#### Step 1: Prepare Your Repository
Make sure your `docker-compose.yml` is ready for Portainer. Use named volumes for better management:

```yaml
services:
  dork-generator:
    image: dork-search-generator:latest
    build: 
      context: .
      dockerfile: Dockerfile
    container_name: dork-search-generator
    restart: unless-stopped
    ports:
      - "8080:80"  # Change port if 80 is in use
    volumes:
      - dork-logs:/var/www/html/logs
      - dork-cache:/var/www/html/cache
      - dork-sessions:/var/www/html/sessions
    environment:
      - PHP_MEMORY_LIMIT=256M
      - PHP_MAX_EXECUTION_TIME=300
      - NGINX_WORKER_CONNECTIONS=1024
    healthcheck:
      test: ["CMD", "curl", "-f", "http://localhost/"]
      interval: 30s
      timeout: 10s
      retries: 3
    networks:
      - dork-network

networks:
  dork-network:
    driver: bridge

volumes:
  dork-logs:
  dork-cache:
  dork-sessions:
```

#### Step 2: Deploy via Portainer Stacks

1. **Login to Portainer**
   - Navigate to `http://your-server:9000`
   - Enter your credentials

2. **Select Environment**
   - Choose your Docker environment (local or remote)

3. **Create New Stack**
   - Click **"Stacks"** in the left sidebar
   - Click **"+ Add stack"** button

4. **Configure Stack**
   - **Name**: `dork-generator`
   - **Build method**: Choose one:
     - **Web editor**: Copy/paste the docker-compose.yml content
     - **Upload**: Upload your docker-compose.yml file
     - **Repository**: Connect to Git repository

5. **Environment Variables** (Optional)
   Add custom environment variables:
   ```
   PHP_MEMORY_LIMIT=512M
   CUSTOM_PORT=8080
   ```

6. **Deploy**
   - Click **"Deploy the stack"**
   - Wait for build and deployment to complete

#### Step 3: Using Git Repository in Portainer

For automatic updates from Git:

1. **Choose Repository Build Method**
2. **Enter Repository Details**:
   ```
   Repository URL: https://github.com/yourusername/dork-search-generator
   Repository reference: refs/heads/main
   Compose path: docker-compose.yml
   ```

3. **Authentication** (if private repo):
   - Add Git credentials in Portainer
   - Or use SSH key authentication

4. **Enable Auto-Updates** (Optional):
   - Enable webhook for automatic redeployment
   - Configure webhook in your Git provider

#### Step 4: Verify Deployment

1. **Check Container Status**
   - Go to **Containers** in Portainer
   - Look for `dork-search-generator`
   - Status should be **"running"** with green indicator

2. **View Logs**
   - Click on container name
   - Click **"Logs"** tab
   - Check for any errors

3. **Access Application**
   - Open `http://your-server:8080` (or your configured port)
   - Application should load successfully

### Managing Stack in Portainer

#### Update Application
1. **Go to Stacks** → `dork-generator`
2. Click **"Editor"** tab
3. Modify configuration if needed
4. Click **"Update the stack"**
5. Select options:
   - ☑ **Pull latest images**
   - ☑ **Re-deploy**

#### View Container Logs
1. **Stacks** → `dork-generator`
2. Click on container name
3. **Logs** tab → View real-time logs
4. Use filters: errors, warnings, info

#### Access Container Console
1. **Containers** → `dork-search-generator`
2. Click **"Console"** 
3. Choose shell: `/bin/sh`
4. Click **"Connect"**

#### Restart Services
- **Quick Restart**: Container list → Click restart icon
- **Full Restart**: Stacks → `dork-generator` → **Stop** then **Start**

#### Stop/Remove Stack
- **Stop**: Stacks → `dork-generator` → **Stop**
- **Remove**: Stacks → `dork-generator` → **Delete** (⚠️ removes containers and networks)

### Portainer Advanced Configuration

#### Custom Network Configuration
```yaml
networks:
  dork-network:
    driver: bridge
    ipam:
      config:
        - subnet: 172.28.0.0/16
```

#### Resource Limits in Portainer
Edit stack and add:
```yaml
services:
  dork-generator:
    deploy:
      resources:
        limits:
          cpus: '1.0'
          memory: 512M
        reservations:
          cpus: '0.5'
          memory: 256M
```

#### Volume Management
- **View Volumes**: Portainer → **Volumes**
- **Backup Volume**: Select volume → **Export**
- **Browse Files**: Volume → **Browse** button

#### Webhook for Auto-Deploy
1. **Stack** → `dork-generator` → Copy webhook URL
2. Add to GitHub/GitLab webhook settings
3. Push to repository triggers auto-redeploy

### Portainer with Reverse Proxy

#### Using Traefik with Portainer
```yaml
services:
  dork-generator:
    labels:
      - "traefik.enable=true"
      - "traefik.http.routers.dork.rule=Host(`dork.yourdomain.com`)"
      - "traefik.http.routers.dork.entrypoints=websecure"
      - "traefik.http.routers.dork.tls.certresolver=letsencrypt"
      - "traefik.http.services.dork.loadbalancer.server.port=80"
```

#### Using Nginx Proxy Manager
1. Deploy via Portainer as normal
2. In Nginx Proxy Manager, add proxy host:
   - **Domain**: `dork.yourdomain.com`
   - **Forward**: `dork-search-generator:80`
   - Enable SSL with Let's Encrypt

### Portainer Troubleshooting

#### Stack Won't Deploy
- Check **Logs** tab during deployment
- Verify port availability
- Check volume permissions
- Validate YAML syntax

#### Container Health Check Fails
- View container logs
- Access container console
- Test manually: `curl http://localhost/`

#### Permission Issues
Create init container:
```yaml
volumes:
  - type: volume
    source: dork-logs
    target: /var/www/html/logs
    volume:
      nocopy: false
```

#### Port Already in Use
Change port mapping in stack:
```yaml
ports:
  - "8080:80"  # Changed from 80:80
```

### Portainer Backup & Restore

#### Backup Stack Configuration
1. **Stacks** → `dork-generator` → **Editor**
2. Copy entire YAML content
3. Save to file: `dork-generator-stack.yml`

#### Export Volumes
```bash
# Using Portainer console or SSH
docker run --rm -v dork-logs:/data -v $(pwd):/backup alpine \
  tar czf /backup/dork-logs-backup.tar.gz -C /data .
```

#### Restore from Backup
1. Create new stack with same configuration
2. Deploy stack (creates volumes)
3. Stop container
4. Restore volume data
5. Start container

## 🏗️ Architecture

### Container Structure
```
┌─────────────────────────────────────┐
│           Docker Container          │
├─────────────────────────────────────┤
│  Supervisor (Process Manager)       │
├─────────────────┬───────────────────┤
│     Nginx       │    PHP-FPM 8.2    │
│   (Web Server)  │  (PHP Processor)   │
├─────────────────┴───────────────────┤
│        Application Files            │
│  • index.php    • data/             │
│  • config.php   • logs/             │
│  • styles.css   • cache/            │
│  • script.js    • sessions/         │
└─────────────────────────────────────┘
```

### Volumes
- `./logs:/var/www/html/logs` - Application logs
- `./cache:/var/www/html/cache` - Cache files
- `./sessions:/var/www/html/sessions` - PHP sessions

## 🛠️ Available Commands

### Docker Deploy Script
```bash
./docker-deploy.sh [COMMAND] [OPTIONS]
```

**Commands:**
- `build` - Build the Docker image
- `start` - Start containers
- `stop` - Stop containers
- `restart` - Restart containers
- `logs` - Show container logs
- `shell` - Open shell in container
- `clean` - Remove containers and images
- `status` - Show container status
- `deploy` - Full deployment (build + start)

**Options:**
- `-d, --domain DOMAIN` - Set domain name
- `-p, --port PORT` - Set port
- `-h, --help` - Show help

### Docker Compose Commands
```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f dork-generator

# Update and restart
docker-compose down && docker-compose up -d --build

# Execute commands in container
docker-compose exec dork-generator sh
```

## 🔧 Configuration

### Environment Variables
Create `.env` file for custom configuration:
```bash
# Application settings
APP_ENV=production
APP_DEBUG=false

# PHP settings
PHP_MEMORY_LIMIT=256M
PHP_MAX_EXECUTION_TIME=300

# Nginx settings
NGINX_WORKER_CONNECTIONS=1024
```

### Custom Nginx Configuration
To override Nginx settings, modify `docker/nginx.conf`:
```nginx
# Example: Increase rate limits
limit_req_zone $binary_remote_addr zone=api:10m rate=30r/m;

# Example: Add custom headers
add_header X-Custom-Header "My Value" always;
```

### Custom PHP Configuration
Modify `docker/php.ini` for PHP settings:
```ini
# Increase memory limit
memory_limit = 512M

# Change timezone
date.timezone = Europe/London

# Custom error reporting
error_reporting = E_ALL & ~E_NOTICE
```

## 🔒 HTTPS/SSL Setup

### Option 1: Let's Encrypt with Traefik
```yaml
# Add to docker-compose.yml
services:
  traefik:
    image: traefik:v2.9
    command:
      - "--api.insecure=true"
      - "--providers.docker=true"
      - "--entrypoints.websecure.address=:443"
      - "--certificatesresolvers.myresolver.acme.httpchallenge=true"
      - "--certificatesresolvers.myresolver.acme.httpchallenge.entrypoint=web"
      - "--certificatesresolvers.myresolver.acme.email=your-email@example.com"
      - "--certificatesresolvers.myresolver.acme.storage=/letsencrypt/acme.json"
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - "/var/run/docker.sock:/var/run/docker.sock:ro"
      - "./letsencrypt:/letsencrypt"
```

### Option 2: Custom SSL Certificates
```bash
# Mount SSL certificates
volumes:
  - ./ssl/cert.pem:/etc/ssl/certs/cert.pem:ro
  - ./ssl/private.key:/etc/ssl/private/private.key:ro
```

Then update `docker/nginx.conf`:
```nginx
server {
    listen 443 ssl http2;
    ssl_certificate /etc/ssl/certs/cert.pem;
    ssl_certificate_key /etc/ssl/private/private.key;
    # ... rest of configuration
}
```

## 📊 Monitoring & Logging

### Container Logs
```bash
# Application logs
docker-compose logs -f dork-generator

# Nginx access logs
docker exec dork-search-generator tail -f /var/log/nginx/access.log

# PHP-FPM logs
docker exec dork-search-generator tail -f /var/www/html/logs/php-fpm-access.log
```

### Health Checks
```bash
# Container health
docker inspect dork-search-generator | grep -A 10 Health

# Application health
curl http://localhost/health.php

# Detailed status
./docker-deploy.sh status
```

### Performance Monitoring
```bash
# Resource usage
docker stats dork-search-generator

# Process monitoring
docker exec dork-search-generator ps aux

# Disk usage
docker exec dork-search-generator df -h
```

## 🔄 Updates & Maintenance

### Update Application
```bash
# Pull latest code
git pull origin main

# Rebuild and restart
./docker-deploy.sh restart
```

### Update Base Images
```bash
# Pull latest base images
docker-compose pull

# Rebuild with updated base
docker-compose up -d --build
```

### Backup Data
```bash
# Backup logs and sessions
tar -czf backup-$(date +%Y%m%d).tar.gz logs cache sessions

# Backup entire application
docker commit dork-search-generator dork-generator-backup:$(date +%Y%m%d)
```

## 🐛 Troubleshooting

### Common Issues

#### Container Won't Start
```bash
# Check logs
docker-compose logs dork-generator

# Check configuration
docker-compose config

# Verify port availability
netstat -tulpn | grep :80
```

#### Permission Issues
```bash
# Fix volume permissions
sudo chown -R 1000:1000 logs cache sessions

# Or use different user in Dockerfile
USER 1000:1000
```

#### Memory Issues
```bash
# Increase container memory limit
docker-compose.yml:
  deploy:
    resources:
      limits:
        memory: 512M
```

#### Health Check Failures
```bash
# Check container health
docker exec dork-search-generator curl -f http://localhost/health.php

# Check Nginx status
docker exec dork-search-generator nginx -t

# Check PHP-FPM status
docker exec dork-search-generator ps aux | grep php-fpm
```

### Debug Mode
```bash
# Run with debug output
docker-compose up --build

# Interactive shell
docker run -it --rm dork-generator sh

# Check file permissions
docker exec dork-search-generator ls -la /var/www/html/
```

## 🚀 Production Deployment

### Docker Swarm
```bash
# Initialize swarm
docker swarm init

# Deploy stack
docker stack deploy -c docker-compose.yml dork-stack
```

### Kubernetes
```yaml
# Example deployment
apiVersion: apps/v1
kind: Deployment
metadata:
  name: dork-generator
spec:
  replicas: 3
  selector:
    matchLabels:
      app: dork-generator
  template:
    metadata:
      labels:
        app: dork-generator
    spec:
      containers:
      - name: dork-generator
        image: dork-generator:latest
        ports:
        - containerPort: 80
```

### Load Balancing
```bash
# Scale with Docker Compose
docker-compose up -d --scale dork-generator=3

# Use with Nginx load balancer
upstream dork_backend {
    server dork-generator_1:80;
    server dork-generator_2:80;
    server dork-generator_3:80;
}
```

## 📋 Security Checklist

- [ ] Change default passwords
- [ ] Enable HTTPS/SSL
- [ ] Regular security updates
- [ ] Monitor logs for suspicious activity
- [ ] Limit container resources
- [ ] Use non-root user
- [ ] Network segmentation
- [ ] Regular backups

## 🎯 Performance Optimization

### Container Optimization
```dockerfile
# Multi-stage build
FROM php:8.2-fpm-alpine as builder
# ... build steps ...

FROM php:8.2-fpm-alpine as runtime
COPY --from=builder /app /var/www/html
```

### Resource Limits
```yaml
services:
  dork-generator:
    deploy:
      resources:
        limits:
          cpus: '1.0'
          memory: 512M
        reservations:
          cpus: '0.5'
          memory: 256M
```

Remember to use this tool responsibly and in compliance with applicable laws and regulations!
