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
        Schema::create('pagos_empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banco_id')->constrained('bancos')->onDelete('restrict');

            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('cascade');
            $table->decimal('sueldo_base', 10, 2);
            $table->date('periodo_inicio');
            $table->date('periodo_fin');

             // Sumatorias
            $table->decimal('dias_trabajados', 10, 2)->default(0);
            $table->decimal('tiempo_extra', 10, 2)->default(0);
            $table->decimal('prima_vacacional', 10, 2)->default(0);
            $table->decimal('incapacidades_pagadas', 10, 2)->default(0);

            // Descuentos
            $table->decimal('descuentos', 10, 2)->default(0);
            $table->decimal('faltas', 10, 2)->default(0);
            $table->decimal('incapacidades_no_pagadas', 10, 2)->default(0);

            // Retenciones legales
            $table->decimal('imss', 10, 2)->default(0);
            $table->decimal('infonavit', 10, 2)->default(0);
            $table->decimal('fonacot', 10, 2)->default(0);
            $table->decimal('retencion_isr', 10, 2)->default(0);

            // Totales
            $table->decimal('total_ingresos', 10, 2);
            $table->decimal('total_egresos', 10, 2);
            $table->decimal('total_retenciones', 10, 2);
            $table->decimal('pago_bruto', 10, 2);
            $table->decimal('pago_final', 10, 2);

            $table->mediumText('observaciones')->nullable();
            $table->enum('metodo_pago', ['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']);
            $table->string('referencia')->nullable();
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
        Schema::dropIfExists('pagos_empleados');
    }
};
