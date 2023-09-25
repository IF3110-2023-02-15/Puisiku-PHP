FROM php:8.0-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install pdo_pgsql PHP extension
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql pgsql

# Set the working directory in the container to /var/www/html
WORKDIR /var/www/html

# Copy only the necessary directories into the container
COPY public/ ./public
COPY src/ ./src
COPY public/.htaccess ./public/.htaccess

# Copy your custom Apache configuration file into the image
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Make port 80 available to the world outside this container
EXPOSE 80

# Run apache2-foreground when the container launches
CMD ["apache2-foreground"]
