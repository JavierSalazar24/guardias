<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class ReporteIncidenteGuardia extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'reportes_incidentes_guardia';

    protected $fillable = [
        'guardia_id',
        'orden_servicio_id',
        'punto_vigilancia',
        'turno',
        'incidente',
        'descripcion',
        'ubicacion',
        'causa',
        'quien_reporta',
        'acciones',
        'recomendaciones',
        'lugar_incidente',
        'fecha',
        'foto',
        'estado',
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
