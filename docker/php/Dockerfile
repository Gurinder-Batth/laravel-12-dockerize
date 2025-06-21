FROM php:8.2.1-apache-buster

# Set working directory
WORKDIR /var/www/html

# Install required packages and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    bash \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip \
    gnupg \
    sudo \
    supervisor \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql mysqli zip pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Enable Apache mod_rewrite and SSL modules
RUN a2enmod rewrite ssl

# Ensure Apache runs as www-data
RUN sed -i 's/^User .*/User www-data/' /etc/apache2/apache2.conf && \
    sed -i 's/^Group .*/Group www-data/' /etc/apache2/apache2.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Create directories for phpMyAdmin
RUN mkdir -p /var/www/phpMyAdmin/bash /var/www/phpMyAdmin/src && \
    touch /var/www/phpMyAdmin/bash/bash.sh

# Generate self-signed SSL certificate
RUN mkdir -p /etc/apache2/ssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/apache2/ssl/server.key \
    -out /etc/apache2/ssl/server.crt \
    -subj "/C=US/ST=State/L=City/O=Company/OU=Department/CN=localhost"

RUN mkdir -p /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/bootstrap/cache \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Change directory permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Supervisor configuration for Laravel queue worker
COPY docker/supervisord.conf /etc/supervisor/conf.d/laravel-worker.conf

# Copy entrypoint script
COPY docker/php/entrypoint.sh /entrypoint.sh

# Give execution permission to entrypoint
RUN chmod +x /entrypoint.sh

# Expose ports
EXPOSE 80 443 5173

# Use entrypoint script
ENTRYPOINT ["/entrypoint.sh"]
