<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\OrdenServicio;
use App\Models\QRGenerado;
use App\Models\QRPuntoRecorrido;

class QRGeneradoSeeder extends Seeder
{
    public function run()
    {
        $ordenesServicio = OrdenServicio::all();

        foreach ($ordenesServicio as $orden) {
            // Cantidad aleatoria de puntos QR entre 3 y 8
            $cantidad = rand(3, 8);

            // Crear QR Generado
            $qrGenerado = QRGenerado::create([
                'orden_servicio_id' => $orden->id,
                'cantidad' => $cantidad,
                'notas' => 'QRs generados automáticamente para pruebas'
            ]);

            // Generar los puntos (igual que en tu controlador)
            for ($i = 1; $i <= $cantidad; $i++) {
                QRPuntoRecorrido::create([
                    'qr_generado_id' => $qrGenerado->id,
                    'nombre_punto' => "Punto $i",
                    'codigo_qr' => Str::uuid(),
                ]);
            }
        }
    }
}
