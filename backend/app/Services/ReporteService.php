<?php

namespace App\Services;

use App\Models\OrdenCompra;
use App\Models\Compra;
use App\Models\MovimientoBancario;
use App\Models\Gasto;
use App\Models\Venta;
use App\Models\BoletaGasolina;

class ReporteService
{
    public static function obtenerRegistros($modulo, $filtros)
    {
        $query = match ($modulo) {
            'movimientos'      => MovimientoBancario::query(),
            'orden-compra'     => OrdenCompra::query(),
            'compras'          => OrdenCompra::query(),
            'gastos'           => Gasto::query(),
            'ventas'           => Venta::query(),
            'boletas-gasolina' => BoletaGasolina::query(),
            default            => null,
        };

        if (!$query) {
            return collect(); // Retorna colección vacía si no existe el módulo
        }

        // Aplicar rango de fechas
        $query->whereBetween('created_at', [$filtros['fecha_inicio'], $filtros['fecha_fin']]);

        // Aplicar filtros específicos según módulo
        match ($modulo) {
            'movimientos' => self::filtrarMovimeinto($query, $filtros),
            'orden-compra' => self::filtrarOrdenCompra($query, $filtros),
            'compras'      => self::filtrarCompra($query, $filtros),
            'gastos'       => self::filtrarGasto($query, $filtros),
            'ventas'       => self::filtrarVenta($query, $filtros),
            'boletas-gasolina' => self::filtrarBoletaGasolina($query, $filtros),};

        return $query->get();
    }

    private static function filtrarMovimeinto($query, $filtros)
    {
        $query->with('banco');

        if ($filtros['banco_id'] !== 'todos') {
            $query->where('banco_id', $filtros['banco_id']);
        }
        if ($filtros['tipo_movimiento'] !== 'todos') {
            $query->where('tipo_movimiento', $filtros['tipo_movimiento']);
        }
        if ($filtros['metodo_pago'] !== 'todos') {
            $query->where('metodo_pago', $filtros['metodo_pago']);
        }
    }

    private static function filtrarOrdenCompra($query, $filtros)
    {
        $query->with(['proveedor', 'banco', 'articulo']);

        if ($filtros['banco_id'] !== 'todos') {
            $query->where('banco_id', $filtros['banco_id']);
        }
        if ($filtros['proveedor_id'] !== 'todos') {
            $query->where('proveedor_id', $filtros['proveedor_id']);
        }
        if ($filtros['estatus'] !== 'todos') {
            $query->where('estatus', $filtros['estatus']);
        }
    }

    private static function filtrarCompra($query, $filtros)
    {
        $query->with(['proveedor', 'banco', 'articulo']);
        $query->where('estatus', 'Pagada');

        if ($filtros['banco_id'] !== 'todos') {
            $query->where('banco_id', $filtros['banco_id']);
        }
        if ($filtros['proveedor_id'] !== 'todos') {
            $query->where('proveedor_id', $filtros['proveedor_id']);
        }
        if ($filtros['metodo_pago'] !== 'todos') {
            $query->where('metodo_pago', $filtros['metodo_pago']);
        }
    }

    private static function filtrarGasto($query, $filtros)
    {
        $query->with('banco');

        if ($filtros['banco_id'] !== 'todos') {
            $query->where('banco_id', $filtros['banco_id']);
        }
        if ($filtros['metodo_pago'] !== 'todos') {
            $query->where('metodo_pago', $filtros['metodo_pago']);
        }
    }

    private static function filtrarVenta($query, $filtros)
    {
        $query->with('cotizacion.sucursal');
        $query->where('eliminado', false);

        if ($filtros['metodo_pago'] !== 'todos') {
            $query->where('metodo_pago', $filtros['metodo_pago']);
        }
        if ($filtros['tipo_pago'] !== 'todos') {
            $query->where('tipo_pago', $filtros['tipo_pago']);
        }
    }

    private static function filtrarBoletaGasolina($query, $filtros)
    {
        $query->with('vehiculo');

        if ($filtros['vehiculo_id'] !== 'todos') {
            $query->where('vehiculo_id', $filtros['vehiculo_id']);
        }
    }
}