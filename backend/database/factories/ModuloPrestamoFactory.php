<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ModuloPrestamo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModuloPrestamo>
 */
class ModuloPrestamoFactory extends Factory
{
    protected $model = ModuloPrestamo::class;

    public function definition()
    {
        $nombres = [
            'Préstamo personal',
            'Préstamo de emergencia',
            'Préstamo de vivienda',
            'Préstamo de vehículo',
            'Préstamo médico',
            'Préstamo por defunción',
            'Préstamo escolar',
            'Préstamo por boda',
            'Préstamo por nacimiento',
            'Préstamo especial'
        ];

        static $index = 0;
        $nombre = $nombres[$index % count($nombres)];
        $index++;

        return [
            'nombre' => $nombre,
            'descripcion' => $this->faker->sentence(6)
        ];
    }
}
