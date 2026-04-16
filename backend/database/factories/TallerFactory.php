<?php
// database/factories/TallerFactory.php

namespace Database\Factories;

use App\Models\Taller;
use Illuminate\Database\Eloquent\Factories\Factory;

class TallerFactory extends Factory
{
    protected $model = Taller::class;

    public function definition(): array
    {
        return [
            'nombre' => 'Taller genérico',
            'direccion' => 'Dirección pendiente de asignación',
        ];
    }
}
