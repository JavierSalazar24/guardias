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
            BancosSeeder::class,
            SucursalEmpresaSeeder::class,
            GuardiasSeeder::class,
            BlackListSeeder::class,
            RecursosHumanosSeeder::class,
            ClientesSeeder::class,
            SucursalesSeeder::class,
            ProveedoresSeeder::class,
            TipoServicioSeeder::class,
            CotizacionesSeeder::class,
            VentasSeeder::class,
            OrdenServicioSeeder::class,
            VehiculosSeeder::class,
            BoletaGasolinaSeeder::class,
            ArticulosSeeder::class,
            AlmacenSeeder::class,
            EquipamientoSeeder::class,
            OrdenesCompraSeeder::class,
            ComprasSeeder::class,
            ModuloConceptoSeeder::class,
            GastosSeeder::class,
            MovimientosBancariosSeeder::class,
            // QRGeneradoSeeder::class,
            // ReporteServicioSeeder::class,
        ]);
    }
}