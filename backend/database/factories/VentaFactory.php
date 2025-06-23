<?php

namespace Database\Factories;

use App\Models\Cotizacion;
use App\Models\Banco;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    public function definition(): array
    {
        $tipoPago = $this->faker->randomElement(['Crédito', 'Contado']);
        $fechaEmision = $this->faker->dateTimeBetween('-30 days', 'now');
        $fechaVencimiento = (clone $fechaEmision)->modify('+15 days');

        return [
            'cotizacion_id' => Cotizacion::factory(),
            'banco_id' => Banco::factory(),
            'numero_factura' => $this->faker->unique()->bothify('FAC-####'),
            'fecha_emision' => $fechaEmision->format('Y-m-d'),
            'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
            'total' => $this->faker->randomFloat(2, 1000, 5000),
            'nota_credito' => $this->faker->randomFloat(2, 0, 500),
            'tipo_pago' => $tipoPago,
            'metodo_pago' => $this->faker->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']),
            'estatus' => $this->faker->randomElement(['Pendiente', 'Pagada', 'Vencida', 'Cancelada']),
            'motivo_cancelada' => null,
            'eliminado' => false,
        ];
    }
}