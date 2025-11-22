#!/bin/bash

# Script de inicio para Laravel con SQLite
set -e

echo "🚀 Iniciando aplicación Laravel..."

# Crear directorios necesarios si no existen
mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache

# Crear base de datos SQLite si no existe
if [ ! -f database/database.sqlite ]; then
    echo "📁 Creando base de datos SQLite..."
    touch database/database.sqlite
    chmod 666 database/database.sqlite
fi

# Ajustar permisos
echo "🔐 Ajustando permisos..."
chmod -R 775 storage bootstrap/cache
chmod -R 777 database

# Generar key si no existe
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generando application key..."
    php artisan key:generate
fi

# Optimizar para producción
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Optimizando para producción..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Ejecutar migraciones
echo "🗄️ Ejecutando migraciones..."
php artisan migrate --force

# Limpiar cachés
echo "🧹 Limpiando cachés..."
php artisan cache:clear

echo "✅ Aplicación lista!"

# Iniciar PHP-FPM
exec php-fpm