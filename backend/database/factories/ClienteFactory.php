<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
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
            'pagina_web' => $this->faker->url,

            'nombre_contacto_admin' => $this->faker->name,
            'telefono_contacto_admin' => $this->faker->numerify('##########'),
            'whatsapp_contacto_admin' => $this->faker->numerify('##########'),
            'correo_contacto_admin' => $this->faker->unique()->safeEmail,

            'nombre_contacto_opera' => $this->faker->name,
            'telefono_contacto_opera' => $this->faker->numerify('##########'),
            'whatsapp_contacto_opera' => $this->faker->numerify('##########'),
            'correo_contacto_opera' => $this->faker->unique()->safeEmail,

            'credito_dias' => $this->faker->numberBetween(15, 90),
            'metodo_pago' => $this->faker->randomElement(['Transferencia bancaria', 'Tarjeta de crédito/débito', 'Efectivo', 'Cheques']),
            'plataforma_facturas' => $this->faker->url,
            'orden_compra' => $this->faker->randomElement(['SI', 'NO']),

            'rfc' => strtoupper($this->faker->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}')),
            'razon_social' => $this->faker->company() . ' S.A. de C.V.',
            'uso_cfdi' => $this->faker->randomElement(['G01', 'G03', 'I01', 'D01', 'P01',]),
            'regimen_fiscal' => $this->faker->randomElement(['601 - General de Ley Personas Morales', '605 - Sueldos y Salarios', '612 - Personas Físicas con Actividades Empresariales', '616 - Sin obligaciones fiscales',]),
            'situacion_fiscal' => 'situacion_fiscal.pdf',
        ];
    }
}
