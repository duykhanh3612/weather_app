# Use the official PHP image from the Docker Hub
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    git \
    unzip \
    cron \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install

# Expose port 80
EXPOSE 80

# Copy crontab file
COPY ./cron/laravel /etc/cron.d/laravel

# Apply cron job
RUN chmod 0644 /etc/cron.d/laravel \
    && crontab /etc/cron.d/laravel

# Start Apache and cron
CMD ["sh", "-c", "cron && apache2-foreground"]
