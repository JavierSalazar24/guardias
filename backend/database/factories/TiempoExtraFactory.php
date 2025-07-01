<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TiempoExtra>
 */
class TiempoExtraFactory extends Factory
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
        $horas = $this->faker->randomFloat(2, 1, 12);
        $montoHora = $this->faker->randomFloat(2, 30, 150);

        return [
            // 'guardia_id' se asigna desde el Seeder
            'horas' => $horas,
            'monto_por_hora' => $montoHora,
            'monto_total' => $horas * $montoHora,
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
        ];
    }
}
