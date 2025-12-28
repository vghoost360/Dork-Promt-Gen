# Advanced Dork Search Generator

A professional Google Dorking tool for security researchers and penetration testers. Generate sophisticated search queries to find exposed files, vulnerable systems, and sensitive information.

## ⚠️ Legal Disclaimer

**For educational and authorized security research only.** Only use on systems you own or have permission to test.

## 🚀 Quick Start

```bash
docker run -d -p 8080:80 vghoost360/dork-generator:latest
```

Then open http://localhost:8080

## 🐳 Docker Compose

```yaml
services:
  dork-generator:
    image: vghoost360/dork-generator:latest
    container_name: dork-search-generator
    restart: unless-stopped
    ports:
      - "8080:80"
    volumes:
      - ./logs:/var/www/html/logs
      - ./cache:/var/www/html/cache
    environment:
      - PHP_MEMORY_LIMIT=256M
      - PHP_MAX_EXECUTION_TIME=300
```

## 🔒 With Traefik (HTTPS)

```yaml
services:
  dork-generator:
    image: vghoost360/dork-generator:latest
    container_name: dork-search-generator
    restart: unless-stopped
    labels:
      - traefik.enable=true
      - traefik.http.routers.dork.entrypoints=websecure
      - traefik.http.routers.dork.rule=Host(`dork.yourdomain.com`)
      - traefik.http.routers.dork.tls.certresolver=letsencrypt
      - traefik.http.services.dork.loadbalancer.server.port=80
    networks:
      - traefik-network

networks:
  traefik-network:
    external: true
```

## ✨ Features

- **10+ Dork Categories**: Admin panels, databases, config files, backups, APIs, cloud storage, and more
- **Advanced Operators**: site:, inurl:, intitle:, filetype:, AND/OR/NOT, wildcards, date ranges
- **Live Preview**: See your dork build in real-time
- **Quick Templates**: One-click templates for common searches
- **Multiple Search Engines**: Google, Bing, DuckDuckGo, Yandex, Baidu
- **Mode Toggle**: Normal and 18+ Adult search modes
- **Dork Analysis**: Complexity and risk level assessment
- **Export & History**: Save and export your dorks
- **Modern UI**: Glassmorphism design, dark mode, responsive

## 🏗️ Architecture

- **Base Image**: `php:8.2-fpm-alpine`
- **Web Server**: Nginx
- **Process Manager**: Supervisor
- **Size**: ~55MB compressed

## 📦 Tags

- `latest` - Latest stable release
- `1.0.1` - Current version with session fix
- `1.0.0` - Initial release

## 🔗 Links

- **GitHub**: [https://github.com/vghoost360/Dork-Promt-Gen](https://github.com/vghoost360/Dork-Promt-Gen)
- **Issues**: [Report bugs or request features](https://github.com/vghoost360/Dork-Promt-Gen/issues)

## 📝 Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `PHP_MEMORY_LIMIT` | 256M | PHP memory limit |
| `PHP_MAX_EXECUTION_TIME` | 300 | Max script execution time |
| `NGINX_WORKER_CONNECTIONS` | 1024 | Nginx worker connections |

## 🩺 Health Check

The container includes a health check endpoint at `/health.php`

```bash
curl http://localhost:8080/health.php
# Returns: OK
```

## 📄 License

MIT License - See [GitHub repository](https://github.com/vghoost360/Dork-Promt-Gen) for details.
