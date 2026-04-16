<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QrGenerado>
 */
class QrGeneradoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cantidad' => $this->faker->numberBetween(1, 10),
            'notas' => $this->faker->optional()->sentence(),
        ];
    }
}
