<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class OrdenServicioGuardia extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'orden_servicio_guardias';

    protected $fillable = ['orden_servicio_id', 'guardia_id'];

    protected $hidden = ['orden_servicio_id'];

    public function orden_servicio()
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_servicio_id');
    }

    public function guardia()
    {
        return $this->belongsTo(Guardia::class, 'guardia_id')->select('id', 'nombre', 'apellido_p', 'apellido_m', 'rango');
    }
}
