<?php

namespace Database\Factories;

use App\Models\SucursalEmpresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SucursalEmpresaFactory extends Factory
{
    protected $model = SucursalEmpresa::class;

    public function definition()
    {
        return [
            'nombre_sucursal' => $this->faker->company,
            'calle' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'colonia' => $this->faker->word,
            'cp' => $this->faker->numerify('#####'),
            'municipio' => $this->faker->city,
            'estado' => $this->faker->state,
            'pais' => $this->faker->country,
            'telefono_sucursal' => $this->faker->numerify('##########'),
            'extension_sucursal' => $this->faker->optional()->numerify('###'),

            'nombre_contacto' => $this->faker->name,
            'telefono_contacto' => $this->faker->numerify('##########'),
            'whatsapp_contacto' => $this->faker->numerify('##########'),
            'correo_contacto' => $this->faker->unique()->safeEmail,
        ];
    }
}
