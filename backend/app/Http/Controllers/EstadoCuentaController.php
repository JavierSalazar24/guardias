<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Proveedor;
use App\Models\OrdenCompra;
use App\Models\Banco;
use App\Models\MovimientoBancario;
use App\Models\Gasto;
use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\Cotizacion;
use App\Models\Venta;
use App\Models\Guardia;
use App\Models\Descuento;
use App\Models\Falta;
use App\Models\Vacacion;
use App\Models\Incapacidad;
use App\Models\TiempoExtra;
use App\Models\Prestamo;
use App\Models\AbonoPrestamo;
use App\Models\CheckGuardia;
use Carbon\Carbon;

class EstadoCuentaController extends Controller
{
    public function generarPdfEstadoCuentaGuardia(Request $request)
    {
        $data = $this->generarEstadoCuentaGuardia($request)->getData(true);

        $pdf = Pdf::loadView('pdf.estado_cuenta_guardia', ['data' => $data]);
        return $pdf->stream("estado_cuenta_guardia_{$data['guardia']['nombre']}.pdf");
    }

    public function generarEstadoCuentaGuardia(Request $request)
    {
        $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $guardiaId = $request->guardia_id;
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);

        $guardia = Guardia::findOrFail($guardiaId);
        $sueldoBaseSemanal = $guardia->sueldo_base;
        $diasLaboralesPorSemana = $guardia->dias_laborales ?? 6;

        $prestaciones = [
            'imss' => $guardia->imss,
            'infonavit' => $guardia->infonavit,
            'fonacot' => $guardia->fonacot,
            'retencion_isr' => $guardia->retencion_isr,
        ];
        $totalPrestaciones = array_sum($prestaciones);

        $semanas = ceil($inicio->floatDiffInWeeks($fin));
        $diasLaboralesPeriodo = $diasLaboralesPorSemana * $semanas;

        $faltas = Falta::where('guardia_id', $guardiaId)->whereBetween('fecha_inicio', [$inicio, $fin])->get();

        $totalFaltas = $faltas->sum('cantidad_faltas');
        $totalFaltasMonto = $faltas->sum('monto');
        $diasTrabajados = max(0, $diasLaboralesPeriodo - $totalFaltas);
        $sueldoDiario = $sueldoBaseSemanal / $diasLaboralesPorSemana;
        $pagoPorDiasTrabajados = $diasTrabajados * $sueldoDiario;
        $pagoPorDiasSinFalta = max(0, $diasLaboralesPeriodo) * $sueldoDiario;

        $tiempoExtra = TiempoExtra::where('guardia_id', $guardiaId)->whereBetween('fecha_inicio', [$inicio, $fin])->get();
        $totalTiempoExtra = $tiempoExtra->sum('monto_total');

        $vacaciones = Vacacion::where('guardia_id', $guardiaId)->whereBetween('fecha_inicio', [$inicio, $fin])->get();
        $primaVacacional = $vacaciones->sum('prima_vacacional');

        $incapacidades = Incapacidad::where('guardia_id', $guardiaId)->whereBetween('fecha_inicio', [$inicio, $fin])->get();
        $incapPagadas = $incapacidades->sum('pago_empresa');

        $descuentos = Descuento::with('modulo_descuento')->where('guardia_id', $guardiaId)->whereBetween('fecha', [$inicio, $fin])->get();
        $totalDescuentos = $descuentos->sum('monto');

        $prestamos = Prestamo::with('modulo_prestamo')->where('guardia_id', $guardiaId)->whereBetween('fecha_prestamo', [$inicio, $fin])->get();
        $saldoRestantePrestamosPendientes = $prestamos->where('estatus', 'Pendiente')->sum('saldo_restante');
        $prestamosPendientes = $prestamos->where('estatus', 'Pendiente')->pluck('id');

        $abonos = AbonoPrestamo::whereHas('prestamo', function($q) use ($guardiaId) {
                $q->where('guardia_id', $guardiaId);
            })->whereBetween('fecha', [$inicio, $fin])->get();


        $cantidadAbonos = count($abonos);

        $incapNoPagadas = $incapacidades->filter(fn ($i) => $i->pago_empresa == 0)
            ->reduce(function ($total, $incap) use ($sueldoDiario) {
                $dias = Carbon::parse($incap->fecha_inicio)->diffInDays(Carbon::parse($incap->fecha_fin)) + 1;
                return $total + ($dias * $sueldoDiario);
            }, 0);

        $ingresos = $pagoPorDiasTrabajados + $totalTiempoExtra + $primaVacacional + $incapPagadas;
        $egresos = $totalFaltasMonto + $totalDescuentos + $saldoRestantePrestamosPendientes + $incapNoPagadas;
        $pagoBruto = $ingresos - $egresos;
        $pagoNeto = $pagoBruto - $totalPrestaciones;

        // Para el módulo de pagos
        $egresosPago = $totalFaltasMonto + $totalDescuentos + $incapNoPagadas;

        // Mostrar horas trabajadas
        $checks = CheckGuardia::where('guardia_id', $guardiaId)->whereBetween('fecha_entrada', [$inicio, $fin])->whereNotNull('fecha_salida')->get();
        $totalSegundos = $checks->sum('tiempo_trabajado_segundos');

        $dias = floor($totalSegundos / 86400);
        $horas = floor(($totalSegundos % 86400) / 3600);
        $minutos = floor(($totalSegundos % 3600) / 60);
        $segundos = $totalSegundos % 60;

        $partes = [];
        if ($dias > 0)      $partes[] = "$dias día(s)";
        if ($horas > 0)     $partes[] = "$horas hora(s)";
        if ($minutos > 0)   $partes[] = "$minutos minuto(s)";
        $partes[] = "$segundos segundo(s)";
        $totalTiempoTrabajado = implode(', ', $partes);

        return response()->json([
            'guardia' => [
                'id' => $guardia->id,
                'nombre' => $guardia->nombre.' '.$guardia->apellido_p.' '.$guardia->apellido_m,
                'sueldo_base_semanal' => $sueldoBaseSemanal,
                'dias_laborales_por_semana' => $diasLaboralesPorSemana,
                'sueldo_diario' => round($sueldoDiario, 2),
                'dias_trabajados' => $diasTrabajados,
                'aguinaldo' => $guardia->aguinaldo,
            ],
            'periodo' => [
                'inicio' => $inicio->toDateString(),
                'fin' => $fin->toDateString(),
            ],
            'tiempo_extra' => $tiempoExtra,
            'vacaciones' => $vacaciones,
            'incapacidades' => $incapacidades,
            'faltas' => $faltas,
            'descuentos' => $descuentos,
            'prestamos' => $prestamos->map(function ($p) {
                $p->abonos = $p->abonos;
                return $p;
            }),
            'cantidad_abonos' => $cantidadAbonos,
            'ingresos' => [
                'pago_dias_trabajados' => $pagoPorDiasTrabajados,
                'pago_no_faltado' => $pagoPorDiasSinFalta,
                'tiempo_extra' => $totalTiempoExtra,
                'prima_vacacional' => $primaVacacional,
                'incapacidades_pagadas' => $incapPagadas,
            ],
            'prestaciones' => $prestaciones,
            'egresos' => [
                'faltas' => $totalFaltasMonto,
                'descuentos' => $totalDescuentos,
                'prestamos' => $saldoRestantePrestamosPendientes,
                'incapacidades_no_pagadas' => $incapNoPagadas,
            ],
            'totales' => [
                'total_ingresos' => $ingresos,
                'total_egresos' => $egresos,
                'pago_bruto' => $pagoBruto,
                'total_prestaciones' => $totalPrestaciones,
                'pago_neto' => $pagoNeto,
            ],
            // Módulo de pagos
            'pagos' => [
                'total_ingresos' => $ingresos,
                'total_egresos' => $egresosPago,
                'pago_bruto' => $pagoBruto,
                'total_prestaciones' => $totalPrestaciones,
                'pago_neto' => $pagoNeto,
            ],
            'tiempo_trabajado_total' => [
                'segundos' => $totalSegundos,
                'formato' => $totalTiempoTrabajado
            ],
        ]);
    }

    public function generarPdfEstadoCuentaCliente(Request $request)
    {
        $data = $this->generarEstadoCuentaCliente($request);

        $pdf = Pdf::loadView('pdf.estado_cuenta_cliente', ['data' => $data]);
        return $pdf->stream('estado_cuenta_cliente_' . $data['cliente']['nombre_empresa'] . '.pdf');
    }

    public function generarEstadoCuentaCliente(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $cliente = Cliente::findOrFail($request->cliente_id);
        $sucursales = Sucursal::where('cliente_id', $cliente->id)->get();

        $data = [
            'cliente' => $cliente->toArray(),
            'periodo' => [
                'inicio' => $request->fecha_inicio,
                'fin' => $request->fecha_fin,
            ],
            'sucursales' => [],
            'resumen' => [
                'ventas' => [
                    'total' => 0,
                    'pagadas' => 0,
                    'pendientes' => 0,
                    'vencidas' => 0,
                    'canceladas' => 0,
                ],
                'cotizaciones' => [
                    'aceptadas' => 0,
                    'no_aceptadas' => 0,
                    'pendientes' => 0,
                ]
            ]
        ];

        foreach ($sucursales as $sucursal) {
            $cotizaciones = Cotizacion::where('sucursal_id', $sucursal->id)
                ->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])
                ->get();

            $cotizacionesData = [];
            $ventasData = [];

            foreach ($cotizaciones as $cotizacion) {
                $cotizacionesData[] = $cotizacion->toArray();

                switch (strtolower(trim($cotizacion->aceptada))) {
                    case 'si':
                        $data['resumen']['cotizaciones']['aceptadas']++;
                        break;
                    case 'no':
                        $data['resumen']['cotizaciones']['no_aceptadas']++;
                        break;
                    case 'pendiente':
                        $data['resumen']['cotizaciones']['pendientes']++;
                        break;
                }

                $venta = Venta::where('cotizacion_id', $cotizacion->id)->first();

                if ($venta) {
                    $ventaArray = $venta->toArray();
                    $estatusOriginal = strtolower(trim($venta->estatus));

                    // Asegurar que se mapea correctamente
                    $mapEstatus = [
                        'pagada' => 'pagadas',
                        'pendiente' => 'pendientes',
                        'vencida' => 'vencidas',
                        'cancelada' => 'canceladas'
                    ];

                    $estatus = $mapEstatus[$estatusOriginal] ?? null;

                    // Agregar días de crédito si aplica
                    if ($venta->tipo_pago === 'Crédito') {
                        $ventaArray['dias_credito'] = $cotizacion->credito_dias;
                    }

                    // Limpiar fecha de vencimiento si no es crédito
                    if ($venta->tipo_pago !== 'Crédito') {
                        $ventaArray['fecha_vencimiento'] = null;
                    }

                    $ventasData[] = $ventaArray;

                    if ($estatus) {
                        $data['resumen']['ventas']['total'] += $venta->total;
                        $data['resumen']['ventas'][$estatus] += $venta->total;
                    }
                }
            }

            $data['sucursales'][] = [
                'sucursal' => $sucursal->toArray(),
                'cotizaciones' => $cotizacionesData,
                'ventas' => $ventasData,
            ];
        }

        return $data;
    }

    public function generarPdfEstadoCuentaProveedor(Request $request)
    {
        $data = $this->generarEstadoCuentaProveedor($request)->getData(true);
        $pdf = Pdf::loadView('pdf.estado_cuenta_proveedor', ['data' => $data]);
        return $pdf->stream('estado_cuenta_proveedor_' . $data['proveedor']['nombre_empresa'] . '.pdf');
    }

    public function generarEstadoCuentaProveedor(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $proveedor = Proveedor::findOrFail($request->proveedor_id);

        $ordenes = OrdenCompra::with(['articulo', 'banco'])
            ->where('proveedor_id', $proveedor->id)
            ->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])
            ->get();

        $resumen = [
            'total' => 0,
            'pagadas' => 0,
            'pendientes' => 0,
            'vencidas' => 0,
            'canceladas' => 0,
            'por_pagar' => 0,
        ];

        $estatusMap = [
            'Pagada' => 'pagadas',
            'Pendiente' => 'pendientes',
            'Vencida' => 'vencidas',
            'Cancelada' => 'canceladas'
        ];

        $ordenes_formateadas = $ordenes->map(function ($orden) use (&$resumen, $proveedor, $estatusMap) {
            $resumen['total'] += $orden->total;

            $claveResumen = $estatusMap[$orden->estatus] ?? null;
            if ($claveResumen) {
                $resumen[$claveResumen] += $orden->total;
            }

            $fecha_vencimiento = null;
            if ($proveedor->credito_dias) {
                $fecha_vencimiento = Carbon::parse($orden->created_at)->addDays($proveedor->credito_dias);

                if (now()->greaterThan($fecha_vencimiento)) {
                    $resumen['vencidas'] += $orden->total;
                }
            }

            return [
                'numero_oc' => $orden->numero_oc,
                'fecha' => Carbon::parse($orden->created_at)->format('d/m/Y'),
                'articulo' => $orden->articulo->nombre ?? '-',
                'cantidad' => $orden->cantidad_articulo,
                'precio' => $orden->precio_articulo,
                'subtotal' => $orden->subtotal,
                'total' => $orden->total,
                'impuesto' => $orden->impuesto ? 'Sí' : 'No',
                'metodo_pago' => $orden->metodo_pago,
                'banco' => $orden->banco->nombre ?? '-',
                'estatus' => $orden->estatus,
                'fecha_vencimiento' => $fecha_vencimiento ? $fecha_vencimiento->format('d/m/Y') : 'N/A'
            ];
        });

        $resumen['por_pagar'] = $resumen['pendientes'] + $resumen['vencidas'];

        return response()->json([
            'proveedor' => $proveedor,
            'periodo' => [
                'inicio' => $request->fecha_inicio,
                'fin' => $request->fecha_fin
            ],
            'ordenes' => $ordenes_formateadas,
            'resumen' => $resumen,
        ]);
    }

    public function generarPdfEstadoCuentaBanco(Request $request)
    {
        $data = $this->generarEstadoCuentaBanco($request)->getData(true);
        $pdf = Pdf::loadView('pdf.estado_cuenta_banco', ['data' => $data]);
        return $pdf->stream('estado_cuenta_banco_' . $data['banco']['nombre'] . '.pdf');
    }

    public function generarEstadoCuentaBanco(Request $request)
    {
        $request->validate([
            'banco_id' => 'required|exists:bancos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $banco = Banco::findOrFail($request->banco_id);
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);

        // Movimientos bancarios
        $movimientos = MovimientoBancario::where('banco_id', $banco->id)
            ->whereBetween('fecha', [$inicio, $fin])
            ->orderBy('fecha')
            ->get();

        // Gastos
        $gastos = Gasto::with(['modulo_concepto'])->where('banco_id', $banco->id)
            ->whereBetween('created_at', [$inicio, $fin])
            ->get();

        // Órdenes de compra pagadas
        $ordenes = OrdenCompra::with(['proveedor', 'banco', 'articulo'])->where('banco_id', $banco->id)
            ->where('estatus', 'Pagada')
            ->whereBetween('created_at', [$inicio, $fin])
            ->get();

        // Ventas pagadas
        $ventas = Venta::with(['cotizacion.sucursal', 'cotizacion.sucursal_empresa', 'banco'])
            ->where('eliminado', false)
            ->where('estatus', 'Pagada')
            ->where('banco_id', $banco->id)
            ->whereBetween('created_at', [$inicio, $fin])
            ->get();

        // Calcular totales
        $totalIngresos = $movimientos->where('tipo_movimiento', 'Ingreso')->sum('monto');
        $totalEgresos = $movimientos->where('tipo_movimiento', 'Egreso')->sum('monto');

        $balance = $totalIngresos - $totalEgresos;

        return response()->json([
            'banco' => $banco,
            'periodo' => [
                'inicio' => $inicio->toDateString(),
                'fin' => $fin->toDateString(),
            ],
            'movimientos' => $movimientos,
            'gastos' => $gastos,
            'ordenes_compra' => $ordenes,
            'ventas' => $ventas,
            'resumen' => [
                'ingresos' => $totalIngresos,
                'egresos' => $totalEgresos,
                'balance' => $balance,
            ]
        ]);
    }
}