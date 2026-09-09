# ==============================================================================
# Dockerfile para Aplicación Laravel (PHP 8.3 CLI + SQLite + Node.js / Vite)
# ==============================================================================

# Imagen base oficial de PHP 8.3 CLI
FROM php:8.3-cli

# Directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# 1. Instalar dependencias del sistema operativo, extensiones de PHP y Node.js (v20) para Vite/Tailwind
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install pdo_sqlite zip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 2. Copiar ejecutable oficial de Composer (versión 2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Copiar todo el proyecto al directorio de trabajo
COPY . .

# 4. Instalar dependencias de PHP con Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 5. Instalar dependencias de Node.js y compilar assets (Vite / Tailwind CSS)
RUN npm install && npm run build

# 6. Crear estructura de directorios necesaria para almacenamiento y base de datos SQLite
RUN mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache

# 7. Limpiar caché de configuración
RUN php artisan config:clear

# Puerto expuesto por el servidor interno de Laravel
EXPOSE 8000

# Comando por defecto para iniciar el servidor de desarrollo de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]