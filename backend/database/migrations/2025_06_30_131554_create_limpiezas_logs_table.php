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
        Schema::create('limpiezas_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tabla');
            $table->timestamp('fecha_ejecucion');
            $table->unsignedInteger('registros_eliminados')->default(0);
            $table->unsignedInteger('archivos_eliminados')->default(0);
            $table->json('detalles')->nullable();
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
        Schema::dropIfExists('limpiezas_logs');
    }
};
