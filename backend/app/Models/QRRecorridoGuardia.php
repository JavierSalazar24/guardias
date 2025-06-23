<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRRecorridoGuardia extends Model
{
    use HasFactory;
    protected $table = 'qr_recorridos_guardia';
    protected $fillable = ['guardia_id', 'qr_punto_id', 'fecha_escaneo', 'observaciones', 'foto'];

    protected $hidden = ['guardia_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function punto()
    {
        return $this->belongsTo(QRPuntoRecorrido::class, 'qr_punto_id');
    }
}