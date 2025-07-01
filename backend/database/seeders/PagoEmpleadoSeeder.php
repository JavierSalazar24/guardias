<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PagoEmpleado;
use App\Models\Guardia;
use App\Models\Banco;
use App\Models\Falta;
use App\Models\Descuento;
use App\Models\TiempoExtra;
use App\Models\Vacacion;
use App\Models\Incapacidad;
use Carbon\Carbon;

class PagoEmpleadoSeeder extends Seeder
{
    public function run()
    {
        $guardias = Guardia::where('eliminado', false)->inRandomOrder()->take(8)->get();
        $bancos = Banco::all();
        $faker = \Faker\Factory::create();

        foreach ($guardias as $guardia) {
            // Simula un periodo semanal reciente (dentro de los últimos 60 días)
            $periodoFin = Carbon::now()->subDays(rand(0, 60));
            $periodoInicio = (clone $periodoFin)->subDays(6);

            $sueldo_base = $guardia->sueldo_base;
            $dias_laborales = $guardia->dias_laborales ?? 6;
            $sueldo_diario = $sueldo_base / $dias_laborales;
            $imss = $guardia->imss;
            $infonavit = $guardia->infonavit;
            $fonacot = $guardia->fonacot;
            $retencion_isr = $guardia->retencion_isr;

            // Faltas
            $faltas = FALTA::where('guardia_id', $guardia->id)
                ->whereBetween('fecha_inicio', [$periodoInicio, $periodoFin])
                ->get();
            $totalFaltas = $faltas->sum('cantidad_faltas');
            $totalFaltasMonto = $faltas->sum('monto');

            // Descuentos
            $descuentos = Descuento::where('guardia_id', $guardia->id)
                ->whereBetween('fecha', [$periodoInicio, $periodoFin])
                ->get();
            $totalDescuentos = $descuentos->sum('monto');

            // Tiempo extra
            $tiempoExtra = TiempoExtra::where('guardia_id', $guardia->id)
                ->whereBetween('fecha_inicio', [$periodoInicio, $periodoFin])
                ->get();
            $totalTiempoExtra = $tiempoExtra->sum('monto_total');

            // Vacaciones
            $vacaciones = Vacacion::where('guardia_id', $guardia->id)
                ->whereBetween('fecha_inicio', [$periodoInicio, $periodoFin])
                ->get();
            $primaVacacional = $vacaciones->sum('prima_vacacional');

            // Incapacidades
            $incapacidades = Incapacidad::where('guardia_id', $guardia->id)
                ->whereBetween('fecha_inicio', [$periodoInicio, $periodoFin])
                ->get();
            $incapPagadas = $incapacidades->sum('pago_empresa');
            // Días no pagados
            $incapNoPagadas = $incapacidades->filter(fn($i) => $i->pago_empresa == 0)
                ->reduce(function ($total, $incap) use ($sueldo_diario) {
                    $dias = Carbon::parse($incap->fecha_inicio)->diffInDays(Carbon::parse($incap->fecha_fin)) + 1;
                    return $total + ($dias * $sueldo_diario);
                }, 0);

            // Días trabajados y monto a pagar por días trabajados (¡OJO! Este campo es el monto, no el conteo de días)
            $diasTrabajados = max(0, $dias_laborales - $totalFaltas);
            $pagoPorDiasTrabajados = $diasTrabajados * $sueldo_diario;

            // Totales
            $total_ingresos = $pagoPorDiasTrabajados + $totalTiempoExtra + $primaVacacional + $incapPagadas;
            $total_egresos = $totalFaltasMonto + $totalDescuentos + $incapNoPagadas;
            $total_retenciones = $imss + $infonavit + $fonacot + $retencion_isr;
            $pago_bruto = $total_ingresos - $total_egresos;
            $pago_final = $pago_bruto - $total_retenciones;

            PagoEmpleado::create([
                'banco_id' => $bancos->random()->id,
                'guardia_id' => $guardia->id,
                'sueldo_base' => $sueldo_base,
                'periodo_inicio' => $periodoInicio,
                'periodo_fin' => $periodoFin,
                'dias_trabajados' => $pagoPorDiasTrabajados,
                'tiempo_extra' => $totalTiempoExtra,
                'prima_vacacional' => $primaVacacional,
                'incapacidades_pagadas' => $incapPagadas,
                'descuentos' => $totalDescuentos,
                'faltas' => $totalFaltasMonto,
                'incapacidades_no_pagadas' => $incapNoPagadas,
                'imss' => $imss,
                'infonavit' => $infonavit,
                'fonacot' => $fonacot,
                'retencion_isr' => $retencion_isr,
                'total_ingresos' => $total_ingresos,
                'total_egresos' => $total_egresos,
                'total_retenciones' => $total_retenciones,
                'pago_bruto' => $pago_bruto,
                'pago_final' => $pago_final,
                'observaciones' => $faker->optional()->sentence(10),
                'metodo_pago' => $faker->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']),
                'referencia' => $faker->optional(0.5)->bothify('REF-####'),
            ]);
        }
    }
}
