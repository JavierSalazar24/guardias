<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReporteServicioSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CheckGuardiaSeeder::class,
            ReporteBitacoraSeeder::class,
            ReporteIncidenteGuardiaSeeder::class,
            ReporteGuardiaSeeder::class,
            ReporteSupervisorSeeder::class,
            ReportePatrullaSeeder::class,
            QRRecorridoGuardiaSeeder::class,
        ]);
    }
}
