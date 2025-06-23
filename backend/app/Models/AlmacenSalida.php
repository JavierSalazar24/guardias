<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class AlmacenSalida extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'almacen_salidas';

    protected $fillable = [
        'guardia_id',
        'articulo_id',
        'numero_serie',
        'fecha_salida',
        'motivo_salida',
        'motivo_salida_otro',
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }
}
