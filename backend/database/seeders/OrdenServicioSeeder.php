<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrdenServicio;
use App\Models\OrdenServicioGuardia;
use App\Models\Venta;
use App\Models\Guardia;
use Carbon\Carbon;

class OrdenServicioSeeder extends Seeder
{
    public function run()
    {
        $ventas = Venta::whereIn('estatus', ['Pagada', 'Pendiente'])->take(30)->get();

        $primerEstatus = 'En proceso';
        $otrosEstatus = ['Finalizada', 'Cancelada', 'En proceso'];

        $i = 0;
        foreach ($ventas as $venta) {
            // Escoge estatus para la orden: la primera siempre "En proceso", las demás random
            $estatus = $i === 0 ? $primerEstatus : collect($otrosEstatus)->random();

            // Simula fechas coherentes
            $fecha_inicio = Carbon::now()->subDays(rand(10, 20));
            $fecha_fin = (clone $fecha_inicio)->addDays(60);

            // Crear la orden de servicio
            $ordenServicio = OrdenServicio::factory()->create([
                'venta_id' => $venta->id,
                'estatus' => $estatus,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
            ]);

            $cotizacion = $venta->cotizacion;
            $sucursalId = $venta->cotizacion->sucursal_empresa_id;

            $guardias = Guardia::where('eliminado', false)->where('estatus', 'Disponible')->where('sucursal_empresa_id', $sucursalId)->inRandomOrder()->get();
            $guardiasSeleccionados = collect();

            $cantidadGuardiasNormales = $cotizacion->cantidad_guardias;
            $guardiasNormales = $guardias->take($cantidadGuardiasNormales);
            $guardiasSeleccionados = $guardiasSeleccionados->merge($guardiasNormales);

            foreach ($guardiasSeleccionados as $guardia) {
                OrdenServicioGuardia::create([
                    'orden_servicio_id' => $ordenServicio->id,
                    'guardia_id' => $guardia->id,
                ]);

                // Actualizar estatus del guardia a "Asignado"
                $guardia->estatus = 'Asignado';
                $guardia->save();
            }

            $i++;
        }
    }
}
