# =======================
# Etapa 1: Composer (vendor)
# =======================
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_PROCESS_TIMEOUT=2000 \
    COMPOSER_MAX_PARALLEL_HTTP=2
RUN composer install \
    --no-dev --no-interaction --prefer-dist \
    --no-ansi --no-progress \
    --optimize-autoloader \
    --ignore-platform-reqs \
    --no-scripts --no-plugins

# =======================
# Etapa 2: Frontend (Laravel Mix)
# =======================
FROM node:18-bullseye-slim AS frontend
WORKDIR /app
ENV NODE_OPTIONS=--openssl-legacy-provider
COPY package.json package-lock.json* ./
RUN [ -f package-lock.json ] && npm ci || npm i
COPY . .
RUN npm run production || npm run prod

# =======================
# Etapa 3: Runtime (PHP-FPM 8.2 + Nginx + ODBC18 + sqlsrv/pdo_sqlsrv)
# =======================
FROM php:8.2-fpm-bookworm

ENV DEBIAN_FRONTEND=noninteractive \
    MAKEFLAGS=-j1

# Paquetes base mínimos + Nginx + Supervisor + dependencias para extensiones
RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates curl git unzip supervisor nginx \
    libicu-dev libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    gnupg2 apt-transport-https \
    unixodbc-dev \
 && rm -rf /var/lib/apt/lists/*

# Extensiones PHP comunes (compiladas rápidamente)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j1 gd intl zip bcmath opcache

# ODBC 18 (Microsoft) para Debian 12 (bookworm) + herramientas
# Guía MS ODBC Linux: https://learn.microsoft.com/sql/connect/odbc/linux-mac/
RUN set -eux; \
    curl -sSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/ms.gpg; \
    echo "deb [signed-by=/usr/share/keyrings/ms.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" > /etc/apt/sources.list.d/mssql-release.list; \
    apt-get update && ACCEPT_EULA=Y apt-get install -y --no-install-recommends msodbcsql18 mssql-tools18 \
    && rm -rf /var/lib/apt/lists/*

# PECL sqlsrv / pdo_sqlsrv (uno por paso para bajar memoria)
RUN pecl channel-update pecl.php.net \
 && printf "\n" | pecl install -f sqlsrv-5.12.0 \
 && echo "extension=sqlsrv.so" > /usr/local/etc/php/conf.d/20-sqlsrv.ini \
 && rm -rf /tmp/pear
RUN printf "\n" | pecl install -f pdo_sqlsrv-5.12.0 \
 && echo "extension=pdo_sqlsrv.so" > /usr/local/etc/php/conf.d/30-pdo_sqlsrv.ini \
 && rm -rf /tmp/pear

# Copiar app
WORKDIR /var/www/html
COPY . .
# Vendor y assets construidos
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public ./public

# Permisos Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# ---------- Nginx (plantilla usando ${PORT}) ----------
RUN mkdir -p /etc/nginx/conf.d
RUN bash -lc 'cat > /etc/nginx/conf.d/default.conf.template << "EOF"\n\
server {\n\
    listen ${PORT};\n\
    server_name _;\n\
    root /var/www/html/public;\n\
    index index.php index.html;\n\
\n\
    add_header X-Frame-Options \"SAMEORIGIN\" always;\n\
    add_header X-Content-Type-Options \"nosniff\" always;\n\
\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
\n\
    location ~* \\.(?:css|js|jpg|jpeg|png|gif|ico|svg|woff2?)$ {\n\
        expires 7d;\n\
        access_log off;\n\
        try_files $uri $uri/ @laravel;\n\
    }\n\
\n\
    location @laravel {\n\
        rewrite ^(.+)$ /index.php last;\n\
    }\n\
\n\
    location ~ \\.php$ {\n\
        include fastcgi_params;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_read_timeout 300;\n\
    }\n\
\n\
    client_max_body_size 50M;\n\
    access_log /var/log/nginx/access.log;\n\
    error_log  /var/log/nginx/error.log;\n\
}\n\
EOF'

# ---------- Supervisor (php-fpm + nginx) ----------
RUN bash -lc 'cat > /etc/supervisor/conf.d/supervisord.conf << "EOF"\n\
[supervisord]\n\
nodaemon=true\n\
user=root\n\
logfile=/var/log/supervisor/supervisord.log\n\
\n\
[program:php-fpm]\n\
command=docker-php-entrypoint php-fpm\n\
priority=10\n\
autostart=true\n\
autorestart=true\n\
stdout_logfile=/dev/stdout\n\
stderr_logfile=/dev/stderr\n\
\n\
[program:nginx]\n\
command=/usr/sbin/nginx -g \"daemon off;\"\n\
priority=20\n\
autostart=true\n\
autorestart=true\n\
stdout_logfile=/dev/stdout\n\
stderr_logfile=/dev/stderr\n\
EOF'

# ---------- start.sh ----------
RUN bash -lc 'cat > /start.sh << "EOF"\n\
#!/usr/bin/env bash\n\
set -e\n\
export PORT=${PORT:-8080}\n\
envsubst \"\\${PORT}\" < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf\n\
cd /var/www/html\n\
php artisan storage:link || true\n\
php artisan config:cache || true\n\
php artisan route:cache || true\n\
php artisan view:cache || true\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf\n\
EOF\n\
&& chmod +x /start.sh'

ENV PORT=8080
EXPOSE 8080
CMD ["/start.sh"]
