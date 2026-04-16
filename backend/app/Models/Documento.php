<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Documento extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'documentos';

    protected $fillable = [
        'tipo_documento_id',
        'guardia_id',
        'documento',
    ];

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function getDocumentoUrlAttribute()
    {
        if (!$this->documento) {
            return;
        }

        return asset("storage/documentos_guardias/{$this->documento}");
    }
}
