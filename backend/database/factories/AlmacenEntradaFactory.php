<?php

namespace Database\Factories;

use App\Models\AlmacenEntrada;
use App\Models\Articulo;
use App\Models\Guardia;
use App\Models\OrdenCompra;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlmacenEntradaFactory extends Factory
{
    protected $model = AlmacenEntrada::class;

    public function definition(): array
    {
        $tipoEntrada = $this->faker->randomElement([
            'Compra', 'Devolución de guardia', 'Cambio de equipo', 'Reparación terminada', 'Otro'
        ]);

        $isCompra = $tipoEntrada === 'Compra';
        $isOtro = $tipoEntrada === 'Otro';
        $isDevolucion = $tipoEntrada === 'Devolución de guardia';

        return [
            'guardia_id' => $isDevolucion ? Guardia::inRandomOrder()->first()?->id : null,
            'articulo_id' => Articulo::inRandomOrder()->first()?->id,
            'numero_serie' => strtoupper($this->faker->bothify('SERIE-####')),
            'fecha_entrada' => $this->faker->date(),
            'tipo_entrada' => $tipoEntrada,
            'otros_conceptos' => $isOtro ? $this->faker->sentence() : null,
            'orden_compra' => $isCompra ? OrdenCompra::inRandomOrder()->first()?->numero_oc : null,
        ];
    }
}
