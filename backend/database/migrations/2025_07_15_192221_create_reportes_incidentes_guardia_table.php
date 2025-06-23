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
        Schema::create('reportes_incidentes_guardia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('restrict');
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicios')->onDelete('restrict');
            $table->text('punto_vigilancia')->nullable();
            $table->enum('turno', ['DIA', 'NOCHE', '24H'])->nullable();
            $table->text('incidente')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('ubicacion')->nullable();
            $table->text('causa')->nullable();
            $table->text('quien_reporta')->nullable();
            $table->text('acciones')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->text('lugar_incidente')->nullable();
            $table->timestamp('fecha')->useCurrent();
            $table->text('foto')->nullable();


            $table->enum('estado', ['Pendiente', 'Atendido'])->default('Pendiente');
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
        Schema::dropIfExists('reportes_incidentes_guardia');
    }
};
