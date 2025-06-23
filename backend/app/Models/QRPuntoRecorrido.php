<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QRPuntoRecorrido extends Model
{
    use HasFactory;

    protected $table = 'qr_puntos_recorrido';

    protected $fillable = ['qr_generado_id', 'codigo_qr', 'nombre_punto'];

    protected $hidden = ['qr_generado_id'];

    public function qr_generado()
    {
        return $this->belongsTo(QRGenerado::class, 'qr_generado_id');
    }

    public function escaneos()
    {
        return $this->hasMany(QRRecorridoGuardia::class, 'qr_punto_id');
    }
}