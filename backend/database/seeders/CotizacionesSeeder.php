<?php

namespace Database\Seeders;

use App\Models\Cotizacion;
use App\Models\SucursalEmpresa;
use App\Models\Sucursal;
use App\Models\TipoServicio;
use App\Models\ServicioCotizacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CotizacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursalesEmpresa = SucursalEmpresa::all();
        $sucursales = Sucursal::all();
        $tiposServicio = TipoServicio::all();

        for ($i = 0; $i < 15; $i++) {
            $sucursalEmpresa = $sucursalesEmpresa->random();
            $sucursal = $sucursales->random();

            $cotizacion = Cotizacion::factory()->create([
                'sucursal_empresa_id' => $sucursalEmpresa->id,
                'sucursal_id' => $sucursal->id,
                'precio_total_servicios' => 0,
            ]);

            $serviciosAleatorios = $tiposServicio->random(rand(1, 3));
            $sumaServicios = 0;

            foreach ($serviciosAleatorios as $tipoServicio) {
                ServicioCotizacion::create([
                    'cotizacion_id' => $cotizacion->id,
                    'tipo_servicio_id' => $tipoServicio->id,
                ]);
                $sumaServicios += $tipoServicio->costo;
            }

            $cotizacion->update([
                'precio_total_servicios' => $sumaServicios,
            ]);
        }
    }
}
