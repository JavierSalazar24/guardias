<?php

namespace Database\Factories;

use App\Models\MovimientoBancario;
use App\Models\Banco;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovimientoBancarioFactory extends Factory
{
    protected $model = MovimientoBancario::class;

    public function definition(): array
    {
        // Definimos posibles tipos de origen
        $origenTipos = [
            'venta',
            'gasto',
            'orden_compra',
            'abonos_prestamo',
            'pagos_empleados',
            'prestamos',
            null, // Para movimientos que no tienen un origen ligado (manuales)
        ];
        $origen_type = $this->faker->randomElement($origenTipos);

        // Solo si origen_type no es null generamos un id entre 1 y 10, de lo contrario null
        $origen_id = $origen_type ? $this->faker->numberBetween(1, 10) : null;

        return [
            'banco_id'      => Banco::inRandomOrder()->first()?->id ?? 1,
            'tipo_movimiento' => $this->faker->randomElement(['Ingreso', 'Egreso']),
            'concepto'      => $this->faker->sentence(),
            'fecha'         => $this->faker->dateTimeBetween('-150 days', 'now')->format('Y-m-d'),
            'referencia'    => $this->faker->optional()->uuid(),
            'monto'         => $this->faker->randomFloat(2, 100, 10000),
            'metodo_pago'   => $this->faker->randomElement([
                'Transferencia bancaria',
                'Tarjeta de crédito/débito',
                'Efectivo',
                'Cheques'
            ]),
            'origen_id'     => $origen_id,
            'origen_type'   => $origen_type,
        ];
    }
}
