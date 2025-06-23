<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class ModuloDescuento extends Model
{
    use HasFactory, HasLogs;
    protected $table = 'modulo_descuentos';

    protected $fillable = ['nombre', 'descripcion'];
}
