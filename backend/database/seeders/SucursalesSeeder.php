<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use App\Models\Cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::all()->each(function ($cliente) {
            Sucursal::factory()->count(1)->create(['cliente_id' => $cliente->id]);
        });
    }
}
