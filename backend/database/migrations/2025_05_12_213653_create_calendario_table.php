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
        Schema::create('calendario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creador_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('invitado_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('titulo');
            $table->string('descripcion');
            $table->dateTime('fecha_hora');
            $table->text('notas')->nullable();
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
        Schema::dropIfExists('calendario');
    }
};
