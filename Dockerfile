# Use official PHP-FPM image as base
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    zip \
    unzip \
    git \
    && rm -rf /var/cache/apk/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    session \
    && docker-php-ext-enable opcache

# Create directories (nginx user already exists in alpine)
RUN mkdir -p /var/log/nginx \
    && mkdir -p /var/cache/nginx \
    && mkdir -p /var/www/html/logs \
    && mkdir -p /var/www/html/cache \
    && mkdir -p /var/www/html/sessions

# Copy application files
COPY . /var/www/html/

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set permissions
RUN chown -R nginx:nginx /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 644 /var/www/html/*.php \
    && chmod -R 755 /var/www/html/logs \
    && chmod -R 755 /var/www/html/cache \
    && chmod -R 755 /var/www/html/sessions

# Create health check script
RUN echo '<?php echo "OK"; ?>' > /var/www/html/health.php

# Expose port
EXPOSE 80

# Use supervisor to run both nginx and php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health.php || exit 1

# Labels
LABEL maintainer="Dork Generator Team"
LABEL description="Advanced Dork Search Generator with Nginx and PHP-FPM"
LABEL version="2.0.0"
