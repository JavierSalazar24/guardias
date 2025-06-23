<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class ReportePatrulla extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'reportes_patrulla';

    protected $casts = [
        'datos_vehiculo' => 'array',
        'llantas' => 'array',
        'niveles' => 'array',
        'interior_motor' => 'array',
        'interior_vehiculo' => 'array',
        'marcadores_tablero' => 'array',
        'herramientas' => 'array',
        'documentacion' => 'array',
        'condiciones_mecanicas' => 'array',
        'costado_derecho' => 'array',
        'costado_izquierda' => 'array',
        'llaves_accesos' => 'array',
    ];

    protected $fillable = [
        'guardia_id',
        'orden_servicio_id',
        'licencia_manejo',
        'tarjeta_combustible',
        'observaciones',
        'recibido_por',
        'datos_vehiculo',
        'llantas',
        'niveles',
        'interior_motor',
        'interior_vehiculo',
        'marcadores_tablero',
        'herramientas',
        'documentacion',
        'condiciones_mecanicas',
        'costado_derecho',
        'costado_izquierda',
        'llaves_accesos',
    ];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function orden_servicio()
    {
        return $this->belongsTo(OrdenServicio::class);
    }
}
