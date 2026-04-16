<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LimpiarLimpiezaLogsAntiguos extends Command
{
    protected $signature = 'limpiar:limpiezaslogs';
    protected $description = 'Elimina registros de limpiezas_logs con antigüedad de un año o más.';

    public function handle()
    {
        $fechaLimite = now()->subYear();
        $total = DB::table('limpiezas_logs')->where('created_at', '<', $fechaLimite)->count();

        if ($total === 0) {
            $this->info("No hay registros de limpiezas_logs para eliminar.");
            return 0;
        }

        try {
            $eliminados = DB::table('limpiezas_logs')
                ->where('created_at', '<', $fechaLimite)
                ->delete();

            $this->info("Se eliminaron {$eliminados} registros antiguos de limpiezas_logs.");
        } catch (\Exception $e) {
            $this->error("Error al eliminar en limpiezas_logs: " . $e->getMessage());
        }

        return 0;
    }
}
