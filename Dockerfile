# Usar la imagen base de PHP 7.4 con Apache
FROM php:7.4-apache

# Instalar dependencias del sistema
RUN apt-get update -y && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    git \
    curl \
    unzip \
    zip

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

# Instalar Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Configurar ServerName para Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configurar el document root de Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/app_perito_web/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Establecer el directorio de trabajo
WORKDIR /var/www/html/app_perito_web

# Copiar el proyecto Laravel
COPY . .

# Instalar dependencias de Composer (sin dev para producción)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Configurar Node.js para usar OpenSSL legacy
ENV NODE_OPTIONS=--openssl-legacy-provider

# Instalar dependencias de NPM y compilar assets
RUN npm install && npm run prod

# Ajustar permisos para directorios de Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Puerto expuesto
EXPOSE 80