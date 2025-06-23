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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banco_id')->constrained('bancos')->onDelete('restrict');
            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('restrict');
            $table->foreignId('modulo_prestamo_id')->constrained('modulo_prestamos')->onDelete('restrict');
            $table->decimal('monto_total', 10, 2);
            $table->decimal('saldo_restante', 10, 2);
            $table->integer('numero_pagos');
            $table->date('fecha_prestamo');
            $table->date('fecha_pagado')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('metodo_pago', ['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']);
            $table->string('referencia')->nullable();
            $table->enum('estatus', ['Pagado', 'Pendiente'])->default('Pendiente');
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
        Schema::dropIfExists('prestamos');
    }
};
