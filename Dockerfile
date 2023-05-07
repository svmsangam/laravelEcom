# Use an official PHP runtime as a parent image
FROM php:8.0.2-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y git unzip libzip-dev && \
    docker-php-ext-install zip pdo_mysql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clone the Laravel project from GitHub
RUN git clone https://github.com/svmsangam/laravelEcom.git .

# Install Laravel dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install



# Generate the Laravel application key
RUN php artisan key:generate

# Expose port 80 for web traffic
EXPOSE 80

# Start Apache web server
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
