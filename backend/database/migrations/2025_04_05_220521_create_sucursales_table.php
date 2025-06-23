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
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('restrict');
            $table->string('nombre_empresa', 100);
            $table->string('calle', 100);
            $table->string('numero', 20);
            $table->string('colonia', 50);
            $table->unsignedInteger('cp');
            $table->string('municipio', 100);
            $table->string('estado', 100);
            $table->string('pais', 100);
            $table->string('telefono_empresa', 15);
            $table->string('extension_empresa', 10)->nullable();
            $table->string('nombre_contacto', 100);
            $table->string('telefono_contacto', 15);
            $table->string('whatsapp_contacto', 15);
            $table->string('correo_contacto', 100)->unique();

            $table->string('rfc', 13);
            $table->string('razon_social');
            $table->string('uso_cfdi');
            $table->string('regimen_fiscal');
            $table->string('situacion_fiscal');
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
        Schema::dropIfExists('sucursales');
    }
};
