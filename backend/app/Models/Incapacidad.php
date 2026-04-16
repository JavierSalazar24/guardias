<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Incapacidad extends Model
{
    use HasFactory, HasLogs;
    
    protected $table = 'incapacidades';

    protected $fillable = [
        'guardia_id',
        'fecha_inicio',
        'fecha_fin',
        'pago_empresa',
        'motivo',
        'observaciones',
    ];

    protected $hidden = ['guardia_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }
}
