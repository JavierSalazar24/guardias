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
        Schema::create('reporte_bitacoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardia_id')->nullable()->constrained('guardias')->onDelete('restrict');
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicios')->onDelete('restrict');
            $table->text('codigo_servicio')->nullable();
            $table->text('patrulla')->nullable();
            $table->text('zona')->nullable();
            $table->decimal('kilometraje', 10, 2)->nullable();
            $table->decimal('litros_carga', 10, 2)->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora_inicio_recorrido')->nullable();
            $table->time('hora_fin_recorrido')->nullable();
            $table->json('guardias')->nullable();
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
        Schema::dropIfExists('reporte_bitacoras');
    }
};
