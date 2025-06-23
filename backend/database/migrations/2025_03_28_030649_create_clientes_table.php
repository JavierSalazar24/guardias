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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
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
            $table->string('pagina_web')->nullable();

            $table->string('nombre_contacto_admin', 100);
            $table->string('telefono_contacto_admin', 15);
            $table->string('whatsapp_contacto_admin', 15);
            $table->string('correo_contacto_admin', 100);

            $table->string('nombre_contacto_opera', 100);
            $table->string('telefono_contacto_opera', 15);
            $table->string('whatsapp_contacto_opera', 15);
            $table->string('correo_contacto_opera', 100);

            $table->unsignedInteger('credito_dias');
            $table->enum('metodo_pago', ['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']);
            $table->string('plataforma_facturas')->nullable();
            $table->enum('orden_compra', ['SI', 'NO'])->default('NO');

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
        Schema::dropIfExists('clientes');
    }
};
