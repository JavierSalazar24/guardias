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
        Schema::create('qr_puntos_recorrido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_generado_id')->constrained('qrs_generados')->onDelete('cascade');
            $table->text('nombre_punto');
            $table->uuid('codigo_qr')->unique();
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
        Schema::dropIfExists('qr_puntos_recorrido');
    }
};
