<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class SucursalEmpresa extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'sucursales_empresa';

    protected $fillable = ['nombre_sucursal', 'calle', 'numero', 'colonia', 'cp', 'municipio', 'estado', 'pais', 'telefono_sucursal', 'extension_sucursal', 'nombre_contacto', 'telefono_contacto', 'whatsapp_contacto', 'correo_contacto'];

    public function guardia()
    {
        return $this->hasMany(Guardia::class, 'sucursal_empresa_id');
    }
}
