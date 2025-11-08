# 🐳 Base image with PHP + Apache
FROM php:8.2-apache

# Copy all project files to the Apache web directory
COPY . /var/www/html/

# Install MySQL extension (for PHP-MySQL connection)
RUN docker-php-ext-install mysqli

# Expose port 80 (web server port)
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
