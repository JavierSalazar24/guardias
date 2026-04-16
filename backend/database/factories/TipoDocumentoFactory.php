<?php

namespace Database\Factories;

use App\Models\TipoDocumento;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoDocumentoFactory extends Factory
{
    protected $model = TipoDocumento::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->words(2, true),
            'descripcion' => fake()->optional()->sentence(),
        ];
    }
}
