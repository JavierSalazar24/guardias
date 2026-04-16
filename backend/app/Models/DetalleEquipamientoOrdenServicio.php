<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class DetalleEquipamientoOrdenServicio extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'det_equip_ordenes_servicios';

    protected $fillable = [
        'orden_servicio_id',
        'articulo_id',
        'numero_serie',
    ];

    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class);
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}
