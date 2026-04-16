# 🛡️ Panel Administrativo para Control de Guardias — Backend

**URL:** https://guardias.arcanix.com.mx/  
**Credenciales demo:**

-   Correo: `admin@arcanix.com.mx`
-   Contraseña: `arcanix`

> API + lógica de negocio para una aplicación multiusuario con roles y permisos. Maneja operaciones de RH, bancos/finanzas, almacén, clientes/proveedores y ventas.

---

## Tabla de contenido

-   [Resumen](#resumen)
-   [Tecnologías](#tecnologías)
-   [Dominio y módulos principales](#dominio-y-módulos-principales)
-   [Instalación](#instalación)
-   [Configuración](#configuración)
-   [Migraciones y seeders](#migraciones-y-seeders)
-   [Servidor local](#servidor-local)
-   [Notas y buenas prácticas](#notas-y-buenas-prácticas)
-   [Licencia](#licencia)
-   [Autor](#autor)

---

## Resumen

Backend (Laravel) para la gestión operativa, administrativa y financiera de empresas con guardias de seguridad.

Incluye:

-   **Recursos Humanos**:
    -   Faltas, incapacidades, vacaciones, descuentos y préstamos.
    -   Control de días laborales y prestaciones.
    -   Cálculo de **estados de cuenta por guardia**.
-   **Bancos y Finanzas**:
    -   Bancos, saldos y **movimientos bancarios** con control por tipo.
    -   Relación con pagos a proveedores, compras, boletas de gasolina, pagos a empleados y ventas.
    -   Manejo de **saldo inicial** y **saldo actual**.
-   **Almacén**:
    -   Entradas/salidas, inventario e historial por artículo.
-   **Clientes y Proveedores**:
    -   Datos fiscales, sucursales, relación con cotizaciones y órdenes de compra.
-   **Cotizaciones y Ventas**:
    -   Cotizaciones dinámicas por cliente y control de ventas.
-   **Recorridos**:
    -   Generador de códigos QR para puntos de control.
-   **Multiusuario**:
    -   Roles y permisos.
    -   Auditoría de acciones (logs).

---

## Tecnologías

-   **Laravel 10+**
-   **PHP 8.1+**
-   **MySQL 5.7+**
-   **Laravel Storage** (archivos, evidencias, documentos)
-   **Laravel Sanctum** (autenticación por tokens/cookies según implementación)
-   Hosting con **HTTPS** (recomendado/obligatorio en producción, especialmente para PWA)

---

## Dominio y módulos principales

-   RH (incidencias, prestaciones, nómina/estados de cuenta por guardia)
-   Finanzas/bancos (movimientos, saldos, relaciones contables)
-   Almacén (artículos, entradas/salidas, historial)
-   Clientes/proveedores (fiscales, sucursales, compras/cotizaciones)
-   Ventas (cotizaciones y ventas)
-   Recorridos (QR)
-   Usuarios/roles/permisos + logs

---

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
```

---

## Configuración

En `.env` configura mínimo:

-   `APP_URL`
-   `DB_*` (host, database, username, password)
-   CORS (si aplica), dominios permitidos
-   Storage (disco, rutas, permisos)
-   Sanctum (dominios stateful si usa cookies)

---

## Migraciones y seeders

```bash
php artisan migrate --seed
```

> Recomendación: ejecutar seeders en un entorno limpio/controlado para evitar duplicados en catálogos con restricciones `unique`.

---

## Servidor local

```bash
php artisan serve
```

---

## Notas y buenas prácticas

-   **Seguridad**:
    -   Validación de permisos en endpoints (no solo en UI).
    -   Sanitiza inputs y valida archivos antes de guardarlos en Storage.
-   **Contabilidad / trazabilidad**:
    -   Centraliza operaciones financieras (movimientos, saldos) en servicios para evitar inconsistencias.
    -   Mantén logs de cambios críticos.
-   **Performance**:
    -   Indexa columnas usadas en filtros/reportes (fechas, ids, estatus).
-   **Infra**:
    -   Asegura permisos correctos en `storage/` y `bootstrap/cache` en producción.

---

## Licencia

Este software puede ser licenciado por cliente con **código fuente completo**.  
El cliente es responsable del hosting, datos y uso del sistema.

Para más información o personalizaciones, contacta a: contacto@arcanix.com.mx

---

## Autor

Desarrollado por **Arcanix**.  
Soporte técnico o consultas: contacto@arcanix.com.mx — ARCANIX WEB: https://arcanix.com.mx/
