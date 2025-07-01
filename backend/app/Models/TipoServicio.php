<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class TipoServicio extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'tipos_servicios';

    protected $fillable = ['nombre', 'costo', 'descripcion'];

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
}
