<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class ModuloPrestamo extends Model
{
    use HasFactory, HasLogs;
    protected $table = 'modulo_prestamos';

    protected $fillable = ['nombre', 'descripcion'];
}
