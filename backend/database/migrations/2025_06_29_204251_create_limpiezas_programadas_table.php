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
        Schema::create('limpiezas_programadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('restrict');
            $table->enum('tabla', [
                'guardias',
                'equipamiento',
                'incapacidades',
                'tiempo_extra',
                'faltas',
                'descuentos',
                'vacaciones',
                'prestamos',
                'pagos_empleados',
                'check_guardia',
                'reporte_bitacoras',
                'reportes_incidentes_guardia',
                'reportes_guardia',
                'reportes_supervisor',
                'reportes_patrulla',
                'qr_recorridos_guardia',
                'cotizaciones',
                'ventas',
                'ordenes_servicios',
                'boletas_gasolina',
                'ordenes_compra',
                'gastos',
            ]);
            $table->unsignedInteger('periodo_cantidad');
            $table->enum('periodo_tipo', ['dias', 'semanas', 'meses', 'anios']);
            $table->boolean('activa')->default(true);
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
        Schema::dropIfExists('limpiezas_programadas');
    }
};
