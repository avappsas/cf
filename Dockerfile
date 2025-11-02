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
    ca-certificates curl git unzip supervisor nginx gettext-base \
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
RUN mkdir -p /etc/nginx/conf.d \
 && cat <<'EOF' > /etc/nginx/conf.d/default.conf.template
server {
    listen ${PORT};
    server_name _;
    root /var/www/html/public;
    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~* \.(?:css|js|jpg|jpeg|png|gif|ico|svg|woff2?)$ {
        expires 7d;
        access_log off;
        try_files $uri $uri/ @laravel;
    }

    location @laravel {
        rewrite ^(.+)$ /index.php last;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_read_timeout 300;
    }

    client_max_body_size 50M;
    access_log /var/log/nginx/access.log;
    error_log  /var/log/nginx/error.log;
}
EOF

# ---------- Supervisor (php-fpm + nginx) ----------
RUN cat <<'EOF' > /etc/supervisor/conf.d/supervisord.conf
[supervisord]
nodaemon=true
user=root
logfile=/var/log/supervisor/supervisord.log

[program:php-fpm]
command=docker-php-entrypoint php-fpm
priority=10
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stderr_logfile=/dev/stderr

[program:nginx]
command=/usr/sbin/nginx -g "daemon off;"
priority=20
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stderr_logfile=/dev/stderr
EOF

# ---------- start.sh ----------
RUN cat <<'EOF' > /start.sh
#!/usr/bin/env bash
set -e
export PORT=${PORT:-8080}
envsubst '${PORT}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf
cd /var/www/html
php artisan storage:link || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
EOF
RUN chmod +x /start.sh

ENV PORT=8080
EXPOSE 8080
CMD ["/start.sh"]
