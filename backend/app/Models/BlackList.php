<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class BlackList extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'black_list';

    protected $fillable = ['motivo_baja', 'guardia_id'];

    protected $hidden = ['guardia_id'];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }
}