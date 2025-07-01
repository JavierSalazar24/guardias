<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimpiezaLog extends Model
{
    use HasFactory;

    protected $table = 'limpiezas_logs';

    protected $fillable = [
        'tabla', 'fecha_ejecucion', 'registros_eliminados', 'archivos_eliminados', 'detalles',
    ];

    protected $casts = [
        'detalles' => 'array',
        'fecha_ejecucion' => 'datetime',
    ];
}
