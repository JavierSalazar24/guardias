<?php

namespace Database\Factories;

use App\Models\OrdenCompra;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    public function definition(): array
    {
        $metodo_pago =  $this->faker->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']);
        return [
            'orden_compra_id' => OrdenCompra::where('estatus', 'Pagada')->inRandomOrder()->first()->id ?? OrdenCompra::factory()->create(['estatus' => 'Pagada'])->id,
            'metodo_pago' => $metodo_pago,
            'referencia' => $metodo_pago === 'Transferencia bancaria' || $metodo_pago === 'Tarjeta de crédito/débito' ? $this->faker->bothify('REF-####') : null,
        ];
    }
}
