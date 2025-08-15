# ---- Stage 1: Build assets ----
    FROM node:20-alpine AS nodebuild
    WORKDIR /app
    COPY package.json package-lock.json* yarn.lock* ./
    RUN if [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
        elif [ -f package-lock.json ]; then npm ci; \
        else npm i; fi
    COPY . .
    # Si usas Laravel Mix (package.json lo indica), construye:
    RUN npm run production || npm run prod || true
    
    # ---- Stage 2: PHP + SQLSRV ----
    FROM php:8.3-cli-bullseye
    
    # Dependencias del sistema
    RUN apt-get update && apt-get install -y \
        gnupg2 apt-transport-https curl ca-certificates \
        unixodbc-dev libzip-dev zip unzip git \
        && rm -rf /var/lib/apt/lists/*
    
    # Repositorio de Microsoft y msodbcsql18
    RUN curl https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > /usr/share/keyrings/microsoft.gpg \
     && echo "deb [signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/11/prod bullseye main" \
        > /etc/apt/sources.list.d/mssql-release.list \
     && apt-get update \
     && ACCEPT_EULA=Y apt-get install -y msodbcsql18 \
     && rm -rf /var/lib/apt/lists/*
    
    # Extensiones PHP necesarias
    RUN docker-php-ext-install pcntl bcmath zip
    
    # sqlsrv y pdo_sqlsrv (vía PECL)
    RUN pecl install sqlsrv pdo_sqlsrv \
     && docker-php-ext-enable sqlsrv pdo_sqlsrv
    
    # Composer
    COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
    
    WORKDIR /app
    
    # Copiamos composer.* primero para aprovechar la cache
    COPY composer.json composer.lock* ./
    RUN composer install --no-dev --prefer-dist --no-interaction --no-progress || true
    
    # Copiamos el resto del código
    COPY . .
    
    # Copiamos assets ya compilados
    COPY --from=nodebuild /app/public /app/public
    
    # Optimización Laravel
    RUN php -r "file_exists('.env') || copy('.env.example', '.env');" \
     && php artisan key:generate --force || true \
     && php artisan config:cache || true \
     && php artisan route:cache || true \
     && php artisan view:cache || true
    
    # Railway expone $PORT. Usaremos el servidor embebido de PHP para simplicidad.
    ENV PORT=8080
    EXPOSE 8080
    
    CMD php artisan migrate --force || true && php artisan serve --host 0.0.0.0 --port $PORT
    