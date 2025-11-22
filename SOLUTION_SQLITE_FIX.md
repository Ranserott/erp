# 🔧 SOLUCIÓN RÁPIDA - Error SQLite en Dokploy

## Problema Actual:
```
Database file at path [/app/database/database.sqlite] does not exist.
```

## 🚀 SOLUCIÓN INMEDIATA:

### 1. Sube los archivos actualizados:
```bash
git add .
git commit -m "Fix SQLite database creation - use Dockerfile.final"
git push origin main
```

### 2. En Dokploy - Cambia el Dockerfile:
- **Dockerfile Path:** `Dockerfile.final` (importante!)
- **Context:** `/`

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

## 🎯 ¿Qué arregla Dockerfile.final?

✅ **Prioridad .env**: Usa .env.simple (ruta relativa) primero
✅ **Creación garantizada**: Script robusto que crea database.sqlite
✅ **Verificación**: Verifica que el archivo exista antes de continuar
✅ **Logs detallados**: Muestra estado de la base de datos
✅ **Permisos correctos**: 666 para database.sqlite
✅ **Fallback**: Si falla creación, detiene el contenedor con error claro

## 📋 Qué archivos se usan:

1. **`Dockerfile.final`** - El Dockerfile corregido
2. **`.env.simple`** - Variables con ruta relativa (recomendado)
3. **`.env.dokploy`** - Tu configuración actual (funcionará después de corrección)

## ⚡ Para probar rápido:

Si quieres probar localmente:
```bash
docker build -f Dockerfile.final -t laravel-erp .
docker run -p 9000:9000 laravel-erp
```

## 🔍 Diagnóstico:

Después del despliegue, revisa los logs en Dokploy. Deberías ver:
```
📁 Configurando permisos...
🗄️  Creando base de datos SQLite...
   ✓ Base de datos creada
   -rw-rw-rw- 1 www-data www-data 16K database/database.sqlite
🔄 Ejecutando migraciones...
✅ Laravel iniciado correctamente
```

¡Esto debería resolver definitivamente el problema! 🎉