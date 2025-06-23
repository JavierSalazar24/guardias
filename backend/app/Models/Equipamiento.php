<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Equipamiento extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'equipamiento';

    protected $fillable = ['fornitura', 'celular', 'radio', 'garret', 'impermeable', 'botas', 'plumas', 'caparas', 'equipo_cpat', 'firma_guardia', 'otro', 'vehiculo_id', 'guardia_id', 'fecha_entrega', 'fecha_devuelto', 'devuelto', 'eliminado'];

    protected $hidden = ['vehiculo_id', 'guardia_id', 'firma_guardia'];

    public function getFirmaGuardiaUrlAttribute()
    {
        if (!$this->firma_guardia) {
            return;
        }

        return asset("storage/firma_guardia/{$this->firma_guardia}");
    }

    public function guardia()
    {
        return $this->belongsTo(Guardia::class, 'guardia_id')->select(['id', 'nombre', 'apellido_p', 'apellido_m']);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id')->select(['id', 'tipo_vehiculo', 'marca', 'placas']);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleEquipamiento::class);
    }
}
