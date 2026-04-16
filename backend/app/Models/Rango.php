<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Rango extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'rangos';

    protected $fillable = ['nombre', 'descripcion'];

    public function guardias()
    {
        return $this->hasMany(Guardia::class);
    }
}
