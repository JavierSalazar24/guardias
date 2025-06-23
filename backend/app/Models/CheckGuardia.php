<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class CheckGuardia extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'check_guardia';

    protected $fillable = [
        'guardia_id',
        'orden_servicio_id',
        'latitude',
        'longitude',
        'ubicacion',
        'comentarios',
        'latitude_salida',
        'longitude_salida',
        'ubicacion_salida',
        'comentarios_salida',
        'foto',
        'tipo_guardia',
        'nombre_guardia',
        'fecha_entrada',
        'fecha_salida',
        'tiempo_trabajado',
        'tiempo_trabajado_segundos'
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