<?php

namespace Database\Factories;

use App\Models\AlmacenEntrada;
use App\Models\Articulo;
use App\Models\Guardia;
use App\Models\OrdenServicio;
use App\Models\OrdenCompra;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlmacenEntradaFactory extends Factory
{
    protected $model = AlmacenEntrada::class;

    public function definition(): array
    {
        $tipoEntrada = $this->faker->randomElement([
            'Compra', 'Devolución de guardia', 'Devolución de servicio', 'Cambio de equipo', 'Reparación terminada', 'Otro'
        ]);

        $articuloGuardia = Articulo::inRandomOrder()->where('articulo_equipar', '=', 'Guardia')->first()?->id;
        $articuloServicio = Articulo::inRandomOrder()->where('articulo_equipar', '=', 'Servicio')->first()?->id;

        $isCompra = $tipoEntrada === 'Compra';
        $isOtro = $tipoEntrada === 'Otro';

        return [
            'guardia_id' => $tipoEntrada === 'Devolución de guardia' ? Guardia::inRandomOrder()->first()?->id : null,
            'orden_servicio_id' => $tipoEntrada === 'Devolución de servicio' ? OrdenServicio::inRandomOrder()->first()?->id : null,
            'articulo_id' => $tipoEntrada === 'Devolución de guardia' ? $articuloGuardia : ($tipoEntrada === 'Devolución de servicio' ? $articuloServicio : Articulo::inRandomOrder()->first()?->id),
            'numero_serie' => strtoupper($this->faker->bothify('SERIE-####')),
            'fecha_entrada' => $this->faker->date(),
            'tipo_entrada' => $tipoEntrada,
            'otros_conceptos' => $isOtro ? $this->faker->sentence() : null,
            'orden_compra' => $isCompra ? OrdenCompra::inRandomOrder()->first()?->numero_oc : null,
        ];
    }
}
