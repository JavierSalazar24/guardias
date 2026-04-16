<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Supervision extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'supervisiones';

    protected $fillable = ['evidencia', 'asistencia', 'falta', 'uniforme', 'uniforme_incompleto', 'equipamiento', 'equipamiento_incompleto', 'lugar_trabajo', 'motivo_ausente', 'comentarios_adicionales', 'guardia_id', 'usuario_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function getEvidenciaUrlAttribute()
    {
        if (!$this->evidencia) {
            return;
        }

        return asset("storage/evidencia_supervisores/{$this->evidencia}");
    }
}
