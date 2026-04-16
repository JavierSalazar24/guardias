<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Mantenimiento extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'mantenimientos';

    protected $fillable = ['fecha_ingreso', 'motivo_ingreso', 'fecha_salida', 'estatus', 'notas', 'costo_final', 'taller_id', 'vehiculo_id'];

    protected $hidden = ['taller_id', 'vehiculo_id'];

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
