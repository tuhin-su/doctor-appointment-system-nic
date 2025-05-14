FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip sudo libzip-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip
    
RUN apt-get update && apt-get install -y \
    git curl unzip zip sudo libzip-dev libonig-dev libxml2-dev libpq-dev postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install Node.js and npm (using NodeSource)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Add user vscode with UID 1000 and give sudo access
RUN useradd -m -u 1000 -s /bin/bash vscode \
    && echo "vscode ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# Set permissions
RUN chown -R vscode:vscode /var/www \
    && chmod -R 755 /var/www

USER vscode

EXPOSE 9000
CMD ["sleep", "infinity"]
