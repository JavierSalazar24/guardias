<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Calendario extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'calendario';

    protected $fillable = ['creador_id', 'invitado_id', 'titulo', 'descripcion', 'fecha_hora', 'notas'];

    public function invitado()
    {
        return $this->belongsTo(Usuario::class, 'invitado_id');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creador_id');
    }
}
