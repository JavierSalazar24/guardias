<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;

class Vehiculo extends Model
{
    use HasFactory, HasLogs;

    protected $table = 'vehiculos';

    protected $fillable = ['tipo_vehiculo', 'marca', 'modelo', 'color', 'placas', 'estado', 'fotos_vehiculo', 'rotulado', 'gps', 'torreta', 'impuestos_pagados', 'aseguradora', 'telefono_aseguradora', 'numero_poliza', 'fecha_vencimiento', 'archivo_seguro'];

    public function equipamiento()
    {
        return $this->hasMany(Equipamiento::class, 'vehiculo_id');
    }

    public function getArchivoSeguroUrlAttribute()
    {
        $archivo_seguro = asset('storage/seguros_vehiculos/default.png');

        if (!$this->archivo_seguro) {
            return $archivo_seguro;
        }

        // Construcción correcta de la URL
        return asset("storage/seguros_vehiculos/{$this->archivo_seguro}");
    }

    public function getFotosVehiculoUrlAttribute()
    {
        return route('vehiculos.descargarZip', $this->id);
    }
}
