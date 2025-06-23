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
        Schema::create('historial_pagos', function (Blueprint $table) {
            $table->id();
            $table->text('nombre_guardia');
            $table->decimal('sueldo_base', 10, 2);
            $table->integer('dias_laborales');
            $table->decimal('imss', 5, 2)->default(0);
            $table->decimal('infonavit', 5, 2)->default(0);
            $table->decimal('fonacot', 5, 2)->default(0);
            $table->decimal('retencion_isr', 5, 2)->default(0);
            $table->decimal('total_descuentos', 10, 2)->default(0);
            $table->decimal('total_extras', 10, 2)->default(0);
            $table->decimal('pago_final', 10, 2);
            $table->date('fecha');
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
        Schema::dropIfExists('historial_pagos');
    }
};
