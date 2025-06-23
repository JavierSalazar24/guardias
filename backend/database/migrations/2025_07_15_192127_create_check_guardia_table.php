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
        Schema::create('check_guardia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardia_id')->nullable()->constrained('guardias')->onDelete('restrict');
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicios')->onDelete('restrict');
            $table->text('foto');

            // datos para la entrada
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->mediumText('ubicacion');
            $table->mediumText('comentarios')->nullable();

            // datos para la salida
            $table->decimal('latitude_salida', 10, 7)->nullable();
            $table->decimal('longitude_salida', 10, 7)->nullable();
            $table->mediumText('ubicacion_salida')->nullable();
            $table->mediumText('comentarios_salida')->nullable();

            // Para guardia eventual
            $table->enum('tipo_guardia', ['Eventual', 'Empleado'])->default('Empleado');
            $table->text('nombre_guardia')->nullable();

            $table->timestamp('fecha_entrada')->useCurrent();
            $table->timestamp('fecha_salida')->nullable();
            // tiempo trabajado
            $table->string('tiempo_trabajado', 8)->nullable(); // 'HH:MM:SS'
            $table->unsignedInteger('tiempo_trabajado_segundos')->nullable(); // segundos
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
        Schema::dropIfExists('check_guardia');
    }
};
