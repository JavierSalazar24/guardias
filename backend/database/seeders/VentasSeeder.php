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
        $cotizaciones = Cotizacion::inRandomOrder()->take(10)->get();
        $bancos = Banco::all();

        foreach ($cotizaciones as $cotizacion) {
            $fechaEmision = now()->subDays(rand(1, 30));
            $fechaVencimiento = (clone $fechaEmision)->addDays(15);
            $tipoPago = fake()->randomElement(['Crédito', 'Contado']);
            $banco = $bancos->random();

            $venta = Venta::create([
                'banco_id' => $banco->id,
                'cotizacion_id' => $cotizacion->id,
                'numero_factura' => fake()->unique()->bothify('FAC-####'),
                'fecha_emision' => $fechaEmision,
                'fecha_vencimiento' => $fechaVencimiento,
                'total' => fake()->randomFloat(2, 1000, 5000),
                'nota_credito' => fake()->randomFloat(2, 0, 500),
                'tipo_pago' => $tipoPago,
                'metodo_pago' => fake()->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']),
                'estatus' => fake()->randomElement(['Pendiente', 'Pagada', 'Vencida', 'Cancelada']),
                'motivo_cancelada' => null,
                'eliminado' => false,
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