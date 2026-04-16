<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ModuloDescuento;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModuloDescuento>
 */
class ModuloDescuentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ModuloDescuento::class;

    public function definition()
    {
        $nombres = [
            'Descuento por daños a propiedad de la empresa',
            'Descuento por uniforme roto',
            'Descuento por préstamo personal',
            'Descuento por adelanto de sueldo',
            'Descuento por daños a equipo',
            'Descuento por pérdida de herramientas',
            'Descuento por capacitación',
            'Descuento por herramientas',
            'Descuento por retardo',
            'Descuento por equipo perdido'
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
