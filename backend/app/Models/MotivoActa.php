<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class MotivoActa extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'motivos_actas_administrativas';

    protected $fillable = ['motivo', 'descripcion'];

    public function actasAdministrativas()
    {
        return $this->hasMany(ActaAdministrativa::class, 'motivo_id');
    }
}
