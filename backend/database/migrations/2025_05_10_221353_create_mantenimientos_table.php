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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_ingreso');
            $table->text('motivo_ingreso');
            $table->date('fecha_salida')->nullable();
            $table->enum('estatus', ['Reparado', 'No reparado', 'En reparación'])->default('En reparación');
            $table->text('notas')->nullable();
            $table->decimal('costo_final', 10, 2);
            $table->foreignId('taller_id')->constrained('talleres')->onDelete('cascade');
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
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
        Schema::dropIfExists('mantenimientos');
    }
};
