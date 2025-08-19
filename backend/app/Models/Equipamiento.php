<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Equipamiento extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'equipamiento';

    protected $fillable = ['vehiculo_id', 'guardia_id', 'fecha_entrega', 'fecha_devuelto', 'devuelto'];

    protected $hidden = ['vehiculo_id', 'guardia_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class, 'guardia_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleEquipamiento::class);
    }
}
