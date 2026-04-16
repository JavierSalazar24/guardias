<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportePatrulla;
use App\Models\Guardia;
use App\Models\Vehiculo;
use App\Models\OrdenServicio;

class ReportePatrullaSeeder extends Seeder
{
    public function run()
    {
        $guardias = Guardia::where('eliminado', false)->get();
        $ordenes = OrdenServicio::whereIn('estatus', ['En proceso', 'Finalizada'])->get();
        $vehiculos = Vehiculo::all();

        if ($guardias->isEmpty()) {
            $this->command->warn('No hay guardias activos (eliminado = false). Debes poblar la tabla guardias primero.');
            return;
        }
        if ($ordenes->isEmpty()) {
            $this->command->warn('No hay ordenes de servicio válidas (estatus En proceso/Finalizada). Pobla la tabla ordenes_servicio.');
            return;
        }
        if ($vehiculos->isEmpty()) {
            $this->command->warn('No hay vehículos. Pobla la tabla vehiculos.');
            return;
        }

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 6; $i++) {
            $guardia = $guardias->random();
            $orden = $ordenes->random();
            $vehiculo = $vehiculos->random();

            ReportePatrulla::create([
                'guardia_id' => $guardia->id,
                'orden_servicio_id' => $orden->id,
                'vehiculo_id' => $vehiculo->id,
                'licencia_manejo' => $faker->bothify('LIC-####'),
                'tarjeta_combustible' => $faker->bothify('TARJ-####'),
                'observaciones' => $faker->sentence(5),
                'recibido_por' => $faker->name,
                'datos_vehiculo' => [
                    "kilometraje_inicial" => $faker->numberBetween(1000, 5000),
                    "kilometraje_final" => $faker->numberBetween(5000, 10000),
                    "unidad_limpia" => $faker->boolean,
                    "placas" => $faker->bothify('???-####'),
                    "tarjeta_circulacion" => $faker->bothify('TC-#####')
                ],
                'llantas' => [
                    "llanta_delantera_derecha" => ["marca" => "Michelin", "condicion" => "Buena"],
                    "llanta_delantera_izquierda" => ["marca" => "Pirelli", "condicion" => "Regular"],
                    "llanta_trasera_derecha" => ["marca" => "Bridgestone", "condicion" => "Buena"],
                    "llanta_trasera_izquierda" => ["marca" => "Goodyear", "condicion" => "Regular"],
                    "llanta_extra" => ["marca" => "Continental", "condicion" => "Regular"]
                ],
                'niveles' => [
                    "nivel_agua_bateria" => "Buena",
                    "nivel_agua_radiador" => "Buena",
                    "nivel_aceite_motor" => "Buena",
                    "nivel_frenos" => "Buena",
                    "nivel_wipers" => "Buena",
                    "nivel_aceite_transmision" => "Buena"
                ],
                'interior_motor' => [
                    "bateria_marca" => "LTH",
                    "tapon_aceite" => $faker->boolean,
                    "varilla_medidora" => $faker->boolean,
                    "bandas_ventilador" => $faker->boolean,
                    "claxon" => $faker->boolean
                ],
                'interior_vehiculo' => [
                    "radio" => "Buena",
                    "rejillas_clima" => "Buena",
                    "guantera" => "Buena",
                    "descansabrazos" => "Buena",
                    "tapiceria" => "Buena",
                    "tapetes" => "Buena",
                    "encendedor" => "Buena",
                    "espejo_retrovisor" => "Buena",
                    "luz_interior" => "Buena"
                ],
                'marcadores_tablero' => [
                    "luces_direccionales" => "Buena",
                    "ac_calefaccion" => "Buena",
                    "swicth_ignicion" => "Buena",
                    "interrumptor_parabrisas" => "Buena",
                    "velocimetro" => "Buena",
                    "medidor_gasolina" => "Buena",
                    "medidor_temperatura" => "Buena",
                    "medidor_aceite" => "Buena"
                ],
                'herramientas' => [
                    "herramientas" => $faker->boolean,
                    "gato" => $faker->boolean,
                    "crucetas" => $faker->boolean,
                    "palanca_gato" => $faker->boolean,
                    "triangulos" => $faker->boolean,
                    "extintor" => $faker->boolean
                ],
                'documentacion' => [
                    "manual_vehiculo" => $faker->boolean,
                    "poliza_seguro" => $faker->boolean,
                    "placa_delantera" => $faker->boolean,
                    "placa_trasera" => $faker->boolean,
                    "torreta" => $faker->boolean
                ],
                'condiciones_mecanicas' => [
                    "sistema_frenos" => "Buena",
                    "sistema_clutch" => "Buena",
                    "sistema_suspension" => "Buena",
                    "sistema_motor" => "Buena",
                    "sistema_luces" => "Buena"
                ],
                'costado_derecho' => [
                    "condicion" => "Buena",
                    "vidrios_laterales" => "Buena",
                    "manija" => "Buena",
                    "cerraduras" => "Buena",
                    "copas_ruedas" => "Buena",
                    "tapon_gasolina" => "Buena"
                ],
                'costado_izquierda' => [
                    "condicion" => "Buena",
                    "vidrios_laterales" => "Buena",
                    "manija" => "Buena",
                    "cerraduras" => "Buena",
                    "copas_ruedas" => "Buena"
                ],
                'llaves_accesos' => [
                    "llaves_puertas_cajuela" => "Buena",
                    "llave_ignicion" => "Regular"
                ]
            ]);
        }
    }
}
