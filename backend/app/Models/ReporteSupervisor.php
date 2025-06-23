<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class ReporteSupervisor extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'reportes_supervisor';

    protected $casts = [
        'observaciones' => 'array',
        'consignas' => 'array',
        'proyeccion' => 'array',
    ];

    protected $fillable = [
        'guardia_id',
        'orden_servicio_id',
        'zona',
        'fecha',
        'turno',
        'quien_entrega',
        'quien_recibe',
        'observaciones',
        'consignas',
        'proyeccion',
        'tipo',
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
