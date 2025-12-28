# Local Development Guide

## Quick Start

### Start Development Environment
```powershell
# Build and start
docker compose -f docker-compose.dev.yml up -d --build

# View logs
docker compose -f docker-compose.dev.yml logs -f
```

### Access Application
- **URL**: http://localhost:8080
- **HTTPS**: https://localhost:8443

### Hot Reload
All PHP, CSS, and JS files are mounted, so changes are reflected immediately:
- Edit `index.php`, `config.php`, `script.js`, or `styles.css`
- Refresh your browser to see changes
- No rebuild needed!

## Development Commands

```powershell
# Start development container
docker compose -f docker-compose.dev.yml up -d

# View logs (follow)
docker compose -f docker-compose.dev.yml logs -f

# Restart container
docker compose -f docker-compose.dev.yml restart

# Stop container
docker compose -f docker-compose.dev.yml down

# Rebuild after Dockerfile changes
docker compose -f docker-compose.dev.yml up -d --build

# Access container shell
docker compose -f docker-compose.dev.yml exec dork-generator sh

# View PHP errors
docker compose -f docker-compose.dev.yml exec dork-generator tail -f /var/www/html/logs/error.log
```

## Debugging

### Check Container Status
```powershell
docker compose -f docker-compose.dev.yml ps
```

### View Nginx Logs
```powershell
docker compose -f docker-compose.dev.yml exec dork-generator tail -f /var/log/nginx/error.log
docker compose -f docker-compose.dev.yml exec dork-generator tail -f /var/log/nginx/access.log
```

### Check PHP-FPM Status
```powershell
docker compose -f docker-compose.dev.yml exec dork-generator ps aux | grep php-fpm
```

### Test Inside Container
```powershell
# Test PHP syntax
docker compose -f docker-compose.dev.yml exec dork-generator php -l /var/www/html/index.php

# Test curl
docker compose -f docker-compose.dev.yml exec dork-generator curl http://localhost/
```

## VS Code Integration

### Recommended Extensions
- **Docker** (ms-azuretools.vscode-docker)
- **PHP Intelephense** (bmewburn.vscode-intelephense-client)
- **PHP Debug** (xdebug.php-debug)

### Open in VS Code
1. Open Docker extension in VS Code
2. Right-click on `dork-search-generator-dev` container
3. Select "Attach Shell" for terminal access
4. Or "View Logs" for log monitoring

## Making Changes

### Edit Files Locally
All changes to these files are reflected immediately:
- `index.php` - Main application
- `config.php` - Configuration
- `script.js` - JavaScript
- `styles.css` - Styles
- `data/*.php` - Data files

### Changes Requiring Rebuild
If you modify these, rebuild the container:
- `Dockerfile`
- `docker/nginx.conf`
- `docker/php.ini`
- `docker/php-fpm.conf`

```powershell
docker compose -f docker-compose.dev.yml up -d --build
```

## Tips

### Clear Cache
```powershell
docker compose -f docker-compose.dev.yml exec dork-generator rm -rf /var/www/html/cache/*
```

### Reset Sessions
```powershell
docker compose -f docker-compose.dev.yml exec dork-generator rm -rf /var/www/html/sessions/*
```

### Browser Dev Tools
- Press F12 to open browser developer tools
- Check Console tab for JavaScript errors
- Check Network tab for request/response details

## Troubleshooting

### Port Already in Use
Change ports in `docker-compose.dev.yml`:
```yaml
ports:
  - "8081:80"  # Changed from 8080
```

### Changes Not Reflecting
1. Hard refresh browser: `Ctrl + F5`
2. Clear browser cache
3. Restart container:
   ```powershell
   docker compose -f docker-compose.dev.yml restart
   ```

### Container Won't Start
```powershell
# View detailed logs
docker compose -f docker-compose.dev.yml logs

# Remove and rebuild
docker compose -f docker-compose.dev.yml down
docker compose -f docker-compose.dev.yml up -d --build
```
