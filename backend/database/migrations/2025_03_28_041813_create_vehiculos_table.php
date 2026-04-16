<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_vehiculo', ['Carro', 'Motocicleta']);
            $table->string('marca', 50);
            $table->string('modelo', 15);
            $table->string('color', 15);
            $table->string('placas', 20)->unique();
            $table->enum('estado', ['Disponible', 'Asignado', 'En reparación', 'Fuera de servicio', 'Accidente', 'Robado', 'Vendido'])->default('Disponible');

            $table->text('fotos_vehiculo');
            $table->enum('rotulado', ['SI', 'NO']);
            $table->enum('gps', ['SI', 'NO']);
            $table->enum('torreta', ['SI', 'NO']);
            $table->enum('impuestos_pagados', ['SI', 'NO']);

            $table->string('aseguradora', 50);
            $table->string('telefono_aseguradora', 15);
            $table->string('archivo_seguro');
            $table->string('numero_poliza');
            $table->date('fecha_vencimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
};
