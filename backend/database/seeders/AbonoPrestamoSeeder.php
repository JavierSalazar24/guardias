<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AbonoPrestamo;
use App\Models\Prestamo;
use App\Models\Banco;

class AbonoPrestamoSeeder extends Seeder
{
    public function run()
    {
        $prestamos = Prestamo::all();
        $bancos = Banco::all();
        $faker = \Faker\Factory::create();

        foreach ($prestamos as $prestamo) {
            // Decide aleatoriamente si el préstamo se pagará o quedará pendiente
            $seraPagado = $faker->boolean(); // true = pagado, false = pendiente

            // El número de abonos que intentamos hacer coincide con el campo 'numero_pagos'
            $numeroAbonos = $prestamo->numero_pagos;
            $montoRestante = $prestamo->monto_total;
            $abonosRealizados = 0;

            $abonos = [];
            $abonosSumados = 0;

            for ($i = 1; $i <= $numeroAbonos; $i++) {
                // Si ya no hay saldo pendiente, ya no generamos abonos extra
                if ($montoRestante <= 0) break;

                // Último abono: si será pagado, cuadra exacto; si pendiente, puede faltar un poco
                if ($i == $numeroAbonos) {
                    if ($seraPagado) {
                        $montoAbono = $montoRestante;
                    } else {
                        // Si pendiente, abona entre 40% y 90% del monto restante, y termina el ciclo
                        $montoAbono = $faker->randomFloat(2, 0.4 * $montoRestante, 0.9 * $montoRestante);
                    }
                } else {
                    // Abonos previos: aleatorios, pero nunca más del saldo restante ni menos de $1
                    $maxAbono = max(1, $montoRestante - ($numeroAbonos - $i));
                    $montoAbono = $faker->randomFloat(2, 1, $maxAbono);
                }

                $montoAbono = min($montoAbono, $montoRestante);

                // Crea el abono
                AbonoPrestamo::factory()->create([
                    'banco_id' => $bancos->random()->id,
                    'prestamo_id' => $prestamo->id,
                    'monto' => $montoAbono,
                ]);

                $abonosSumados += $montoAbono;
                $montoRestante -= $montoAbono;
                $abonosRealizados++;
            }

            // Ahora actualiza el préstamo según el resultado de los abonos
            $prestamo->saldo_restante = round($prestamo->monto_total - $abonosSumados, 2);

            if ($prestamo->saldo_restante <= 0.01 && $seraPagado) {
                $prestamo->saldo_restante = 0;
                $prestamo->estatus = 'Pagado';
                $prestamo->fecha_pagado = now();
            } else {
                $prestamo->estatus = 'Pendiente';
                $prestamo->fecha_pagado = null;
            }

            $prestamo->save();
        }
    }
}
