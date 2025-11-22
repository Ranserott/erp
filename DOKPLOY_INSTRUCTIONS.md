# Instrucciones Exactas para Dokploy 🚀

## El problema estaba resuelto:
✅ SQLite con archivo database.sqlite faltante
✅ Configuración Docker optimizada para producción
✅ Variables de entorno pre-configuradas

## PASOS PARA DESPLEGAR EN DOKPLOY:

### 1. Subir código a Git
```bash
git add .
git commit -m "Fix SQLite deployment for Dokploy - use Dockerfile.dokploy"
git push origin main
```

### 2. Configurar aplicación en Dokploy

**Dockerfile Path:** `Dockerfile.dokploy` ⭐
**Context:** `/`

### 3. Variables de entorno en Dokploy (solo estas):
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://metalu.bytea.cl
APP_LOCALE=es
DB_CONNECTION=sqlite
SESSION_DRIVER=database
CACHE_STORE=database
```

### 4. ¡Desplegar!

No necesitas comandos adicionales. El Dockerfile.dokploy hace todo:
- ✅ Crea database/database.sqlite automáticamente
- ✅ Configura .env correctamente
- ✅ Ejecuta migraciones
- ✅ Optimiza para producción

## ¿Por qué Dockerfile.dokploy?

1. **SQLite garantizado**: Crea el archivo database.sqlite
2. **Variables listas**: Usa .env.dokploy pre-configurado
3. **Permisos correctos**: www-data con permisos necesarios
4. **Producción optimizada**: Cachés y migraciones automáticas

## Archivos clave:
- `Dockerfile.dokploy` - El Docker que usarás
- `.env.dokploy` - Variables de entorno pre-configuradas
- `.dockerignore` - Excluye archivos locales pero incluye estructura

¡Listo para desplegar! 🎯