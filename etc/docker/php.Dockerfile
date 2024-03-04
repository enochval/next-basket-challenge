FROM php:8.1-fpm

ARG SERVICE

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    cron \
    unzip \
    redis-tools


ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp redis


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/www

# Set working directory
WORKDIR /var/www

COPY ./ /var/www/

# Install PHP dependencies
RUN composer install --no-scripts

RUN echo "memory_limit=1024M" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "allow_url_fopen=on" >> /usr/local/etc/php/conf.d/php.ini