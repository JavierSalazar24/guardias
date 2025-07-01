<?php

namespace Database\Factories;
use App\Models\Banco;
use App\Models\Vehiculo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoletaGasolina>
 */
class BoletaGasolinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Escoge un banco y un vehículo aleatorio existente (o puedes pasarlos manualmente en el seeder)
        return [
            'kilometraje' => $this->faker->numberBetween(5000, 100000),
            'litros' => $this->faker->randomFloat(2, 10, 70),
            'costo_litro' => $this->faker->randomFloat(2, 20, 30),
            'costo_total' => $this->faker->randomFloat(2, 500, 2100),
            'observaciones' => $this->faker->optional()->sentence(),
            'metodo_pago' => $this->faker->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']),
            'referencia' => $this->faker->optional()->bothify('REF-####-??')
        ];
    }
}
