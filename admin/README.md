# 🛡️ Panel Administrativo para Control de Guardias — Frontend

**URL:** https://guardias.arcanix.com.mx/  
**Credenciales demo:**

- Correo: `admin@arcanix.com.mx`
- Contraseña: `arcanix`

> Aplicación multiusuario con roles y permisos. **Instalable como PWA** (escritorio y móvil) y se comporta como app nativa al instalarse desde el navegador.

---

## Tabla de contenido

- [Resumen](#resumen)
- [Tecnologías](#tecnologías)
- [Módulos principales (UI)](#módulos-principales-ui)
- [Scripts](#scripts)
- [Instalación y uso](#instalación-y-uso)
- [Configuración](#configuración)
- [Notas y buenas prácticas](#notas-y-buenas-prácticas)
- [Licencia](#licencia)
- [Autor](#autor)

---

## Resumen

Frontend (SPA) para la gestión operativa, administrativa y financiera de empresas de seguridad privada.

Incluye:

- **Recursos Humanos**: faltas, incapacidades, vacaciones, descuentos, préstamos, días laborales/prestaciones, estados de cuenta por guardia.
- **Bancos y Finanzas**: bancos, saldos, movimientos (ingresos/egresos) y relación con pagos/ventas.
- **Almacén**: entradas/salidas, inventario, historial por artículo.
- **Clientes y Proveedores**: datos fiscales, sucursales, relación con cotizaciones/órdenes.
- **Cotizaciones y Ventas**: generación y control de ventas.
- **Recorridos**: generación de QR para puntos de control.
- **Multiusuario**: roles, permisos, auditoría/bitácora (logs).

---

## Tecnologías

- **React.js**
- **Tailwind CSS**
- **PWA** (service worker + manifest, según configuración del repo)
- Consumo de API protegida (típicamente vía **Sanctum** en el backend)

---

## Módulos principales (UI)

- Panel principal (KPIs/atajos según permisos)
- Recursos humanos
- Bancos y finanzas
- Almacén
- Clientes y proveedores
- Cotizaciones y ventas
- Recorridos (QR)
- Usuarios / roles / permisos
- Logs / auditoría

---

## Scripts

> Ajusta según tu tooling (Vite/CRA). Si es Vite, esto normalmente aplica.

```bash
npm install
npm run dev
npm run build
npm run preview
```

---

## Instalación y uso

1. Instala dependencias:

```bash
npm install
```

2. Levanta en desarrollo:

```bash
npm run dev
```

3. Build de producción:

```bash
npm run build
```

4. Preview local del build:

```bash
npm run preview
```

---

## Configuración

> Los nombres exactos dependen del proyecto; ajusta según tu `.env` / `.env.local`.

Recomendado:

- **URL base del API** (backend).
- Flags (modo demo, logs, etc.).
- Configuración PWA: nombre, íconos, scope, display.

Ejemplo (orientativo):

```bash
# .env.local (ejemplo)
VITE_API_BASE_URL=http://localhost:8000
```

---

## Notas y buenas prácticas

- **Permisos**: oculta rutas/acciones y valida también en backend (doble capa).
- **Cache de datos**: invalida/actualiza cache al registrar movimientos financieros, pagos o ajustes de RH.
- **PWA**:
  - Prueba instalación en Android y desktop (Chrome/Edge).
  - Revisa caching al liberar nuevas versiones para evitar “assets viejos”.

---

## Licencia

Este software puede ser licenciado por cliente con **código fuente completo**.  
El cliente es responsable del hosting, datos y uso del sistema.

Para más información o personalizaciones, contacta a: contacto@arcanix.com.mx

---

## Autor

Desarrollado por **Arcanix**.  
Soporte técnico o consultas: contacto@arcanix.com.mx — ARCANIX WEB: https://arcanix.com.mx/
