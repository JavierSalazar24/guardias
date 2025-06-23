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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            // Información de sucursal
            $table->string('nombre_empresa')->nullable();
            $table->string('calle', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('colonia', 100)->nullable();
            $table->unsignedInteger('cp')->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('estado', 100)->nullable();
            $table->string('pais', 100)->nullable();
            $table->string('telefono_empresa', 15)->nullable();
            $table->string('extension_empresa', 10)->nullable();
            $table->string('nombre_contacto')->nullable();
            $table->string('telefono_contacto', 15)->nullable();
            $table->string('whatsapp_contacto', 15)->nullable();
            $table->string('correo_contacto', 100)->nullable()->unique();

            // Condiciones comerciales
            $table->integer('credito_dias')->default(0);
            $table->decimal('descuento_porcentaje', 10, 2)->nullable();

            $table->string('rfc', 13)->nullable();
            $table->string('razon_social')->nullable();
            $table->string('uso_cfdi')->nullable();
            $table->string('regimen_fiscal')->nullable();
            $table->string('situacion_fiscal')->nullable();

            // Servicios y personal
            $table->date('fecha_servicio');
            $table->text('servicios');
            $table->integer('guardias_dia');
            $table->decimal('precio_guardias_dia', 10, 2);
            $table->decimal('precio_guardias_dia_total', 10, 2);
            $table->integer('guardias_noche');
            $table->decimal('precio_guardias_noche', 10, 2);
            $table->decimal('precio_guardias_noche_total', 10, 2);
            $table->integer('cantidad_guardias');
            $table->enum('jefe_turno', ['SI', 'NO']);
            $table->integer('precio_jefe_turno')->nullable();
            $table->enum('supervisor', ['SI', 'NO']);
            $table->integer('precio_supervisor')->nullable();
            $table->text('notas')->nullable();
            $table->decimal('costo_extra', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuesto', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('aceptada', ['SI', 'NO', 'PENDIENTE'])->default('PENDIENTE');
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->onDelete('restrict');

            // Otra información
            $table->enum('soporte_documental', ['SI', 'NO'])->default('NO');
            $table->mediumText('observaciones_soporte_documental')->nullable();
            $table->mediumText('requisitos_pago_cliente')->nullable();

            $table->foreignId('sucursal_empresa_id')->constrained('sucursales_empresa')->onDelete('restrict');

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
        Schema::dropIfExists('cotizaciones');
    }
};
