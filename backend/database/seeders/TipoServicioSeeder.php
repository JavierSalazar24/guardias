<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoServicio;

class TipoServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicios = [
            ['nombre' => 'Vigilancia', 'costo' => 2000, 'descripcion' => 'Servicio de vigilancia general.'],
            ['nombre' => 'Escolta', 'costo' => 4500, 'descripcion' => 'Acompañamiento personal y protección.'],
            ['nombre' => 'Rondín', 'costo' => 1500, 'descripcion' => 'Recorridos periódicos por la zona.'],
            ['nombre' => 'Supervisión', 'costo' => 1800, 'descripcion' => 'Supervisión de instalaciones.'],
            ['nombre' => 'Recepción', 'costo' => 1200, 'descripcion' => 'Control de accesos y recepción.'],
        ];

        foreach ($servicios as $servicio) {
            TipoServicio::create($servicio);
        }
    }
}
