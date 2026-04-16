<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Venta extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'ventas';

    protected $fillable = ['cotizacion_id', 'numero_factura', 'fecha_emision', 'fecha_vencimiento', 'tipo_pago', 'metodo_pago', 'estatus', 'motivo_cancelada', 'total', 'nota_credito', 'eliminado', 'banco_id', 'referencia'];

    protected $hidden = ['cotizacion_id', 'banco_id'];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function movimientosBancarios()
    {
        return $this->morphMany(MovimientoBancario::class, 'origen');
    }
}
