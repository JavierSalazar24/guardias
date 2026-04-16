<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Descuento;
use App\Models\Guardia;
use App\Models\ModuloDescuento;

class DescuentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guardias = Guardia::where('eliminado', false)->inRandomOrder()->take(5)->get();
        $tiposDescuento = ModuloDescuento::all();

        foreach ($guardias as $guardia) {
            foreach ($tiposDescuento as $tipo) {
                Descuento::factory()->create([
                    'guardia_id' => $guardia->id,
                    'modulo_descuento_id' => $tipo->id,
                ]);
            }
        }
    }
}
