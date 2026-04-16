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
        Schema::create('boletas_gasolina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banco_id')->constrained('bancos')->onDelete('restrict');
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('restrict');
            $table->decimal('kilometraje', 10, 2);
            $table->decimal('litros', 10, 2);
            $table->decimal('costo_litro', 10, 2);
            $table->decimal('costo_total', 10, 2);
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
        Schema::dropIfExists('boletas_gasolina');
    }
};
