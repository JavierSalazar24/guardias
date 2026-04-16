<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Gasto extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'gastos';

    protected $fillable = ['banco_id', 'concepto', 'metodo_pago', 'impuesto', 'descuento_monto', 'subtotal', 'total', 'modulo_concepto_id', 'referencia'];

    protected $hidden = ['banco_id', 'modulo_concepto_id'];

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    public function modulo_concepto()
    {
        return $this->belongsTo(ModuloConcepto::class);
    }

    public function movimientosBancarios()
    {
        return $this->morphMany(MovimientoBancario::class, 'origen');
    }
}
