# Use the official PHP image with PHP 7.4 and Apache
FROM php:8.1-apache

# Update package repository and install system dependencies
RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    default-mysql-client \
    libmagickwand-dev \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli zip \
    && docker-php-ext-enable mysqli

# Install Imagick extension via PECL
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Copy project files
COPY . /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite


# Set the working directory
WORKDIR /var/www/html
