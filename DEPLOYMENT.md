# Despliegue en Dokploy - Laravel ERP con SQLite

## Archivos de Configuración Creados ✅

- `Dockerfile.prod` - Versión optimizada para producción con SQLite
- `docker-compose.yml` - Configuración completa con Nginx y MySQL
- `nginx/conf.d/default.conf` - Configuración del servidor web Nginx
- `.dockerignore` - Archivos a excluir del Docker
- `.env.production` - Variables de entorno para producción
- `start.sh` - Script de inicio automatizado
- `deploy.sh` - Script de despliegue

## Pasos para Despliegue en Dokploy 🚀

### 1. Sube tu código a tu repositorio Git
```bash
git add .
git commit -m "Add Docker configuration for SQLite deployment"
git push origin main
```

### 2. Configura en Dokploy

1. **Crea una nueva aplicación en Dokploy**
2. **Conecta tu repositorio Git**
3. **Configura las siguientes variables de entorno** en Dokploy:

   **Variables Esenciales:**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://tu-dominio.com
   APP_LOCALE=es

   # Base de Datos (SQLite ya está configurado)
   DB_CONNECTION=sqlite

   # Session y Cache
   SESSION_DRIVER=database
   CACHE_STORE=database
   ```

4. **Configura el Build:**
   - **Dockerfile Path:** `Dockerfile.prod`
   - **Context:** `/`
   - No necesitas comandos de build adicionales (están en el Dockerfile)

5. **Configura el inicio:**
   - No necesitas comandos de inicio adicionales (el script `start.sh` lo maneja)

### 3. ¿Qué hace el Dockerfile.prod automáticamente? 🤖

✅ **Instala SQLite** y extensiones PHP necesarias
✅ **Crea la base de datos SQLite** automáticamente
✅ **Configura permisos** correctos para storage y database
✅ **Instala dependencias** de Composer para producción
✅ **Genera la APP_KEY** automáticamente
✅ **Ejecuta migraciones** automáticamente
✅ **Optimiza cachés** para producción (config, route, view)

### 4. Primer Despliegue

1. Haz commit y push del código
2. Configura la aplicación en Dokploy
3. ¡Inicia el despliegue!

El primer despliegue tomará más tiempo porque:
- Descarga todas las dependencias
- Crea la base de datos
- Ejecuta todas las migraciones
- Compila los cachés

### 5. Acceso a la Aplicación

Una vez desplegado, tu aplicación estará disponible en el dominio que configuraste.

### 6. Migraciones Futuras

El script `start.sh` ejecutará `php artisan migrate --force` automáticamente en cada inicio, por lo que cualquier nueva migración se aplicará automáticamente.

## Ventajas de esta Configuración 🎯

- **Sin dependencias externas:** SQLite está integrado
- **Cero configuración de base de datos:** Se crea automáticamente
- **Producción lista:** Cachés optimizados
- **Seguro:** Permisos configurados correctamente
- **Persistente:** La base de datos SQLite persiste entre reinicios

## Troubleshooting

Si tienes problemas:
1. **Revisa los logs** en Dokploy
2. **Verifica las variables de entorno** (especialmente APP_URL)
3. **Asegúrate que el .dockerignore** no excluya archivos necesarios
4. **Reinicia la aplicación** si los cachés no se actualizan

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