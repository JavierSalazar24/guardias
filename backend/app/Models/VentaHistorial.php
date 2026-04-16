<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class VentaHistorial extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'ventas_historial';

    protected $fillable = [
        'usuario_id',
        'venta_id',
        'banco_id',
        'cotizacion_id',
        'numero_factura',
        'fecha_emision',
        'fecha_vencimiento',
        'total',
        'nota_credito',
        'credito_dias',
        'motivo_cancelada',
        'tipo_pago',
        'metodo_pago',
        'estatus',
        'eliminado',
        'accion',
    ];

    protected $hidden = ['cotizacion_id'];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }
}