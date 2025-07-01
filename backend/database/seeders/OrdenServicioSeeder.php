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
        $ventas = Venta::whereIn('estatus', ['Pagada', 'Pendiente'])->take(2)->get();

        $primerEstatus = 'En proceso';
        $otrosEstatus = ['Finalizada', 'Cancelada'];

        $i = 0;
        foreach ($ventas as $venta) {
            // Escoge estatus para la orden: la primera siempre "En proceso", las demás random
            $estatus = $i === 0 ? $primerEstatus : collect($otrosEstatus)->random();

            // Simula fechas coherentes
            $fecha_inicio = Carbon::now()->subDays(rand(10, 20));
            $fecha_fin = null;
            if ($estatus === 'Finalizada') {
                $fecha_fin = (clone $fecha_inicio)->addDays(rand(1, 9));
            }

            // Crear la orden de servicio
            $ordenServicio = OrdenServicio::factory()->create([
                'venta_id' => $venta->id,
                'estatus' => $estatus,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
            ]);

            // Guardias de sucursal_empresa (simulación: 3 aleatorios activos)
            $guardias = Guardia::where('eliminado', false)->inRandomOrder()->take(3)->get();

            foreach ($guardias as $guardia) {
                OrdenServicioGuardia::create([
                    'orden_servicio_id' => $ordenServicio->id,
                    'guardia_id' => $guardia->id,
                ]);
            }
            $i++;
        }
    }
}
