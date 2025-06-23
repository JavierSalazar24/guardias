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
        Schema::create('ordenes_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('restrict');
            $table->text('codigo_orden_servicio')->unique();
            $table->text('domicilio_servicio');
            $table->string('nombre_responsable_sitio');
            $table->string('telefono_responsable_sitio', 15);
            $table->datetime('fecha_inicio');
            $table->datetime('fecha_fin');
            $table->enum('estatus', ['En proceso', 'Finalizada', 'Cancelada'])->default('En proceso');
            $table->text('observaciones')->nullable();
            $table->boolean('eliminado')->default(false);
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
        Schema::dropIfExists('ordenes_servicios');
    }
};
