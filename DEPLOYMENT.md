# Despliegue en Dokploy

## Archivos de Configuración Creados

- `Dockerfile` - Configuración principal para Docker
- `Dockerfile.prod` - Versión optimizada para producción
- `docker-compose.yml` - Configuración completa con Nginx y MySQL
- `nginx/conf.d/default.conf` - Configuración del servidor web Nginx
- `.dockerignore` - Archivos a excluir del Docker
- `deploy.sh` - Script de despliegue

## Pasos para Despliegue en Dokploy

### 1. Sube tu código a tu repositorio Git
```bash
git add .
git commit -m "Add Docker configuration for Dokploy deployment"
git push origin main
```

### 2. Configura en Dokploy

1. **Crea una nueva aplicación en Dokploy**
2. **Conecta tu repositorio Git**
3. **Configura variables de entorno** en Dokploy:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://tu-dominio.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_db
   DB_USERNAME=usuario_db
   DB_PASSWORD=contraseña_db

   CACHE_DRIVER=file
   FILESYSTEM_DISK=local
   QUEUE_CONNECTION=sync
   SESSION_DRIVER=file
   SESSION_LIFETIME=120
   ```

4. **Configura el Build:**
   - Usa el `Dockerfile.prod`
   - O usa `docker-compose.yml` si prefieres

5. **Comandos de Build (Opcional):**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan migrate --force
   php artisan storage:link
   ```

6. **Comandos de Inicio (Opcional):**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

### 3. Base de Datos

- Opción 1: Usa el servicio MySQL del docker-compose
- Opción 2: Configura una base de datos externa en Dokploy
- Opción 3: Usa SQLite (cambiando las variables de entorno)

### 4. Dominio y SSL

1. Configura tu dominio en Dokploy
2. Activa Let's Encrypt para SSL

### 5. Acceso a la Aplicación

Una vez desplegado, tu aplicación estará disponible en el dominio que configuraste.

## Notas Importantes

- La aplicación se configurará automáticamente para producción
- Los cachés serán optimizados para mejor rendimiento
- Los permisos se ajustarán automáticamente
- Si usas SQLite, asegúrate de que el archivo `database/database.sqlite` tenga permisos adecuados

## Troubleshooting

Si tienes problemas:
1. Revisa los logs en Dokploy
2. Verifica las variables de entorno
3. Asegúrate de que la base de datos esté configurada correctamente