<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Vacacion extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'vacaciones';

    protected $fillable = [
        'guardia_id',
        'fecha_inicio',
        'fecha_fin',
        'dias_totales',
        'prima_vacacional',
        'observaciones',
    ];

    protected $hidden = ['guardia_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }
}
