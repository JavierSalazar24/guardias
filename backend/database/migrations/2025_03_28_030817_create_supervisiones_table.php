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
        Schema::create('supervisiones', function (Blueprint $table) {
            $table->id();
            $table->string('evidencia');
            $table->enum('asistencia', ['Asistió', 'Faltó'])->default('Asistió');
            $table->text('falta')->nullable(); // a que turno falto o si fue justificada o no, etc.
            $table->enum('uniforme', ['Completo', 'Incompleto'])->default('Completo');
            $table->text('uniforme_incompleto')->nullable(); // si el uniforme es incompleto, especificar qué parte falta
            $table->enum('equipamiento', ['Completo', 'Incompleto'])->default('Completo');
            $table->text('equipamiento_incompleto')->nullable(); // si el equipamiento es incompleto, especificar qué parte falta
            $table->enum('lugar_trabajo', ['Activo', 'Ausente'])->default('Activo');
            $table->text('motivo_ausente')->nullable(); // si el lugar de trabajo es ausente, especificar el motivo
            $table->text('comentarios_adicionales')->nullable();
            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
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
        Schema::dropIfExists('supervisiones');
    }
};
