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
        $subtotal = $this->faker->randomFloat(2, 1000, 5000);
        $impuesto = $this->faker->boolean;
        $total = $impuesto ? $subtotal * 0.16 : $subtotal;

        $jefe_turno = $this->faker->randomElement(['SI', 'NO']);
        $supervisor = $this->faker->randomElement(['SI', 'NO']);

        return [
            'nombre_empresa' => $this->faker->company,
            'calle' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'colonia' => $this->faker->word,
            'cp' => $this->faker->numerify('#####'),
            'municipio' => $this->faker->city,
            'estado' => $this->faker->state,
            'pais' => $this->faker->country,
            'telefono_empresa' => $this->faker->numerify('##########'),
            'extension_empresa' => $this->faker->optional()->numerify('###'),
            'nombre_contacto' => $this->faker->name,
            'telefono_contacto' => $this->faker->numerify('##########'),
            'whatsapp_contacto' => $this->faker->numerify('##########'),
            'correo_contacto' => $this->faker->unique()->safeEmail,

            'credito_dias' => $this->faker->numberBetween(0, 30),
            'descuento_porcentaje' => $this->faker->optional()->randomFloat(2, 0, 20),

            'fecha_servicio' => $this->faker->dateTimeBetween('-150 days', 'now')->format('Y-m-d'),
            'servicios' => $this->faker->sentence,
            'guardias_dia' => $this->faker->numberBetween(1, 10),
            'precio_guardias_dia' => $this->faker->randomFloat(2, 300, 500),
            'precio_guardias_dia_total' => $this->faker->randomFloat(2, 300, 500),
            'guardias_noche' => $this->faker->numberBetween(1, 10),
            'precio_guardias_noche' => $this->faker->randomFloat(2, 400, 600),
            'precio_guardias_noche_total' => $this->faker->randomFloat(2, 400, 600),
            'cantidad_guardias' => $this->faker->numberBetween(1, 20),

            'jefe_turno' => $jefe_turno,
            'precio_jefe_turno' => $jefe_turno === 'SI' ? $this->faker->numberBetween(500, 1500) : 0,
            'supervisor' => $supervisor,
            'precio_supervisor' => $supervisor === 'SI' ? $this->faker->numberBetween(500, 1500) : 0,

            'notas' => $this->faker->optional()->sentence,
            'costo_extra' => $this->faker->optional()->randomFloat(2, 100, 300),
            'subtotal' => $subtotal,
            'impuesto' => $impuesto,
            'total' => $total,
            'aceptada' => 'PENDIENTE',
            'sucursal_id' => Sucursal::factory(),

            'soporte_documental' => $this->faker->randomElement(['SI', 'NO']),
            'observaciones_soporte_documental' => $this->faker->paragraph(),
            'requisitos_pago_cliente' => $this->faker->paragraph(),

            'sucursal_empresa_id' => SucursalEmpresa::inRandomOrder()->first()->id
        ];
    }
}