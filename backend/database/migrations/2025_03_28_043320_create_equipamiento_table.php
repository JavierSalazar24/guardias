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

            $table->foreignId('guardia_id')->unique()->constrained('guardias')->onDelete('cascade');
            $table->date('fecha_entrega');
            $table->date('fecha_devuelto')->nullable();
            $table->enum('devuelto', ['SI', 'NO'])->default('NO');
            $table->foreignId('vehiculo_id')->nullable()->constrained('vehiculos')->onDelete('restrict');
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
