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
            $table->enum('aceptada', ['SI', 'NO', 'PENDIENTE'])->default('PENDIENTE');
            $table->foreignId('sucursal_empresa_id')->constrained('sucursales_empresa')->onDelete('restrict');
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->onDelete('restrict');
            $table->integer('credito_dias')->default(0);
            $table->decimal('precio_total_servicios', 10, 2);
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
            $table->date('fecha_servicio');
            $table->enum('soporte_documental', ['SI', 'NO'])->default('NO');
            $table->mediumText('observaciones_soporte_documental')->nullable();
            $table->mediumText('requisitos_pago_cliente')->nullable();
            $table->decimal('impuesto', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento_porcentaje', 10, 2)->nullable();
            $table->decimal('costo_extra', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
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
        Schema::dropIfExists('cotizaciones');
    }
};
