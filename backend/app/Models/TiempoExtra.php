<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class TiempoExtra extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'tiempo_extra';

    protected $fillable = [
        'guardia_id',
        'horas',
        'monto_por_hora',
        'monto_total',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $hidden = ['guardia_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }
}
