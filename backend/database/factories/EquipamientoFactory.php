<?php

namespace Database\Factories;

use App\Models\Equipamiento;
use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipamientoFactory extends Factory
{
    public function definition()
    {
        return [
            'fornitura' => $this->faker->boolean,
            'celular' => $this->faker->boolean,
            'radio' => $this->faker->boolean,
            'garret' => $this->faker->boolean,
            'impermeable' => $this->faker->boolean,
            'botas' => $this->faker->boolean,
            'plumas' => $this->faker->boolean,
            'caparas' => $this->faker->boolean,
            'equipo_cpat' => $this->faker->boolean,
            'firma' => $this->faker->boolean,
            'otro' => $this->faker->optional()->word,
            'vehiculo_id' => Vehiculo::factory(),
        ];
    }
}
