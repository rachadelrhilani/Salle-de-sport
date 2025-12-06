FROM php:8.3-apache

# Installer mysqli et activer mod_rewrite
RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli \
    && a2enmod rewrite

# Copier les fichiers après l'installation
COPY . /var/www/html

# Permissions (pour Linux, pas impact sur Windows mais nécessaire pour images multi-OS)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copier Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurer Apache pour Windows
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/allow-all.conf \
    && a2enconf allow-all
