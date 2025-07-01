<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReporteIncidenteGuardia;
use App\Models\Guardia;
use App\Models\OrdenServicio;

class ReporteIncidenteGuardiaSeeder extends Seeder
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

            ReporteIncidenteGuardia::create([
                'guardia_id' => $guardia->id,
                'orden_servicio_id' => $orden->id,
                'punto_vigilancia' => $faker->randomElement(['Almacén', 'Entrada', 'Salida', 'Patio']),
                'turno' => $faker->randomElement(['DIA', 'NOCHE', '24H']),
                'incidente' => $faker->sentence(4),
                'descripcion' => $faker->sentence(8),
                'ubicacion' => $faker->address,
                'causa' => $faker->sentence(5),
                'quien_reporta' => $faker->name,
                'acciones' => $faker->sentence(8),
                'recomendaciones' => $faker->sentence(5),
                'lugar_incidente' => $faker->randomElement(['Comedor', 'Baño', 'Oficina']),
                'foto' => 'default_incidente.jpg',
                'estado' => $faker->randomElement(['Pendiente', 'Atendido']),
            ]);
        }
    }
}
