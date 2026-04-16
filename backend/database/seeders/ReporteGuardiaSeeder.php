<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReporteGuardia;
use App\Models\Guardia;
use App\Models\OrdenServicio;

class ReporteGuardiaSeeder extends Seeder
{
    public function run()
    {
        $guardias = Guardia::where('eliminado', false)->get();
        $ordenes = OrdenServicio::whereIn('estatus', ['En proceso', 'Finalizada'])->get();
        $faker = \Faker\Factory::create();

        // Seguridad: Verifica que hay datos base antes de poblar
        if ($guardias->isEmpty()) {
            $this->command->warn('No hay guardias activos (eliminado = false). Debes poblar la tabla guardias primero.');
            return;
        }
        if ($ordenes->isEmpty()) {
            $this->command->warn('No hay ordenes de servicio válidas (estatus En proceso/Finalizada). Pobla la tabla ordenes_servicio.');
            return;
        }

        for ($i = 0; $i < 12; $i++) {
            $guardia = $guardias->random();
            $orden = $ordenes->random();

            ReporteGuardia::create([
                'guardia_id' => $guardia->id,
                'orden_servicio_id' => $orden->id,
                'punto_vigilancia' => $faker->randomElement(['Almacén', 'Entrada', 'Patio', 'Recepción']),
                'turno' => $faker->randomElement(['DIA', 'NOCHE', '24H']),
                'quien_recibe' => $faker->firstName,
                'consignas' => [
                    ["texto" => $faker->sentence, "hora" => $faker->time('H:i')]
                ],
                'observaciones' => [
                    ["texto" => $faker->sentence, "hora" => $faker->time('H:i')]
                ],
                'equipo' => [
                    "baston" => $faker->boolean,
                    "celular" => $faker->boolean,
                    "chaleco" => $faker->boolean,
                    "esposas" => $faker->boolean,
                    "fornitura" => $faker->boolean,
                    "gas" => $faker->boolean,
                    "impermeable" => $faker->boolean,
                    "linterna" => $faker->boolean,
                    "radio" => $faker->boolean
                ],
            ]);
        }
    }
}
