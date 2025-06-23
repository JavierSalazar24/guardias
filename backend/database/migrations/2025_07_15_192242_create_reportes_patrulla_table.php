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
        Schema::create('reportes_patrulla', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardia_id')->nullable()->constrained('guardias')->onDelete('restrict');
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicios')->onDelete('restrict');
            $table->text('licencia_manejo')->nullable();
            $table->text('tarjeta_combustible')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('recibido_por')->nullable();

            $table->json('datos_vehiculo')->nullable();
            $table->json('llantas')->nullable();
            $table->json('niveles')->nullable();
            $table->json('interior_motor')->nullable();
            $table->json('interior_vehiculo')->nullable();
            $table->json('marcadores_tablero')->nullable();
            $table->json('herramientas')->nullable();
            $table->json('documentacion')->nullable();
            $table->json('condiciones_mecanicas')->nullable();
            $table->json('costado_derecho')->nullable();
            $table->json('costado_izquierda')->nullable();
            $table->json('llaves_accesos')->nullable();
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
        Schema::dropIfExists('reportes_patrulla');
    }
};
