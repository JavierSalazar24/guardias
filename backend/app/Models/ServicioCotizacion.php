<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioCotizacion extends Model
{
    use HasFactory;

    protected $table = 'servicios_cotizaciones';

    protected $fillable = ['cotizacion_id', 'tipo_servicio_id'];

    protected $hidden = ['cotizacion_id'];

    public function cotizacion()
    {
        return $this->belongsTo(OrdenServicio::class, 'cotizacion_id');
    }

    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class, 'tipo_servicio_id');
    }
}
