FROM php:8.3-apache

# Enable Apache modules
RUN a2enmod rewrite headers

# PHP extensions commonly needed for LAMP
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mbstring zip intl pdo pdo_mysql opcache

# (Optional) Xdebug for debugging in VS Code/PhpStorm
# Comment out if you don’t need it.
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Set docroot via build arg (also set in compose via env)
ARG APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf

WORKDIR /var/www/html