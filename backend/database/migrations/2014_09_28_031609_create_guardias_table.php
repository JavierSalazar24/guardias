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
        Schema::create('guardias', function (Blueprint $table) {
            $table->id();
            $table->mediumText('foto');
            $table->string('nombre', 100);
            $table->string('apellido_p', 100);
            $table->string('apellido_m', 100);
            $table->date('fecha_nacimiento');
            $table->string('telefono', 15);
            $table->string('correo', 100)->unique();
            $table->string('enfermedades', 100);
            $table->string('alergias', 100);
            $table->string('curp');
            $table->string('clave_elector');

            $table->string('calle', 100);
            $table->string('entre_calles');
            $table->string('numero', 20);
            $table->string('colonia', 50);
            $table->string('cp');
            $table->string('estado', 100);
            $table->string('municipio', 100);
            $table->string('pais', 100);

            $table->string('contacto_emergencia', 100);
            $table->string('telefono_emergencia', 15);

            $table->foreignId('sucursal_empresa_id')->constrained('sucursales_empresa');
            $table->string('numero_empleado')->unique();
            $table->string('cargo');
            $table->string('cuip')->nullable();

            $table->string('numero_cuenta');
            $table->string('clabe');
            $table->string('banco');
            $table->string('nombre_propietario');
            $table->string('comentarios_generales')->nullable();

            $table->decimal('sueldo_base', 10, 2)->default(0);
            $table->integer('dias_laborales')->default(6);
            $table->decimal('aguinaldo', 10, 2)->default(0);
            $table->decimal('imss', 10, 2)->default(0);
            $table->decimal('infonavit', 10, 2)->default(0);
            $table->decimal('fonacot', 10, 2)->default(0);
            $table->decimal('retencion_isr', 10, 2)->default(0);

            $table->date('fecha_alta');
            $table->enum('estatus', ['Disponible', 'Descansado', 'Dado de baja', 'Asignado'])->default('Disponible');
            $table->foreignId('rango_id')->constrained('rangos')->onDelete('cascade');
            $table->date('fecha_baja')->nullable();
            $table->string('motivo_baja')->nullable();
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->onDelete('cascade');

            $table->mediumText('antidoping')->nullable();
            $table->date('fecha_antidoping')->nullable();

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
        Schema::dropIfExists('guardias');
    }
};
