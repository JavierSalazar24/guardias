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
        Schema::create('qr_recorridos_guardia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('cascade');
            $table->foreignId('qr_punto_id')->constrained('qr_puntos_recorrido')->onDelete('cascade');
            $table->timestamp('fecha_escaneo');
            $table->mediumText('observaciones')->nullable();
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('qr_recorridos_guardia');
    }
};
