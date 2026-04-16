<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Descuento extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'descuentos';

    protected $fillable = [
        'guardia_id',
        'tipo',
        'monto',
        'modulo_descuento_id',
        'observaciones',
        'fecha',
    ];

    protected $hidden = ['guardia_id', 'modulo_descuento_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function modulo_descuento()
    {
        return $this->belongsTo(ModuloDescuento::class);
    }
}
