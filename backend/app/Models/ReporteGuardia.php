<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class ReporteGuardia extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'reportes_guardia';

    protected $casts = [
        'observaciones' => 'array',
        'consignas' => 'array',
        'equipo' => 'array',
    ];

    protected $fillable = [
        'guardia_id',
        'orden_servicio_id',
        'punto_vigilancia',
        'fecha',
        'turno',
        'quien_recibe',
        'observaciones',
        'consignas',
        'equipo',
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
