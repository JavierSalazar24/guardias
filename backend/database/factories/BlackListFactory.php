<?php

namespace Database\Factories;
use App\Models\Guardia;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlackList>
 */
class BlackListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fecha_baja' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'motivo_baja' => $this->faker->randomElement([
                'Incumplimiento de normas',
                'Faltas injustificadas',
                'Problemas de actitud',
                'Robo',
                'Reporte negativo del cliente',
                'Ausencia prolongada'
            ]),
        ];
    }
}
