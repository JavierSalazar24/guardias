<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Descuento>
 */
class DescuentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fecha = $this->faker->dateTimeBetween('-1 year', 'now');
        $monto = $this->faker->randomFloat(2, 100, 1500);

        return [
            // 'guardia_id' y 'modulo_descuento_id' se asignan en el Seeder
            'monto' => $monto,
            'fecha' => $fecha->format('Y-m-d'),
            'observaciones' => $this->faker->optional()->sentence(10),
        ];
    }
}
