<?php

namespace Database\Seeders;

use App\Models\Cotizacion;
use App\Models\Banco;
use App\Models\Venta;
use App\Models\VentaHistorial;
use Illuminate\Database\Seeder;

class VentasSeeder extends Seeder
{
    public function run(): void
    {
        $cotizacionesAceptadas = Cotizacion::where('aceptada', 'SI')->inRandomOrder()->take(10)->get();
        $bancos = Banco::all();

        foreach ($cotizacionesAceptadas as $cotizacion) {
            $fechaEmision = now()->subDays(rand(1, 30));
            $fechaVencimiento = (clone $fechaEmision)->addDays(15);
            $tipoPago = fake()->randomElement(['Crédito', 'Contado']);
            $banco = $bancos->random();

            $venta = Venta::factory()->create([
                'cotizacion_id' => $cotizacion->id,
                'banco_id' => $banco->id,
                'fecha_emision' => $fechaEmision,
                'fecha_vencimiento' => $fechaVencimiento,
            ]);

            VentaHistorial::create([
                'venta_id' => $venta->id,
                'cotizacion_id' => $cotizacion->id,
                'banco_id' => $banco->id,
                'numero_factura' => $venta->numero_factura,
                'fecha_emision' => $venta->fecha_emision,
                'fecha_vencimiento' => $venta->fecha_vencimiento,
                'total' => $venta->total,
                'nota_credito' => $venta->nota_credito,
                'credito_dias' => $fechaEmision->diffInDays($fechaVencimiento),
                'tipo_pago' => $venta->tipo_pago,
                'metodo_pago' => $venta->metodo_pago,
                'estatus' => $venta->estatus,
                'motivo_cancelada' => $venta->motivo_cancelada,
                'accion' => 'Creación',
                'usuario_id' => 1,
            ]);
        }
    }
}
