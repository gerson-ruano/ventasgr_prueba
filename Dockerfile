# Etapa 1: Construcción con Composer y Node
FROM php:8.3-fpm AS build

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    npm \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar código
WORKDIR /var/www
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Compilar assets con Vite (si tu proyecto los usa)
RUN npm install && npm run build

# Permisos para Laravel
RUN chmod -R 777 storage bootstrap/cache

# Etapa 2: Imagen final con Nginx + PHP-FPM
FROM php:8.3-fpm

# Instalar Nginx
RUN apt-get update && apt-get install -y nginx && apt-get clean

# Configurar Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copiar código desde la etapa build
COPY --from=build /var/www /var/www

# Configurar PHP-FPM
RUN sed -i 's|listen = .*|listen = 9000|' /usr/local/etc/php-fpm.d/zz-docker.conf

# Puerto Railway
ENV PORT=8000
EXPOSE ${PORT}

# Iniciar Nginx + PHP-FPM
CMD service nginx start && php-fpm
