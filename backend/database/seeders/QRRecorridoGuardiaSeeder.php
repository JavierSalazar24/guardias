<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QRRecorridoGuardia;
use App\Models\Guardia;
use App\Models\QRPuntoRecorrido;
use Carbon\Carbon;

class QRRecorridoGuardiaSeeder extends Seeder
{
    public function run()
    {
        $guardias = Guardia::where('eliminado', false)->get();
        $puntos = QRPuntoRecorrido::all();
        $faker = \Faker\Factory::create();

        if ($guardias->isEmpty()) {
            $this->command->warn('No hay guardias activos (eliminado = false). Debes poblar la tabla guardias primero.');
            return;
        }
        if ($puntos->isEmpty()) {
            $this->command->warn('No hay QRs válidos.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $guardia = $guardias->random();
            $punto = $puntos->random();

            QRRecorridoGuardia::create([
                'guardia_id' => $guardia->id,
                'qr_punto_id' => $punto->id,
                'fecha_escaneo' => Carbon::now()->subDays(rand(0, 30)),
                'observaciones' => $faker->optional()->sentence(10),
                'foto' => 'default_recorrido.jpeg',
            ]);
        }
    }
}
