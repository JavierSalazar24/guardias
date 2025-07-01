<?php

namespace Database\Factories;

use App\Models\Cotizacion;
use App\Models\SucursalEmpresa;
use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;

class CotizacionFactory extends Factory
{
    protected $model = Cotizacion::class;

    public function definition()
    {
        $precio_guardias_dia = $this->faker->randomFloat(2, 900, 1200);
        $guardias_dia = $this->faker->numberBetween(1, 6);
        $precio_guardias_dia_total = $precio_guardias_dia * $guardias_dia;

        $precio_guardias_noche = $this->faker->randomFloat(2, 1000, 1300);
        $guardias_noche = $this->faker->numberBetween(1, 6);
        $precio_guardias_noche_total = $precio_guardias_noche * $guardias_noche;

        $precio_jefe_turno = $this->faker->optional()->randomNumber(4);
        $precio_supervisor = $this->faker->optional()->randomNumber(4);

        $subtotal = $precio_guardias_dia_total + $precio_guardias_noche_total + ($precio_jefe_turno ?? 0) + ($precio_supervisor ?? 0);
        $impuesto = round($subtotal * 0.16, 2); // IVA del 16%
        $descuento = $this->faker->optional()->randomFloat(2, 0, 10);
        $costo_extra = $this->faker->optional()->randomFloat(2, 0, 500);
        $total = $subtotal + $impuesto - ($descuento ?? 0) + ($costo_extra ?? 0);

        return [
            'aceptada' => $this->faker->randomElement(['SI', 'NO', 'PENDIENTE']),
            'credito_dias' => $this->faker->numberBetween(0, 60),
            'precio_total_servicios' => 0, // Se actualiza en el seeder
            'guardias_dia' => $guardias_dia,
            'precio_guardias_dia' => $precio_guardias_dia,
            'precio_guardias_dia_total' => $precio_guardias_dia_total,
            'guardias_noche' => $guardias_noche,
            'precio_guardias_noche' => $precio_guardias_noche,
            'precio_guardias_noche_total' => $precio_guardias_noche_total,
            'cantidad_guardias' => $guardias_dia + $guardias_noche,
            'jefe_turno' => $this->faker->randomElement(['SI', 'NO']),
            'precio_jefe_turno' => $precio_jefe_turno,
            'supervisor' => $this->faker->randomElement(['SI', 'NO']),
            'precio_supervisor' => $precio_supervisor,
            'fecha_servicio' => $this->faker->dateTimeBetween('now', '+1 month'),
            'soporte_documental' => $this->faker->randomElement(['SI', 'NO']),
            'observaciones_soporte_documental' => $this->faker->optional()->sentence(),
            'requisitos_pago_cliente' => $this->faker->optional()->sentence(),
            'impuesto' => $impuesto,
            'subtotal' => $subtotal,
            'descuento_porcentaje' => $descuento,
            'costo_extra' => $costo_extra,
            'total' => $total,
            'notas' => $this->faker->optional()->sentence(),
        ];
    }
}
