<?php

namespace Database\Factories;

use App\Models\Gasto;
use App\Models\Banco;
use App\Models\ModuloConcepto;
use Illuminate\Database\Eloquent\Factories\Factory;

class GastoFactory extends Factory
{
    protected $model = Gasto::class;

    public function definition()
    {
        $subtotal = $this->faker->randomFloat(2, 100, 1000);
        $impuesto = $this->faker->boolean;
        $total = $impuesto ? $subtotal * 0.16 : $subtotal;

        return [
            'banco_id' => Banco::factory(),
            'modulo_concepto_id' => ModuloConcepto::factory(),
            'metodo_pago' => $this->faker->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']),
            'impuesto' => $impuesto,
            'subtotal' => $subtotal,
            'total' => $total,
        ];
    }
}