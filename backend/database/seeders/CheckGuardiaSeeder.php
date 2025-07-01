<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CheckGuardia;
use App\Models\Guardia;
use App\Models\OrdenServicio;
use Carbon\Carbon;

class CheckGuardiaSeeder extends Seeder
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

        // 20 registros de ejemplo
        for ($i = 0; $i < 20; $i++) {
            $guardia = $guardias->random();
            $orden = $ordenes->random();
            $entrada = Carbon::now()->subDays(rand(0, 15))->setTime(rand(6, 20), rand(0,59));
            $salida = (clone $entrada)->addHours(rand(8,12));

            $tieneSalida = $faker->boolean(80); // 80% con salida

            CheckGuardia::create([
                'guardia_id' => $guardia->id,
                'orden_servicio_id' => $orden->id,
                'foto' => 'default_entrada.jpg',
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'ubicacion' => $faker->address,
                'comentarios' => $faker->optional()->sentence,
                'foto_salida' => $tieneSalida ? 'default_salida.png' : null,
                'latitude_salida' => $tieneSalida ? $faker->latitude : null,
                'longitude_salida' => $tieneSalida ? $faker->longitude : null,
                'ubicacion_salida' => $tieneSalida ? $faker->address : null,
                'comentarios_salida' => $tieneSalida ? $faker->optional()->sentence : null,
                'fecha_entrada' => $entrada,
                'fecha_salida' => $tieneSalida ? $salida : null,
                'tiempo_trabajado' => $tieneSalida ? $entrada->diff($salida)->format('%H:%I:%S') : null,
                'tiempo_trabajado_segundos' => $tieneSalida ? $salida->diffInSeconds($entrada) : null,
            ]);
        }
    }
}
