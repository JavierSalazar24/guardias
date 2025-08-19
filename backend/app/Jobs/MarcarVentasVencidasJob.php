<?php

namespace App\Jobs;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MarcarVentasVencidasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $now = now()->toDateString();

        // Encuentra ventas que ya vencieron y siguen pendientes
        $ventas = Venta::where('estatus', 'Pendiente')->whereDate('fecha_vencimiento', '<', $now)->get();

        try {
            foreach ($ventas as $venta) {
                $venta->estatus = 'Vencida';
                $venta->save();

                Log::info("Venta ID {$venta->id} marcada como vencida desde los JOBS.");
            }
        } catch (\Exception $e) {
            $this->error("Error al actualizar ventas: " . $e->getMessage());
        }
    }
}
