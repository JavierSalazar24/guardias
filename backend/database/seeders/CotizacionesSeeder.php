<?php

namespace Database\Seeders;

use App\Models\Cotizacion;
use App\Models\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CotizacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sucursal::all()->each(function ($sucursal) {
            Cotizacion::factory()->count(1)->create(['sucursal_id' => $sucursal->id]);
        });
    }
}
