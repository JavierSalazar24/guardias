<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Retorna TODOS los datos en una sola petición (Opcional)
     */
    public function dataDashboard()
    {
        return response()->json([
            'ingresosEgresos' => $this->getIngresosEgresosData(),
            'sucursalesVentas' => $this->sucursalesVentas(),
            'ordenesServicio' => $this->ordenesServicio(),
            'carteraVencida' => $this->carteraVencida(),
            'guardiasData' => $this->guardiasData(),
            'inventarioAlerta' => $this->inventarioAlerta(),
        ]);
    }

    private function getIngresosEgresosData()
    {
        $year = Carbon::now()->year;

        $raw = DB::table('movimientos_bancarios')
            ->select(
                DB::raw('MONTH(fecha) as month_num'),
                'tipo_movimiento',
                DB::raw('SUM(monto) as total')
            )
            ->whereYear('fecha', $year)
            ->groupBy('month_num', 'tipo_movimiento')
            ->get();

        $result = [];
        $months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        for ($i = 1; $i <= 12; $i++) {
            $ingreso = $raw->where('month_num', $i)->where('tipo_movimiento', 'Ingreso')->first()->total ?? 0;
            $gasto = $raw->where('month_num', $i)->where('tipo_movimiento', 'Egreso')->first()->total ?? 0;

            $result[] = [
                'month' => $months[$i - 1],
                'ingresos' => (float)$ingreso,
                'gastos' => (float)$gasto,
            ];
        }

        return $result;
    }

    private function sucursalesVentas()
    {
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes    = Carbon::now()->endOfMonth();

        $ventasSucursal = DB::table('ventas')
            ->join('cotizaciones', 'ventas.cotizacion_id', '=', 'cotizaciones.id')
            ->join('sucursales_empresa', 'cotizaciones.sucursal_empresa_id', '=', 'sucursales_empresa.id')
            ->where('ventas.estatus', '!=', 'Cancelada')
            ->whereBetween('ventas.fecha_emision', [$inicioMes, $finMes])
            ->select(
                'sucursales_empresa.nombre_sucursal as nombre',
                DB::raw('SUM(ventas.total) as ventas')
            )
            ->groupBy('sucursales_empresa.nombre_sucursal')
            ->orderByDesc('ventas')
            ->limit(5)
            ->get();

        return $ventasSucursal->map(function ($item) {
            return [
                'nombre'   => $item->nombre,
                'ventas' => (float) $item->ventas
            ];
        });
    }

    private function ordenesServicio()
    {
        Carbon::setLocale('es');

        $ordenes = DB::table('ordenes_servicios')
            ->join('ventas', 'ordenes_servicios.venta_id', '=', 'ventas.id')
            ->join('cotizaciones', 'ventas.cotizacion_id', '=', 'cotizaciones.id')
            ->join('sucursales', 'cotizaciones.sucursal_id', '=', 'sucursales.id')
            ->whereIn('ordenes_servicios.estatus', ['En proceso', 'Finalizada'])
            ->select(
                'ordenes_servicios.id',
                'ordenes_servicios.codigo_orden_servicio as codigo',
                'sucursales.nombre_empresa as cliente',
                'cotizaciones.cantidad_guardias as guardias',
                'ordenes_servicios.fecha_inicio',
                'ordenes_servicios.estatus as estado',
                'ventas.total as valor',
                'cotizaciones.id as cotizacion_id'
            )
            ->orderByRaw("
                CASE
                    WHEN ordenes_servicios.estatus = 'En proceso' THEN 1
                    WHEN ordenes_servicios.estatus = 'Finalizada' THEN 2
                    WHEN ordenes_servicios.estatus = 'Cancelada' THEN 3
                    ELSE 4
                END ASC
            ")
            ->orderBy('ordenes_servicios.fecha_inicio', 'desc')
            ->limit(10)
            ->get();

        return $ordenes->map(function ($orden) {
            $nombresServicios = DB::table('servicios_cotizaciones')
                ->join('tipos_servicios', 'servicios_cotizaciones.tipo_servicio_id', '=', 'tipos_servicios.id')
                ->where('servicios_cotizaciones.cotizacion_id', $orden->cotizacion_id)
                ->pluck('tipos_servicios.nombre');

            $servicioTexto = $nombresServicios->isNotEmpty()
                ? $nombresServicios->join(', ')
                : 'Servicio General';

            $cantidadGuardias = $orden->guardias;

            return [
                'id'       => $orden->codigo,
                'cliente'  => $orden->cliente,
                'servicio' => $servicioTexto,
                'guardias' => (int) $cantidadGuardias,
                'inicio'   => $orden->fecha_inicio,
                'estado'   => $orden->estado,
                'valor'    => (float) $orden->valor
            ];
        });
    }

    private function carteraVencida()
    {
        Carbon::setLocale('es');

        $fechaInicio = Carbon::now()->subMonths(3)->startOfDay();
        $fechaFin = Carbon::now()->subMonth()->endOfDay();

        $carteraRaw = DB::table('ventas')
            ->join('cotizaciones', 'ventas.cotizacion_id', '=', 'cotizaciones.id')
            ->join('sucursales', 'cotizaciones.sucursal_id', '=', 'sucursales.id')
            ->whereIn('ventas.estatus', ['Pendiente', 'Vencida'])
            ->where('ventas.tipo_pago', 'Crédito')
            ->whereBetween('ventas.fecha_vencimiento', [$fechaInicio, $fechaFin])
            ->select(
                'ventas.id',
                'sucursales.nombre_empresa as cliente',
                'sucursales.nombre_contacto as contacto',
                'sucursales.telefono_contacto as telefono',
                'sucursales.correo_contacto as correo',
                'ventas.total as monto',
                'ventas.fecha_vencimiento',
                'ventas.fecha_emision'
            )
            ->orderBy('ventas.fecha_vencimiento', 'asc')
            ->limit(10)
            ->get();

        $listado = $carteraRaw->map(function ($item) {
            $fechaVencimiento = Carbon::parse($item->fecha_vencimiento);
            $diasVencido = Carbon::now()->diffInDays($fechaVencimiento);

            $riesgo = match(true) {
                $diasVencido > 60 => 'alto',
                $diasVencido > 45 => 'medio',
                default => 'bajo'
            };

            return [
                'id' => $item->id,
                'cliente' => $item->cliente,
                'contacto' => $item->contacto,
                'telefono' => $item->telefono,
                'correo' => $item->correo,
                'monto' => (float) $item->monto,
                'diasVencido' => (int) $diasVencido,
                'riesgo' => $riesgo,
                'ultimoPago' => $item->fecha_emision
            ];
        });

        $totalGeneral = $listado->sum('monto');

        return [
            'data' => $listado,
            'total' => $totalGeneral
        ];
    }

    private function guardiasData()
    {
        Carbon::setLocale('es');

        $data = collect(range(5, 0))->map(function ($i) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth   = $date->copy()->endOfMonth();

            $nuevos = DB::table('guardias')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            $bajas = DB::table('black_list')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            $totalCreados = DB::table('guardias')
                ->where('created_at', '<=', $endOfMonth)
                ->count();

            $totalBajas = DB::table('black_list')
                ->where('created_at', '<=', $endOfMonth)
                ->count();

            $activos = $totalCreados - $totalBajas;

            return [
                'month'   => ucfirst($date->isoFormat('MMM')),
                'activos' => $activos,
                'nuevos'  => $nuevos,
                'bajas'   => $bajas
            ];
        });

        return $data;
    }

    private function inventarioAlerta()
    {
        $umbralCritico = 5;
        $umbralBajo = 15;

        $inventario = DB::table('almacen')
            ->join('articulos', 'almacen.articulo_id', '=', 'articulos.id')
            ->where('almacen.estado', 'Disponible')
            ->select(
                'articulos.nombre as item',
                DB::raw('COUNT(almacen.id) as stock')
            )
            ->groupBy('articulos.id', 'articulos.nombre')
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        return $inventario->map(function ($item) use ($umbralCritico, $umbralBajo) {
            $status = match(true) {
                $item->stock <= $umbralCritico => 'critico',
                $item->stock <= $umbralBajo => 'bajo',
                default => 'normal'
            };

            return [
                'item'   => $item->item,
                'stock'  => (int) $item->stock,
                'min'    => $umbralBajo,
                'status' => $status
            ];
        });
    }
}
