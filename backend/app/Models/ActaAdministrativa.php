<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class ActaAdministrativa extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'actas_administrativas';

    protected $fillable = ['empleado_id', 'supervisor_id', 'testigo1_id', 'testigo2_id', 'motivo_id', 'fecha_hora', 'dice_supervisor', 'dice_empleado'];

    protected $hidden = ['empleado_id', 'supervisor_id', 'testigo1_id', 'testigo2_id', 'motivo_id'];

    public function empleado()
    {
        return $this->belongsTo(Guardia::class, 'empleado_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Guardia::class, 'supervisor_id');
    }

    public function testigo1()
    {
        return $this->belongsTo(Guardia::class, 'testigo1_id');
    }

    public function testigo2()
    {
        return $this->belongsTo(Guardia::class, 'testigo2_id');
    }

    public function motivo_acta()
    {
        return $this->belongsTo(MotivoActa::class, 'motivo_id');
    }
}
