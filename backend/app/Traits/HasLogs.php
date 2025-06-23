<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait HasLogs
{
    public static function bootHasLogs()
    {
        static::created(function ($model) {
            self::registrarLog($model, 'crear', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $dirty = $model->getDirty();
            self::registrarLog($model, 'actualizar', $model->getOriginal(), $dirty);
        });

        static::deleted(function ($model) {
            self::registrarLog($model, 'eliminar', $model->getOriginal(), null);
        });
    }

    protected static function registrarLog($model, $accion, $datosAnteriores = null, $datosNuevos = null)
    {
        // Modelos que nunca deben registrar logs (ni en web ni en móvil ni nada)
        $modelosSinLog = [
            \App\Models\Usuario::class,
            \App\Models\Rol::class,
            \App\Models\Modulo::class,
            \App\Models\Permiso::class,
            \App\Models\CheckGuardia::class,
            \App\Models\ReporteBitacora::class,
            \App\Models\ReporteGuardia::class,
            \App\Models\ReporteIncidenteGuardia::class,
            \App\Models\ReportePatrulla::class,
            \App\Models\ReporteSupervisor::class,
        ];

        // Si el modelo está en la lista, salir SIN registrar log
        foreach ($modelosSinLog as $modelo) {
            if ($model instanceof $modelo) {
                // Si estás corriendo en consola, también saltar log (por seeds)
                if (app()->runningInConsole()) {
                    return;
                }
                return;
            }
        }

        $usuarioId = app()->runningInConsole() ? 1 : Auth::id();

        Log::create([
            'modulo' => class_basename($model),
            'modulo_id' => $model->id,
            'accion' => $accion,
            'datos_anteriores' => $datosAnteriores ? json_encode($datosAnteriores) : null,
            'datos_nuevos' => $datosNuevos ? json_encode($datosNuevos) : null,
            'usuario_id' => $usuarioId,
            'ip' => Request::ip(),
        ]);
    }
}