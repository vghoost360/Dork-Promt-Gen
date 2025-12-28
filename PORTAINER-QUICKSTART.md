# Portainer Quick Start Guide

## 🚀 Deploy in 3 Minutes

### Prerequisites
✅ Portainer installed and running  
✅ Docker environment connected  
✅ Port 80 available (or use custom port)

---

## Method 1: Web Editor (Fastest)

### Step 1: Login to Portainer
Navigate to `http://your-server:9000`

### Step 2: Create Stack
1. Click **Stacks** → **+ Add stack**
2. **Name**: `dork-generator`
3. Select **Web editor**

### Step 3: Paste Configuration
Copy and paste this into the editor:

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
      - "80:80"
    volumes:
      - dork-logs:/var/www/html/logs
      - dork-cache:/var/www/html/cache
      - dork-sessions:/var/www/html/sessions
    environment:
      - PHP_MEMORY_LIMIT=256M
      - PHP_MAX_EXECUTION_TIME=300
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

### Step 4: Deploy
Click **Deploy the stack**

### Step 5: Access
Open `http://your-server` in your browser

---

## Method 2: Git Repository

### Step 1: Create Stack
1. Click **Stacks** → **+ Add stack**
2. **Name**: `dork-generator`
3. Select **Repository**

### Step 2: Configure Repository
```
Repository URL: https://github.com/yourusername/dork-search-generator
Repository reference: refs/heads/main
Compose path: docker-compose.yml
```

### Step 3: Deploy
Click **Deploy the stack**

---

## Common Customizations

### Change Port (if 80 is in use)
```yaml
ports:
  - "8080:80"  # Access via http://your-server:8080
```

### Increase Memory
```yaml
environment:
  - PHP_MEMORY_LIMIT=512M
```

### Add Resource Limits
```yaml
deploy:
  resources:
    limits:
      cpus: '1.0'
      memory: 512M
```

---

## Managing Your Stack

### View Logs
**Stacks** → `dork-generator` → Click container → **Logs** tab

### Restart Container
**Containers** → Click restart icon next to `dork-search-generator`

### Update Stack
**Stacks** → `dork-generator` → **Editor** → Modify → **Update the stack**

### Stop/Remove
**Stacks** → `dork-generator` → **Stop** or **Delete**

### Access Console
**Containers** → `dork-search-generator` → **Console** → Select `/bin/sh` → **Connect**

---

## Troubleshooting

### Container Won't Start
1. Check logs: **Stacks** → `dork-generator` → Container → **Logs**
2. Verify port availability
3. Check volume permissions

### Can't Access Application
- Verify container is running (green status)
- Check firewall settings
- Try different port: change `80:80` to `8080:80`

### Port Already in Use
Change in stack configuration:
```yaml
ports:
  - "8080:80"  # Changed from 80:80
```

### Health Check Failing
Access container console and test:
```bash
curl http://localhost/
```

---

## Quick Commands

### Via Portainer Console
```bash
# Check Nginx status
nginx -t

# View PHP version
php -v

# Check disk usage
df -h

# List processes
ps aux
```

---

## Need Help?

📖 **Full Documentation**: See [DOCKER.md](DOCKER.md)  
🐛 **Issues**: Check container logs first  
🔄 **Updates**: Use Portainer's update feature

---

**🎉 That's it! Your Dork Search Generator is now running in Portainer!**
