<?php

namespace Database\Seeders;

use App\Models\Articulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articulos = [
            'Fornitura', 'Celular', 'Radio', 'Garret',
            'Impermeable', 'Botas', 'Plumas', 'Caparas', 'Equipo c-Pat'
        ];

        foreach ($articulos as $nombre) {
            Articulo::factory()->create(['nombre' => $nombre]);
        }
    }
}
