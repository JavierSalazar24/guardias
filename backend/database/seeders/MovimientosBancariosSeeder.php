<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MovimientoBancario;
use App\Models\Banco;

class MovimientosBancariosSeeder extends Seeder
{
    public function run(): void
    {
         $bancos = Banco::all();

        foreach ($bancos as $banco) {
            $existeSaldoInicial = MovimientoBancario::where('banco_id', $banco->id)
                ->where('concepto', 'Saldo inicial')
                ->exists();

            if (!$existeSaldoInicial) {
                MovimientoBancario::create([
                    'banco_id'        => $banco->id,
                    'tipo_movimiento' => 'Ingreso',
                    'concepto'        => 'Saldo inicial',
                    'fecha'           => now()->format('Y-m-d'),
                    'referencia'      => null,
                    'monto'           => $banco->saldo_inicial ?? 10000,
                    'metodo_pago'     => 'Efectivo',
                    'origen_id'       => null,
                    'origen_type'     => null,
                ]);
            }
        }
    }
}
