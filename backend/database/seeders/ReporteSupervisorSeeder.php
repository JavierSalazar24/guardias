<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReporteSupervisor;
use App\Models\Guardia;
use App\Models\OrdenServicio;

class ReporteSupervisorSeeder extends Seeder
{
    public function run()
    {
        $guardias = Guardia::where('eliminado', false)->get();
        $ordenes = OrdenServicio::whereIn('estatus', ['En proceso', 'Finalizada'])->get();

        if ($guardias->isEmpty()) {
            $this->command->warn('No hay guardias activos (eliminado = false). Debes poblar la tabla guardias primero.');
            return;
        }
        if ($ordenes->isEmpty()) {
            $this->command->warn('No hay ordenes de servicio válidas (estatus En proceso/Finalizada). Pobla la tabla ordenes_servicio.');
            return;
        }

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 8; $i++) {
            $guardia = $guardias->random();
            $orden = $ordenes->random();

            ReporteSupervisor::create([
                'guardia_id' => $guardia->id,
                'orden_servicio_id' => $orden->id,
                'zona' => $faker->randomElement(['Zona Sur', 'Zona Norte', 'Zona Este', 'Zona Oeste']),
                'turno' => $faker->randomElement(['DIA', 'NOCHE', '24H']),
                'quien_entrega' => $faker->firstName,
                'quien_recibe' => $faker->firstName,
                'observaciones' => [
                    ["texto" => $faker->sentence, "hora" => "12:12"]
                ],
                'consignas' => [
                    ["texto" => $faker->sentence, "hora" => "11:11"]
                ],
                'proyeccion' => [
                    ["cubre" => $faker->name, "faltas" => $faker->name, "servicio" => $faker->bothify('ORD-###')]
                ],
                'tipo' => $faker->word,
            ]);
        }
    }
}
