<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacacion>
 */
class VacacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fechaInicio = $this->faker->dateTimeBetween('-1 year', 'now');
        $diasTotales = $this->faker->numberBetween(3, 15);
        $fechaFin = (clone $fechaInicio)->modify("+$diasTotales days");
        $prima = $this->faker->randomFloat(2, 200, 2000);

        return [
            // 'guardia_id' se asigna desde el Seeder
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'dias_totales' => $diasTotales,
            'prima_vacacional' => $prima,
            'observaciones' => $this->faker->optional()->sentence(8),
        ];
    }
}
