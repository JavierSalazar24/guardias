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
        Schema::create('reportes_supervisor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('restrict');
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicios')->onDelete('restrict');
            $table->text('zona')->nullable();
            $table->timestamp('fecha')->useCurrent();
            $table->enum('turno', ['DIA', 'NOCHE', '24H'])->nullable();
            $table->text('quien_entrega')->nullable();
            $table->text('quien_recibe')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('consignas')->nullable();
            $table->text('proyeccion')->nullable();
            $table->text('tipo')->nullable();
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
        Schema::dropIfExists('reportes_supervisor');
    }
};
