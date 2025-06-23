<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class ReporteBitacora extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'reporte_bitacoras';

    protected $casts = [
        'guardias' => 'array',
    ];

    protected $fillable = [
        'guardia_id',
        'orden_servicio_id',
        'codigo_servicio',
        'patrulla',
        'zona',
        'kilometraje',
        'litros_carga',
        'fecha',
        'hora_inicio_recorrido',
        'hora_fin_recorrido',
        'guardias',
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
