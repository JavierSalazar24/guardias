<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prestamo;
use App\Models\Guardia;
use App\Models\Banco;
use App\Models\ModuloPrestamo;

class PrestamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guardias = Guardia::where('eliminado', false)->inRandomOrder()->take(5)->get();
        $bancos = Banco::all();
        $tiposPrestamo = ModuloPrestamo::all();

        foreach ($guardias as $guardia) {
            Prestamo::factory()->create([
                'banco_id' => $bancos->random()->id,
                'guardia_id' => $guardia->id,
                'modulo_prestamo_id' => $tiposPrestamo->random()->id,
            ]);
        }
    }
}
