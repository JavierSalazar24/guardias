<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incapacidad>
 */
class IncapacidadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fechaInicio = $this->faker->dateTimeBetween('-2 years', 'now');
        $fechaFin = (clone $fechaInicio)->modify('+'.rand(3,10).' days');

        return [
            // 'guardia_id' se asigna desde el Seeder
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'pago_empresa' => $this->faker->randomFloat(2, 100, 2000),
            'motivo' => $this->faker->randomElement(['Enfermedad', 'Accidente', 'Maternidad', 'COVID', 'Cirugía']),
            'observaciones' => $this->faker->optional()->sentence(8),
        ];
    }
}
