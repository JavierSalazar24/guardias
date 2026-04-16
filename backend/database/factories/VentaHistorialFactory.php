<?php

namespace Database\Factories;

use App\Models\Banco;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaHistorialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'venta_id' => Venta::factory(), // solo útil si generas venta desde aquí
            'banco_id' => Banco::factory(),
            'cotizacion_id' => Cotizacion::factory(),
            'numero_factura' => $this->faker->unique()->bothify('FAC-####'),
            'fecha_emision' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'fecha_vencimiento' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'total' => $this->faker->randomFloat(2, 1000, 5000),
            'nota_credito' => $this->faker->randomFloat(2, 0, 500),
            'credito_dias' => $this->faker->numberBetween(15, 60),
            'tipo_pago' => $this->faker->randomElement(['Crédito', 'Contado']),
            'metodo_pago' => $this->faker->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']),
            'estatus' => $this->faker->randomElement(['Pendiente', 'Pagada', 'Vencida', 'Cancelada']),
            'motivo_cancelada' => null,
            'accion' => $this->faker->randomElement(['Creación', 'Edición', 'Cancelación']),
            'usuario_id' => 1,
        ];
    }
}