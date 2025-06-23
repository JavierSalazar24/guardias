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
        Schema::create('ventas_historial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('restrict');
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('restrict');
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('restrict');
            $table->foreignId('banco_id')->nullable()->constrained('bancos')->onDelete('restrict');
            $table->string('numero_factura')->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento')->nullable();
            $table->decimal('total', 10, 2);
            $table->decimal('nota_credito', 10, 2);
            $table->integer('credito_dias');
            $table->enum('tipo_pago', ['Crédito', 'Contado'])->nullable();
            $table->enum('metodo_pago', ['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques'])->nullable();
            $table->enum('estatus', ['Pendiente', 'Pagada', 'Vencida', 'Cancelada'])->default('Pendiente');
            $table->text('motivo_cancelada')->nullable();
            $table->string('accion');
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
        Schema::dropIfExists('ventas_historial');
    }
};
