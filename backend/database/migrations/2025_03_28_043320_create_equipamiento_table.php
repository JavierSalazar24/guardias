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
        Schema::create('equipamiento', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('restrict');
            $table->date('fecha_entrega');
            $table->date('fecha_devuelto')->nullable();
            $table->enum('devuelto', ['SI', 'NO'])->default('NO');

            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('restrict');
            $table->boolean('fornitura')->default(false);
            $table->boolean('celular')->default(false);
            $table->boolean('radio')->default(false);
            $table->boolean('garret')->default(false);
            $table->boolean('impermeable')->default(false);
            $table->boolean('botas')->default(false);
            $table->boolean('plumas')->default(false);
            $table->boolean('caparas')->default(false);
            $table->boolean('equipo_cpat')->default(false);
            $table->string('otro')->nullable();
            $table->string('firma_guardia');
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
        Schema::dropIfExists('equipamiento');
    }
};
