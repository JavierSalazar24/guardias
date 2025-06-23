<?php

namespace Database\Seeders;

use App\Models\SucursalEmpresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SucursalEmpresa::factory()->count(5)->create();
    }
}
