<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecursosHumanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Catálogos base (deben ir primero)
        $this->call(ModuloDescuentoSeeder::class);
        $this->call(ModuloPrestamoSeeder::class);

        // 2. Movimientos principales ligados a guardias
        $this->call(IncapacidadSeeder::class);
        $this->call(TiempoExtraSeeder::class);
        $this->call(FaltaSeeder::class);
        $this->call(VacacionSeeder::class);

        // 3. Tablas que requieren catálogo previo
        $this->call(DescuentoSeeder::class);
        $this->call(PrestamoSeeder::class);

        // 4. Abonos de préstamo
        $this->call(AbonoPrestamoSeeder::class);

        // 5. Pagos a los guardias.
        $this->call(PagoEmpleadoSeeder::class);
    }
}
