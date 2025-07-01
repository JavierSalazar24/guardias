<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Cotizacion extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'aceptada',
        'sucursal_empresa_id',
        'sucursal_id',
        'credito_dias',
        'precio_total_servicios',
        'guardias_dia',
        'precio_guardias_dia',
        'precio_guardias_dia_total',
        'guardias_noche',
        'precio_guardias_noche',
        'precio_guardias_noche_total',
        'cantidad_guardias',
        'jefe_turno',
        'precio_jefe_turno',
        'supervisor',
        'precio_supervisor',
        'fecha_servicio',
        'soporte_documental',
        'observaciones_soporte_documental',
        'requisitos_pago_cliente',
        'impuesto',
        'subtotal',
        'descuento_porcentaje',
        'costo_extra',
        'total',
        'notas',
    ];

    protected $hidden = ['sucursal_id', 'sucursal_empresa_id'];

    public function sucursal_empresa()
    {
        return $this->belongsTo(SucursalEmpresa::class, 'sucursal_empresa_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function venta()
    {
        return $this->hasOne(Venta::class, 'cotizacion_id');
    }

    public function serviciosCotizaciones()
    {
        return $this->hasMany(ServicioCotizacion::class, 'cotizacion_id');
    }
}
