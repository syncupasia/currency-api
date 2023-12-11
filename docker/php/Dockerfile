FROM php:7.4-fpm-alpine

# Update package repository and install tzdata
RUN apk update && \
    apk add --no-cache tzdata

# Set the timezone to Toronto, Canada
ENV TZ="America/Toronto"

# Install necessary dependencies and PHP extensions
RUN apk add --no-cache autoconf g++ make openssl-dev libpng-dev libzip-dev linux-headers && \
    docker-php-ext-install gd zip bcmath sockets mysqli pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

