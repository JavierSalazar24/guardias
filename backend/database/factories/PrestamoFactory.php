<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prestamo>
 */
class PrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fechaPrestamo = $this->faker->dateTimeBetween('-1 year', 'now');
        $numeroPagos = $this->faker->numberBetween(2, 6);
        $montoTotal = $this->faker->randomFloat(2, 2000, 20000);
        $pagosRealizados = $this->faker->numberBetween(0, $numeroPagos);

        // Simulación inicial, el saldo y el estatus se ajustan en el Seeder según los abonos
        $saldoRestante = $montoTotal;
        $estatus = 'Pendiente';
        $fechaPagado = null;

        $metodoPago = $this->faker->randomElement([
            'Transferencia bancaria',
            'Tarjeta de crédito/débito',
            'Efectivo',
            'Cheques'
        ]);
        $referencia = in_array($metodoPago, ['Transferencia bancaria', 'Tarjeta de crédito/débito']) ? $this->faker->bothify('REF-####') : null;

        return [
            // 'banco_id', 'guardia_id', 'modulo_prestamo_id' se asignan en el Seeder
            'monto_total' => $montoTotal,
            'saldo_restante' => $saldoRestante, // Se actualizará en el Seeder después de abonos
            'numero_pagos' => $numeroPagos,
            'fecha_prestamo' => $fechaPrestamo->format('Y-m-d'),
            'fecha_pagado' => $fechaPagado,
            'observaciones' => $this->faker->optional()->sentence(10),
            'metodo_pago' => $metodoPago,
            'referencia' => $referencia,
            'estatus' => $estatus,
        ];
    }
}
