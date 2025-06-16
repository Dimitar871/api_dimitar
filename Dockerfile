FROM php:8.2-cli

# Install required PHP extensions and system dependencies
RUN apt-get update && apt-get install -y \
    unzip curl git zip libzip-dev \
    && docker-php-ext-install zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --optimize-autoloader

# Expose the port Laravel will run on
EXPOSE 10000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
