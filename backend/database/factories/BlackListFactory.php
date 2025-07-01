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
            // El guardia_id lo asignaremos en el Seeder, no aquí
            'motivo_baja' => $this->faker->randomElement([
            'Incumplimiento de normas',
            'Faltas injustificadas',
            'Problemas de actitud',
            'Robo',
            'Reporte negativo del cliente',
            'Ausencia prolongada'
        ]),
        // No ponemos guardia_id aquí porque debe ser único y controlado por el Seeder
    ];
    }
}
