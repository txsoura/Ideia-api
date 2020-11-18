FROM php:7.4.1-apache

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/api/

#Copy .env
COPY .env /var/www/api/

# Set working directory
WORKDIR /var/www/api

RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libpq-dev \
    build-essential \
    libonig-dev \
    libpq-dev \
    zip \
    curl \
    unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Install extensions
RUN docker-php-ext-install pdo_pgsql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www/api

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/api

# Change current user to www
USER www

# Install dependecies
RUN composer install

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
