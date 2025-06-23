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
            'count-adminpage'                  => 'guardias',
            'guardias-asignado'                => 'guardias',
            'supervisores'                     => 'guardias',
            'cancelar-venta'                   => 'guardias',
            'guardias-sucursal'                => 'guardias',
            'supervisores-sucursal'            => 'guardias',
            'jefes-sucursal'                   => 'guardias',
            'prestamos-pendientes'             => 'guardias',
            'generar-estadocuenta-guardia'     => 'guardias',
            'generar-estadocuenta-banco'       => 'bancos',
            'generar-estadocuenta-cliente'     => 'clientes',
            'generar-estadocuenta-proveedor'   => 'proveedores',
            'generar-horastrabajadas-guardia'  => 'guardias',
            'sucursales-cliente'               => 'clientes',
            'articulos-asignar'                => 'articulos',
            'vehiculos-disponibles'            => 'vehiculos',
            'ventas-orden-servicio'            => 'ventas',
            'ventas-ingresos-mensuales'        => 'ventas',
            'ventas-egresos-mensuales'         => 'ventas',
            'almacen-disponibles'              => 'almacen',
            'equipamiento-completo'            => 'guardias',
            'equipo-disponible'                => 'almacen',

            'check-blacklist'                  => 'guardias',
            'generador-reportes'               => 'clientes',
            'reporte-rh'                       => 'clientes',
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
            $q->where('nombre', $modulo);
        })->first();

        if (!$permiso || !$permiso->$accion) {
            return response()->json(['message' => 'No tienes permiso para acceder a este módulo'], 403);
        }

        return $next($request);
    }
}
