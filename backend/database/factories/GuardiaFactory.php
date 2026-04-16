<?php

namespace Database\Factories;

use App\Models\Guardia;
use App\Models\SucursalEmpresa;
use App\Models\Sucursal;
use App\Models\Rango;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuardiaFactory extends Factory
{
    protected $model = Guardia::class;

    public function definition()
    {
        $nombre = $this->faker->firstName;
        $apellido_p = $this->faker->lastName;
        $apellido_m = $this->faker->lastName;

        return [
            'foto' => 'default.png',
            'nombre' => $nombre,
            'apellido_p' => $apellido_p,
            'apellido_m' => $apellido_m,
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '-18 years'),
            'telefono' => $this->faker->numerify('###########'),
            'correo' => $this->faker->unique()->safeEmail,
            'enfermedades' => $this->faker->word,
            'alergias' => $this->faker->word,
            'curp' => $this->faker->unique()->regexify('[A-Z]{4}\d{6}[A-Z]{6}\d{2}'),
            'clave_elector' => $this->faker->unique()->regexify('[A-Z0-9]{18}'),

            'calle' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'entre_calles' => $this->faker->streetAddress. ' y '. $this->faker->streetName,
            'colonia' => $this->faker->word,
            'cp' => $this->faker->numberBetween(10000, 99999),
            'estado' => $this->faker->state,
            'municipio' => $this->faker->city,
            'pais' => $this->faker->country,

            'contacto_emergencia' => $this->faker->name,
            'telefono_emergencia' => $this->faker->numerify('###########'),

            'sucursal_empresa_id' => SucursalEmpresa::inRandomOrder()->first()->id,
            'numero_empleado' => $this->faker->regexify('[A-Z0-9]{8}'),
            'cargo' => $this->faker->jobTitle,
            'cuip' => $this->faker->unique()->regexify('[A-Z0-9]{20}'),

            'numero_cuenta' => $this->faker->bankAccountNumber,
            'clabe' => $this->faker->numerify('####################'),
            'banco' => $this->faker->company . ' Bank',
            'nombre_propietario' => $this->faker->name,
            'comentarios_generales' => $this->faker->sentence,

            'sueldo_base' => $this->faker->randomFloat(2, 1000, 5000),
            'dias_laborales' => $this->faker->numberBetween(5, 6),
            'imss' => $this->faker->randomFloat(0, 100, 500),
            'infonavit' => $this->faker->randomFloat(2, 500, 1000),
            'fonacot' => $this->faker->randomFloat(2, 500, 1000),
            'retencion_isr' => $this->faker->randomFloat(2, 500, 1000),

            'fecha_alta' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'rango_id' => Rango::inRandomOrder()->first()->id,

            'antidoping' => 'default.pdf',
            'fecha_antidoping' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
