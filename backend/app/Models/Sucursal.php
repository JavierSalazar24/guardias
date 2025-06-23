<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Sucursal extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'sucursales';

    protected $fillable = ['cliente_id', 'nombre_empresa', 'calle', 'numero', 'colonia', 'cp', 'municipio', 'estado', 'pais', 'telefono_empresa', 'extension_empresa', 'nombre_contacto', 'telefono_contacto', 'whatsapp_contacto', 'correo_contacto', 'rfc', 'razon_social', 'uso_cfdi', 'regimen_fiscal', 'situacion_fiscal'];

    protected $hidden = ['cliente_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id')->select(['id', 'nombre_empresa']);
    }

    public function cotizacion()
    {
        return $this->hasMany(Cotizacion::class, 'sucursal_id');
    }

    public function getSituacionFiscalUrlAttribute()
    {
        if (!$this->situacion_fiscal) {
            return;
        }

        return asset("storage/documentos_sucursales/{$this->situacion_fiscal}");
    }
}
