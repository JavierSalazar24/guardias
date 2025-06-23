<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class AbonoPrestamo extends Model
{
    use HasFactory, HasLogs;
    protected $table = 'abonos_prestamo';

    protected $fillable = [
        'banco_id',
        'prestamo_id',
        'monto',
        'fecha',
        'metodo_pago',
        'referencia',
        'observaciones',
    ];

    protected $hidden = ['prestamo_id', 'banco_id'];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
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
