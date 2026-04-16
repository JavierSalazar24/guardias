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
        'foto',
        'latitude',
        'longitude',
        'ubicacion',
        'comentarios',
        'foto_salida',
        'latitude_salida',
        'longitude_salida',
        'ubicacion_salida',
        'comentarios_salida',
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

    public function getFotoCheckInUrlAttribute()
    {
        if (!$this->foto) {
            return;
        }

        return asset("storage/check_guardia/{$this->foto}");
    }

    public function getFotoCheckOutUrlAttribute()
    {
        if (!$this->foto_salida) {
            return;
        }

        return asset("storage/check_guardia/{$this->foto_salida}");
    }
}
