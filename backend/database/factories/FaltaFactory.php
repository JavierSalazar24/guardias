<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Falta>
 */
class FaltaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fechaInicio = $this->faker->dateTimeBetween('-1 year', 'now');
        $fechaFin = (clone $fechaInicio)->modify('+1 day');
        $cantidadFaltas = $this->faker->numberBetween(1, 3);
        $descuentoFalta = $this->faker->randomFloat(2, 100, 500);
        $monto = $cantidadFaltas * $descuentoFalta;

        return [
            // 'guardia_id' se asigna desde el Seeder
            'cantidad_faltas' => $cantidadFaltas,
            'descuento_falta' => $descuentoFalta,
            'monto' => $monto,
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
        ];
    }
}
