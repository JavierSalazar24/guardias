<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoServicio>
 */
class TipoServicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->word(),
            'costo' => $this->faker->randomFloat(2, 500, 8000),
            'descripcion' => $this->faker->optional()->sentence(),
        ];
    }
}
