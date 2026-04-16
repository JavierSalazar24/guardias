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
        $articulosGuardia = [
            'Fornitura', 'Celular', 'Radio', 'Garret','Impermeable', 'Botas', 'Plumas', 'Equipo c-Pat', 'Linterna', 'Cargador de radio',
        ];

        $articulosServicio = [
            'Extintor', 'Conos de seguridad', 'Cinta de seguridad', 'Botiquín de primeros auxilios', 'Señal de advertencia', 'Triángulo de emergencia',
        ];

        foreach ($articulosGuardia as $nombre) {
            Articulo::factory()->create(['nombre' => $nombre, 'articulo_equipar' => 'Guardia']);
        }

        foreach ($articulosServicio as $nombre) {
            Articulo::factory()->create(['nombre' => $nombre, 'articulo_equipar' => 'Servicio']);
        }
    }
}
