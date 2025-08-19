<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermisoDinamicoMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $rol = $user->rol;

        if (!$rol) {
            return response()->json(['error' => 'Sin rol asignado'], 403);
        }

        // Mapa de rutas auxiliares a módulos reales
        $mapAliasModulo = [
            'guardias-asignado'                => 'guardias',
            'guardias-sucursal'                => 'guardias',
            'supervisores'                     => 'guardias',
            'supervisores-sucursal'            => 'guardias',
            'jefes-sucursal'                   => 'guardias',
            'prestamos-pendientes'             => 'prestamos',
            'generar-estadocuenta-guardia'     => 'estadocuenta-guardias',
            'generar-estadocuenta-banco'       => 'estadocuenta-bancos',
            'generar-estadocuenta-cliente'     => 'estadocuenta-clientes',
            'generar-estadocuenta-proveedor'   => 'estadocuenta-proveedores',
            'generar-horastrabajadas-guardia'  => 'guardias',
            'sucursales-cliente'               => 'sucursales',
            'articulos-asignar'                => 'articulos',
            'vehiculos-disponibles'            => 'vehiculos',
            'cancelar-venta'                   => 'ventas',
            'ventas-orden-servicio'            => 'ventas',
            'almacen-disponibles'              => 'almacen',
            'equipamiento-completo'            => 'guardias',
            'equipo-disponible'                => 'almacen',
            'check-blacklist'                  => 'guardias',
            'generador-reportes'               => 'generador-reportes',
            'reporte-rh'                       => 'generador-reportes',
            'orden-servicio-eliminadas'        => 'orden-servicio',
            'ingresos'                         => 'movimientos-bancarios',
            'egresos'                          => 'movimientos-bancarios',
        ];

        $path = $request->path();
        $uri = explode('/', $path);

        // Ignora el prefijo "api" si existe
        $moduloBase = $uri[0] === 'api' ? $uri[1] ?? null : $uri[0];

        // Aplica alias si existe
        $modulo = $mapAliasModulo[$moduloBase] ?? $moduloBase;

        $metodo = $request->method();
        $accion = match ($metodo) {
            'GET'    => 'consultar',
            'POST'   => 'crear',
            'PUT', 'PATCH' => 'actualizar',
            'DELETE' => 'eliminar',
            default  => 'consultar'
        };

        $permiso = $rol->permisos()->whereHas('modulo', function ($q) use ($modulo) {
            $q->where('ruta', $modulo);
        })->first();

        if (!$permiso || !$permiso->$accion) {
            return response()->json(['message' => 'No tienes permiso para acceder a este módulo'], 403);
        }

        return $next($request);
    }
}