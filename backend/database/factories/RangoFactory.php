<?php

namespace Database\Factories;

use App\Models\RangoFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RangoFactoryFactory extends Factory
{
    protected $model = RangoFactory::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->randomElement(['Guardia', 'Supervisor', 'Jefe de turno']),
            'descripcion' => $this->faker->sentence,
        ];
    }
}
