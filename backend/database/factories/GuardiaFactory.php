<?php

namespace Database\Factories;

use App\Models\Guardia;
use App\Models\SucursalEmpresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuardiaFactory extends Factory
{
    protected $model = Guardia::class;

    public function definition()
    {
        $nombre = $this->faker->firstName;
        $apellido_p = $this->faker->lastName;
        $apellido_m = $this->faker->lastName;
        $rango = $this->faker->randomElement(['Guardia', 'Supervisor', 'Jefe de turno']);

        return [
            'nombre' => $nombre,
            'apellido_p' => $apellido_p,
            'apellido_m' => $apellido_m,
            'correo' => $this->faker->unique()->safeEmail,
            'numero_empleado' => $this->faker->regexify('[A-Z0-9]{8}'),
            'calle' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'colonia' => $this->faker->word,
            'cp' => $this->faker->numberBetween(10000, 99999),
            'municipio' => $this->faker->city,
            'estado' => $this->faker->state,
            'pais' => $this->faker->country,
            'telefono' => $this->faker->numerify('###########'),
            'enfermedades' => $this->faker->word,
            'alergias' => $this->faker->word,
            'edad' => $this->faker->numberBetween(20, 60),
            'telefono_emergencia' => $this->faker->numerify('###########'),
            'contacto_emergencia' => $this->faker->name,
            'rango' => $this->faker->randomElement(['Guardia', 'Supervisor', 'Jefe de turno']),

            'foto' => 'default.png',
            'curp' => 'curp.pdf',
            'ine' => 'ine.pdf',
            'acta_nacimiento' => 'acta_nacimiento.pdf',
            'comprobante_domicilio' => 'comprobante_domicilio.pdf',

            'constancia_situacion_fiscal' => 'constancia_situacion_fiscal.pdf',
            'comprobante_estudios' => 'comprobante_estudios.pdf',
            'carta_recomendacion' => 'carta_recomendacion.pdf',
            'antecedentes_no_penales' => 'antecedentes_no_penales.pdf',
            'otro_archivo' => 'otro_archivo.pdf',

            'antidoping' => 'antidoping.pdf',
            'fecha_antidoping' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),

            'sueldo_base' => $this->faker->randomFloat(2, 5000, 15000),
            'dias_laborales' => $this->faker->numberBetween(5, 6),
            'imss' => $this->faker->numberBetween(0, 5),
            'infonavit' => $this->faker->randomFloat(2, 0, 3000),
            'fonacot' => $this->faker->randomFloat(2, 0, 3000),
            'retencion_isr' => $this->faker->randomFloat(2, 0, 1000),

            'sucursal_empresa_id' => SucursalEmpresa::inRandomOrder()->first()->id
        ];
    }
}
