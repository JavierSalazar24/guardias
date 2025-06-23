<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FullSistemaSeeder::class,
            SucursalEmpresaSeeder::class,
            GuardiasSeeder::class,
            ClientesSeeder::class,
            SucursalesSeeder::class,
            ArticulosSeeder::class,
            ProveedoresSeeder::class,
            BancosSeeder::class,
            MovimientosBancariosSeeder::class,
            VehiculosSeeder::class,
            CotizacionesSeeder::class,
            // VentasSeeder::class,
            // GastosSeeder::class,
            // OrdenesCompraSeeder::class,
            // ComprasSeeder::class,
            AlmacenSeeder::class,
        ]);
    }
}
