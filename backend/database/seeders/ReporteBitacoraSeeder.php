<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReporteBitacora;
use App\Models\Guardia;
use App\Models\OrdenServicio;
use Carbon\Carbon;

class ReporteBitacoraSeeder extends Seeder
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

        for ($i = 0; $i < 12; $i++) {
            $guardia = $guardias->random();
            $orden = $ordenes->random();

            ReporteBitacora::create([
                'guardia_id' => $guardia->id,
                'orden_servicio_id' => $orden->id,
                'patrulla' => $faker->bothify('###-???-##'),
                'zona' => $faker->randomElement(['Zona Sur', 'Zona Norte', 'Zona Este', 'Zona Oeste']),
                'kilometraje' => $faker->numberBetween(350000, 400000),
                'litros_carga' => $faker->randomFloat(2, 10, 50),
                'fecha' => Carbon::now()->subDays(rand(1,20)),
                'hora_inicio_recorrido' => '20:00:00',
                'hora_fin_recorrido' => '21:00:00',
                'guardias' => [
                    [
                        "nombre_guardia" => $faker->name,
                        "numero_empleado" => $faker->bothify('????????'),
                        "items" => [
                            "camisa" => true, "chaleco" => true, "corbata" => true, "esposas" => true,
                            "fornitura" => true, "gas" => true, "llave" => true, "pantalon" => true,
                            "peloCorto" => true, "puntualidad" => false, "rasurado" => false, "reportes" => true,
                            "tocado" => true, "tolete" => true, "zapatos" => true
                        ]
                    ],
                    [
                        "nombre_guardia" => $faker->name,
                        "numero_empleado" => $faker->bothify('????????'),
                        "items" => [
                            "camisa" => false, "chaleco" => false, "corbata" => false, "esposas" => false,
                            "fornitura" => false, "gas" => false, "llave" => false, "pantalon" => false,
                            "peloCorto" => false, "puntualidad" => true, "rasurado" => true, "reportes" => false,
                            "tocado" => false, "tolete" => false, "zapatos" => false
                        ]
                    ]
                ],
            ]);
        }
    }
}
