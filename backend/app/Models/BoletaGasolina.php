<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class BoletaGasolina extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'boletas_gasolina';

    protected $fillable = ['vehiculo_id', 'banco_id', 'metodo_pago', 'referencia', 'kilometraje', 'litros', 'costo_litro', 'costo_total', 'observaciones'];

    protected $hidden = ['vehiculo_id', 'banco_id'];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    public function movimientosBancarios()
    {
        return $this->morphMany(MovimientoBancario::class, 'origen');
    }
}
