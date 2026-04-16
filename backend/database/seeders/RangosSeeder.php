<?php

namespace Database\Seeders;

use App\Models\Rango;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RangosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 3 rangos predefinidos Guardias - Supervisor - Jefe de turno
        $rangos = ['Guardia', 'Supervisor', 'Jefe de turno'];
        foreach ($rangos as $rango) {
            Rango::create([
                'nombre' => $rango,
                'descripcion' => "Rango de $rango",
            ]);
        }
    }
}
