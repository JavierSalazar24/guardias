<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AbonoPrestamo>
 */
class AbonoPrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fecha = $this->faker->dateTimeBetween('-1 year', 'now');
        $monto = $this->faker->randomFloat(2, 500, 5000);

        $metodoPago = $this->faker->randomElement([
            'Transferencia bancaria',
            'Tarjeta de crédito/débito',
            'Efectivo',
            'Cheques',
            'Descuento nómina',
            'Otro'
        ]);
        $referencia = in_array($metodoPago, ['Transferencia bancaria', 'Tarjeta de crédito/débito']) ? $this->faker->bothify('REF-####') : null;

        return [
            // 'banco_id', 'prestamo_id' se asignan en el Seeder
            'monto' => $monto,
            'fecha' => $fecha->format('Y-m-d'),
            'metodo_pago' => $metodoPago,
            'referencia' => $referencia,
            'observaciones' => $this->faker->optional()->sentence(10),
        ];
    }
}
