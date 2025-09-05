<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Banco,
    MovimientoBancario,
    Gasto,
    Compra,
    Venta,
    AbonoPrestamo,
    PagoEmpleado,
    Prestamo,
    BoletaGasolina
};

class MovimientosBancariosSeeder extends Seeder
{
    public function boot()
    {
        Relation::enforceMorphMap([
            'gasto'              => Gasto::class,
            'compra'             => Compra::class,
            'prestamos'          => Prestamo::class,
            'boletas_gasolina'   => BoletaGasolina::class,
            'pagos_empleados'    => PagoEmpleado::class,
            'abonos_prestamo'    => AbonoPrestamo::class,
            'venta'              => Venta::class,
        ]);
    }

    public function run(): void
    {
        /*───────────────────────────────────────────────────────────────────
         | 1. INGRESOS  →  Ventas  (estatus Pagado)
         ───────────────────────────────────────────────────────────────────*/
        Venta::with(['cotizacion.sucursal', 'cotizacion.sucursal_empresa', 'banco'])
            ->chunk(200, function ($ventas) {
                foreach ($ventas as $venta) {
                    MovimientoBancario::updateOrCreate(
                        [
                            'origen_type' => $venta->getMorphClass(), // respeta morph map
                            'origen_id'   => $venta->id,
                        ],
                        [
                            'banco_id'        => $venta->banco_id,
                            'tipo_movimiento' => 'Ingreso',
                            'concepto'        => 'Venta: ' . ($venta->numero_factura),
                            'fecha'           => $venta->fecha_emision,
                            'referencia'      => $venta->referencia,
                            'monto'           => $venta->total,
                            'metodo_pago'     => $venta->metodo_pago ?? 'Efectivo',
                        ]
                    );
                }
        });

        /** ------------------------------------------------------------------
         * 2. INGRESOS  →  ABONOS DE PRÉSTAMO DE GUARDIAS (parciales)
         * ----------------------------------------------------------------- */
        AbonoPrestamo::with(['prestamo.guardia', 'banco'])->chunk(200, function ($abonos) {
            foreach ($abonos as $abono) {
                MovimientoBancario::updateOrCreate(
                    [
                        'origen_type' => $abono->getMorphClass(),
                        'origen_id'   => $abono->id,
                    ],
                    [
                        'banco_id'        => $abono->banco_id,
                        'tipo_movimiento' => 'Ingreso',
                        'concepto'        => "Abono del préstamo del guardia: {$abono->prestamo->guardia->numero_empleado}",
                        'fecha'           => $abono->fecha,
                        'referencia'      => $abono->referencia,
                        'monto'           => $abono->monto,
                        'metodo_pago'     => $abono->metodo_pago,
                    ]
                );
            }
        });

        /** ------------------------------------------------------------------
         * 3. EGRESOS → GASTOS
         * ----------------------------------------------------------------- */
        Gasto::with('banco')->chunk(200, function ($gastos) {
            foreach ($gastos as $gasto) {
                MovimientoBancario::updateOrCreate(
                    [
                        'origen_type' => $gasto->getMorphClass(),
                        'origen_id'   => $gasto->id,
                    ],
                    [
                        'banco_id'        => $gasto->banco_id,
                        'tipo_movimiento' => 'Egreso',
                        'concepto'        => 'Gasto: '.$gasto->concepto?->nombre,
                        'fecha'           => $gasto->created_at->toDateString(),
                        'referencia'      => $gasto->referencia,
                        'monto'           => $gasto->total,
                        'metodo_pago'     => $gasto->metodo_pago,
                    ]
                );
            }
        });

        /** ------------------------------------------------------------------
         * 4. EGRESOS  →  COMPRAS  (ligadas a OC pagada)
         * ----------------------------------------------------------------- */
        Compra::with('orden_compra.banco')
            ->chunk(200, function ($compras) {
                foreach ($compras as $compra) {
                    $oc    = $compra->orden_compra;
                    $banco = $oc->banco;

                    MovimientoBancario::updateOrCreate(
                        [
                            'origen_type' => $compra->getMorphClass(),
                            'origen_id'   => $compra->id,
                        ],
                        [
                            'banco_id'        => $banco->id,
                            'tipo_movimiento' => 'Egreso',
                            'concepto'        => 'Compra: '.$oc->numero_oc,
                            'fecha'           => $compra->created_at->toDateString(),
                            'referencia'      => $compra->referencia,
                            'monto'           => $oc->total,
                            'metodo_pago'     => $compra->metodo_pago,
                        ]
                    );
                }
        });

        /** ------------------------------------------------------------------
         * 5. EGRESOS  →  PAGOS DE EMPLEADOS
         * ----------------------------------------------------------------- */
        PagoEmpleado::with(['banco', 'guardia'])->chunk(200, function ($pagos) {
            foreach ($pagos as $pago) {
                MovimientoBancario::updateOrCreate(
                    [
                        'origen_type' => $pago->getMorphClass(),
                        'origen_id'   => $pago->id,
                    ],
                    [
                        'banco_id'        => $pago->banco_id,
                        'tipo_movimiento' => 'Egreso',
                        'concepto'        => "Pago a empleado NE: {$pago->guardia->numero_empleado}",
                        'fecha'           => $pago->created_at->toDateString(),
                        'referencia'      => $pago->referencia,
                        'monto'           => $pago->pago_final,
                        'metodo_pago'     => $pago->metodo_pago,
                    ]
                );
            }
        });

        /** ------------------------------------------------------------------
         * 6. EGRESOS  →  PRÉSTAMOS A GUARDIAS
         * ----------------------------------------------------------------- */
        Prestamo::with(['guardia', 'abonos', 'modulo_prestamo', 'banco'])->chunk(200, function ($prestamos) {
            foreach ($prestamos as $prestamo) {
                $guardia = $prestamo->guardia;

                MovimientoBancario::updateOrCreate(
                    [
                        'origen_type' => $prestamo->getMorphClass(),
                        'origen_id'   => $prestamo->id,
                    ],
                    [
                        'banco_id'        => $prestamo->banco_id,
                        'tipo_movimiento' => 'Egreso',
                        'concepto'        => "Préstamo a guardia NE: {$guardia->numero_empleado}",
                        'fecha'           => $prestamo->fecha_prestamo,
                        'referencia'      => $prestamo->referencia,
                        'monto'           => $prestamo->monto_total,
                        'metodo_pago'     => $prestamo->metodo_pago,
                    ]
                );
            }
        });
    }
}
