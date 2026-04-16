<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class TipoDocumento extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'tipos_documentos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function documentaciones()
    {
        return $this->hasMany(Documento::class, 'tipo_documento_id');
    }
}
