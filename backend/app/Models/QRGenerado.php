<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRGenerado extends Model
{
    use HasFactory;

    protected $table = 'qrs_generados';

    protected $fillable = ['orden_servicio_id', 'cantidad', 'notas'];

    protected $hidden = ['orden_servicio_id'];

    public function orden_servicio()
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_servicio_id');
    }

    public function puntos_recorrido()
    {
        return $this->hasMany(QRPuntoRecorrido::class, 'qr_generado_id');
    }
}
