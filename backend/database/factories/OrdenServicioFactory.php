<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrdenServicio>
 */
class OrdenServicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'codigo_orden_servicio' => $this->faker->unique()->bothify('ORD-####-??'),
            'domicilio_servicio' => $this->faker->address(),
            'nombre_responsable_sitio' => $this->faker->name(),
            'telefono_responsable_sitio' => $this->faker->numerify('55########'),
            'fecha_inicio' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'fecha_fin' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'estatus' => $this->faker->randomElement(['En proceso', 'Finalizada', 'Cancelada']),
            'observaciones' => $this->faker->optional()->sentence(),
            'eliminado' => false,
        ];
    }
}
