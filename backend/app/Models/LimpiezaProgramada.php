<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimpiezaProgramada extends Model
{
    use HasFactory;

    protected $table = 'limpiezas_programadas';

    protected $fillable = [
        'tabla',
        'periodo_cantidad',
        'periodo_tipo',
        'activa',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
