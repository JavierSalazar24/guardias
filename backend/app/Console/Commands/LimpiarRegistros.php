<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\Models\LimpiezaProgramada;
use App\Models\LimpiezaLog;
use Illuminate\Support\Facades\Storage;

class LimpiarRegistros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limpiar:registros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta limpiezas programadas según configuración';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tablasConfig = config('limpiezas');
        $configs = LimpiezaProgramada::where('activa', true)->get();

        foreach ($configs as $config) {
            if (!isset($tablasConfig[$config->tabla])) {
                $this->warn("Tabla no permitida: {$config->tabla}");
                continue;
            }
            $tablaConf = $tablasConfig[$config->tabla];
            $model = $tablaConf['model'];

            $campoFecha = $tablaConf['campo_fecha'] ?? 'created_at';
            $query = $model::where($campoFecha, '<', $this->fechaLimite($config));

            // --- Soporte a condiciones múltiples (OR/AND) ---
            if (isset($tablaConf['condiciones'])) {
                $tipo = $tablaConf['condiciones_tipo'] ?? 'AND';

                if (strtoupper($tipo) === 'OR') {
                    $query->where(function ($q) use ($tablaConf) {
                        foreach ($tablaConf['condiciones'] as $cond) {
                            $campo = $cond['campo'];
                            $operador = $cond['operador'];
                            $valor = $cond['valor'];
                            if ($operador === '!= null') {
                                $q->orWhereNotNull($campo);
                            } elseif ($operador === 'LIKE') {
                                $q->orWhere($campo, 'like', $valor);
                            } elseif ($operador === 'IN') {
                                $q->orWhereIn($campo, $valor);
                            } else {
                                $q->orWhere($campo, $operador, $valor);
                            }
                        }
                    });
                } else { // AND (default)
                    foreach ($tablaConf['condiciones'] as $cond) {
                        $campo = $cond['campo'];
                        $operador = $cond['operador'];
                        $valor = $cond['valor'];
                        if ($operador === '!= null') {
                            $query->whereNotNull($campo);
                        } elseif ($operador === 'LIKE') {
                            $query->where($campo, 'like', $valor);
                        } elseif ($operador === 'IN') {
                            $query->whereIn($campo, $valor);
                        } else {
                            $query->where($campo, $operador, $valor);
                        }
                    }
                }
            } elseif (isset($tablaConf['condicion'])) {
                // Compatibilidad con el formato anterior (una sola condición)
                $cond = $tablaConf['condicion'];
                $campo = $cond['campo'];
                $operador = $cond['operador'];
                $valor = $cond['valor'];
                if ($operador === '!= null') {
                    $query->whereNotNull($campo);
                } elseif ($operador === 'LIKE') {
                    $query->where($campo, 'like', $valor);
                } elseif ($operador === 'IN') {
                    $query->whereIn($campo, $valor);
                } else {
                    $query->where($campo, $operador, $valor);
                }
            }

            $registros = $query->get();
            $borrados = 0;
            $archivosBorrados = 0;
            $detalles = [];
            $archivosProtegidos = ['default.png', 'default.pdf', 'default_entrada.jpg', 'default_salida.png', 'default_incidente.jpg', 'default_recorrido.jpeg'];

            foreach ($registros as $registro) {
                // Manejo de archivos
                if (!empty($tablaConf['archivos'])) {
                    foreach ($tablaConf['archivos'] as $archivo) {
                        $nombre = $registro->{$archivo['campo']};
                        if ($nombre &&  !in_array($nombre, $archivosProtegidos)) {
                            $ruta = $archivo['carpeta'] . '/' . $nombre;
                            if (Storage::disk('public')->exists($ruta)) {
                                Storage::disk('public')->delete($ruta);
                                $archivosBorrados++;
                                $detalles[] = [
                                    'id' => $registro->id,
                                    'campo' => $archivo['campo'],
                                    'archivo' => $ruta
                                ];
                            }
                        }
                    }
                }
                try {
                    $registro->delete();
                    $borrados++;
                } catch (\Exception $e) {
                    $detalles[] = [
                        'id' => $registro->id,
                        'error' => 'No se pudo eliminar: ' . $e->getMessage(),
                    ];
                    $this->warn("No se pudo eliminar el registro [ID: {$registro->id}] de la tabla [{$config->tabla}]: " . $e->getMessage());
                    continue;
                }
            }

            LimpiezaLog::create([
                'tabla' => $config->tabla,
                'fecha_ejecucion' => now(),
                'registros_eliminados' => $borrados,
                'archivos_eliminados' => $archivosBorrados,
                'detalles' => $detalles,
            ]);

            $this->info("[{$config->tabla}] Registros: $borrados | Archivos: $archivosBorrados");
        }
    }

    private function fechaLimite($config)
    {
        return match ($config->periodo_tipo) {
            'dias' => now()->subDays($config->periodo_cantidad),
            'semanas' => now()->subWeeks($config->periodo_cantidad),
            'meses' => now()->subMonths($config->periodo_cantidad),
            'anios' => now()->subYears($config->periodo_cantidad),
            default => now()
        };
    }
}
