<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BoletaGasolina;
use App\Models\Banco;
use App\Models\Vehiculo;

class BoletaGasolinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bancos = Banco::all();
        $vehiculos = Vehiculo::all();

        // Creamos 13 boletas de gasolina, escogiendo banco y vehículo aleatorio en cada una
        for ($i = 0; $i < 13; $i++) {
            BoletaGasolina::factory()->create([
                'banco_id' => $bancos->random()->id,
                'vehiculo_id' => $vehiculos->random()->id,
            ]);
        }
    }
}
