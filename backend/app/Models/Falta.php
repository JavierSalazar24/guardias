<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Falta extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'faltas';

    protected $fillable = [
        'guardia_id',
        'cantidad_faltas',
        'monto',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $hidden = ['guardia_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }
}
