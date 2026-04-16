<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Guardia extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'guardias';

    protected $fillable = ['foto', 'nombre', 'apellido_p', 'apellido_m', 'fecha_nacimiento', 'telefono', 'correo', 'enfermedades', 'alergias', 'curp', 'clave_elector', 'calle', 'numero', 'entre_calles', 'colonia', 'cp', 'estado', 'municipio', 'pais', 'contacto_emergencia', 'telefono_emergencia', 'sucursal_empresa_id', 'numero_empleado', 'cargo', 'cuip', 'numero_cuenta', 'clabe', 'banco', 'nombre_propietario', 'comentarios_generales', 'sueldo_base', 'dias_laborales', 'aguinaldo', 'imss', 'infonavit', 'fonacot', 'retencion_isr', 'fecha_alta', 'rango_id', 'fecha_baja', 'motivo_baja', 'sucursal_id', 'fecha_antidoping', 'antidoping', 'estatus', 'eliminado'];

    protected $hidden = ['foto', 'antidoping', 'sucursal_empresa_id', 'sucursal_id'];

    public function equipamiento()
    {
        return $this->hasOne(Equipamiento::class, 'guardia_id');
    }

    public function sucursal_empresa()
    {
        return $this->belongsTo(SucursalEmpresa::class, 'sucursal_empresa_id');
    }

    public function ordenesServicios()
    {
        return $this->belongsToMany(OrdenServicio::class, 'orden_servicio_guardias');
    }

    public function rango()
    {
        return $this->belongsTo(Rango::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function blacklist()
    {
        return $this->hasOne(BlackList::class, 'guardia_id');
    }

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return;
        }

        return asset("storage/fotos_guardias/{$this->foto}");
    }
    public function getAntidopingUrlAttribute()
    {
        if (!$this->antidoping) {
            return;
        }

        return asset("storage/documentos_guardias/{$this->antidoping}");
    }

    public function scopeFiltrarPorSucursalEmpresaUsuario($query, $usuario)
    {
        return $query->when($usuario->sucursal_empresa_id !== null, function ($q) use ($usuario) {
            $q->where('sucursal_empresa_id', $usuario->sucursal_empresa_id);
        });
    }
}
