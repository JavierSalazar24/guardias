<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Cliente extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'clientes';

    protected $fillable = ['nombre_empresa', 'calle', 'numero', 'colonia', 'cp', 'municipio', 'estado', 'pais', 'telefono_empresa', 'extension_empresa', 'pagina_web', 'nombre_contacto_admin', 'telefono_contacto_admin', 'whatsapp_contacto_admin', 'correo_contacto_admin', 'nombre_contacto_opera', 'telefono_contacto_opera', 'whatsapp_contacto_opera', 'correo_contacto_opera', 'credito_dias', 'metodo_pago', 'plataforma_facturas', 'orden_compra', 'rfc', 'razon_social', 'uso_cfdi', 'regimen_fiscal', 'situacion_fiscal'];

    public function sucursal()
    {
        return $this->hasMany(Sucursal::class, 'cliente_id');
    }

    public function venta()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    public function sucursales() {
        return $this->hasMany(Sucursal::class);
    }

    public function getSituacionFiscalUrlAttribute()
    {
        if (!$this->situacion_fiscal) {
            return;
        }

        return asset("storage/documentos_clientes/{$this->situacion_fiscal}");
    }
}
