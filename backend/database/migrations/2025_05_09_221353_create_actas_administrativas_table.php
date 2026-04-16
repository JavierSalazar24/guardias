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
        Schema::create('actas_administrativas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('guardias')->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained('guardias')->onDelete('cascade');
            $table->foreignId('testigo1_id')->constrained('guardias')->onDelete('cascade');
            $table->foreignId('testigo2_id')->constrained('guardias')->onDelete('cascade');
            $table->foreignId('motivo_id')->constrained('motivos_actas_administrativas')->onDelete('cascade');
            $table->dateTime('fecha_hora');
            $table->text('dice_supervisor');
            $table->text('dice_empleado');
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
        Schema::dropIfExists('actas_administrativas');
    }
};
