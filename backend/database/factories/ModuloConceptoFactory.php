<?php

namespace Database\Factories;

use App\Models\ModuloConcepto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuloConceptoFactory extends Factory
{
    protected $model = ModuloConcepto::class;

    public function definition()
    {
        $nombre = 'Pago de ' . $this->faker->word;
        return [
            'nombre' => $nombre,
            'descripcion' => $this->faker->sentence(8, true),
        ];
    }
}