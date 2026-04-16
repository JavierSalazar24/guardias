<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PagoEmpleadoFactory extends Factory
{
    public function definition()
    {
        // Simulamos un periodo de pago de 7 días
        $periodoInicio = $this->faker->dateTimeBetween('-4 months', 'now');
        $periodoFin = (clone $periodoInicio)->modify('+6 days');

        // Estos campos se llenan desde el Seeder porque dependen del guardia
        return [
            // 'guardia_id', 'banco_id', 'sueldo_base', 'imss', 'infonavit', 'fonacot', 'retencion_isr' van desde el Seeder
            'periodo_inicio' => $periodoInicio->format('Y-m-d'),
            'periodo_fin' => $periodoFin->format('Y-m-d'),

            // Sumatorias: estos los simulamos, pero se calculan en el Seeder
            // 'dias_trabajados', 'tiempo_extra', 'prima_vacacional', 'incapacidades_pagadas', ...
            // 'descuentos', 'faltas', 'incapacidades_no_pagadas',
            // 'total_ingresos', 'total_egresos', 'total_retenciones', 'pago_bruto', 'pago_final',

            'observaciones' => $this->faker->optional()->sentence(12),
            'metodo_pago' => $this->faker->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']),
            'referencia' => $this->faker->optional(0.5)->bothify('REF-####'),
        ];
    }
}
