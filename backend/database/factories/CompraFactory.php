<?php

namespace Database\Factories;

use App\Models\OrdenCompra;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    public function definition(): array
    {
        return [
            'orden_compra_id' => OrdenCompra::where('estatus', 'Pagada')->inRandomOrder()->first()->id ?? OrdenCompra::factory()->create(['estatus' => 'Pagada'])->id,
        ];
    }
}
