#!/bin/bash

echo "🚀 Desplegando aplicación Laravel en Dokploy..."

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo "❌ Error: No se encuentra el archivo artisan. Asegúrate de estar en el directorio raíz de Laravel."
    exit 1
fi

# Optimizar composer
echo "📦 Optimizando dependencias de Composer..."
composer install --optimize-autoloader --no-dev --no-progress --no-interaction

# Limpiar cachés
echo "🧹 Limpiando cachés..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
echo "⚡ Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permisos
echo "🔐 Ajustando permisos..."
chmod -R 775 storage bootstrap/cache

echo "✅ Despliegue completado!"