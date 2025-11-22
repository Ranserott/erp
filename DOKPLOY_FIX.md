# 🔧 SOLUCIÓN DOKPLOY - Nixpacks + SQLite

## Problemas Identificados:
1. ❌ **Timeout Composer:** Descarga de dependencias falla
2. ❌ **Nixpacks automático:** Usa su configuración, no tus Dockerfiles
3. ❌ **SQLite no existe:** Base de datos no se crea automáticamente

## 🚀 SOLUCIÓN - Configurar Nixpacks Correctamente:

### 1. Sube los cambios (CORREGIDO):
```bash
git add .
git commit -m "Fix Dokploy nixpacks - use aptPkgs and fix sqlite extension"
git push origin main
```

### 2. En Dokploy - Configuración:

**Build Settings:**
- **Source:** GitHub (tu repositorio)
- **Build Mode:** Nixpacks (automático)
- **Branch:** main

**Variables de Entorno:**
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://metalu.bytea.cl
APP_LOCALE=es
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
SESSION_DRIVER=database
CACHE_STORE=database
```

### 3. ¿Qué hace `nixpacks.toml`?

✅ **Instala SQLite3** correctamente
✅ **Crea base de datos** automáticamente
✅ **Configura permisos** correctos (www-data)
✅ **Ejecuta migraciones** con `--force`
✅ **Optimiza producción** cachés
✅ **Usa variables correctas** para Dokploy

## 📋 Archivos Clave:

- ✅ **`nixpacks.toml`** - Configuración Dokploy
- ✅ **`.env.dokploy`** - Simplificado y limpio
- ❌ Elimina los otros `.env.*` (confusión)

## 🔍 Comprobar después del despliegue:

1. **Logs de Dokploy:** Deben mostrar migraciones ejecutándose
2. **Acceso web:** `https://metalu.bytea.cl` debería funcionar
3. **Base de datos:** Laravel debería encontrar `database.sqlite`

## ⚡ Si falla el Composer timeout:

En **Build Settings** → **Advanced Settings** → **Build args**:
```
COMPOSER_CACHE_DIR=/tmp/composer-cache
```

## 💡 Ventajas de esta solución:

- ✅ **Nixpacks optimizado:** Mejor que Docker personalizado
- ✅ **Automático:** Sin comandos manuales
- ✅ **SQLite garantizado:** Se crea siempre
- ✅ **Producción ready:** Optimizado y seguro

¡Con esto debería funcionar perfectamente! 🎉