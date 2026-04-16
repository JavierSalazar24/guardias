<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Prestamo extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'prestamos';

    protected $fillable = [
        'banco_id',
        'guardia_id',
        'monto_total',
        'saldo_restante',
        'numero_pagos',
        'fecha_prestamo',
        'fecha_pagado',
        'modulo_prestamo_id',
        'observaciones',
        'estatus',
        'metodo_pago',
        'referencia',
    ];

    protected $hidden = ['banco_id', 'guardia_id', 'modulo_prestamo_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function abonos()
    {
        return $this->hasMany(AbonoPrestamo::class);
    }

    public function modulo_prestamo()
    {
        return $this->belongsTo(ModuloPrestamo::class);
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
