<?php

namespace Database\Factories;

use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehiculoFactory extends Factory
{
    protected $model = Vehiculo::class;

    public function definition()
    {
        return [
            'tipo_vehiculo' => $this->faker->randomElement(['Carro', 'Motocicleta']),
            'marca' => $this->faker->company,
            'modelo' => $this->faker->word,
            'color' => $this->faker->safeColorName,
            'placas' => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{3}'),

            'fotos_vehiculo' => 'fotos.zip',
            'rotulado' => $this->faker->randomElement(['SI', 'NO']),
            'gps' => $this->faker->randomElement(['SI', 'NO']),
            'torreta' => $this->faker->randomElement(['SI', 'NO']),
            'impuestos_pagados' => $this->faker->randomElement(['SI', 'NO']),

            'aseguradora' => $this->faker->company,
            'telefono_aseguradora' => $this->faker->numerify('##########'),
            'archivo_seguro' => 'archivo.pdf',
            'numero_poliza' => $this->faker->bothify('POL#######'),
            'fecha_vencimiento' => $this->faker->date(),
        ];
    }
}
