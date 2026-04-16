<?php
namespace Database\Seeders;

use App\Models\Mantenimiento;
use App\Models\Taller;
use App\Models\Vehiculo;
use Illuminate\Database\Seeder;

class MantenimientoSeeder extends Seeder
{
    public function run(): void
    {
        $talleres = Taller::query()->get();
        $vehiculos = Vehiculo::query()->limit(8)->get();

        if ($talleres->count() < 5) {
            $this->command->warn('Se requieren al menos 5 talleres para crear los mantenimientos.');
            return;
        }

        if ($vehiculos->count() < 8) {
            $this->command->warn('Se requieren al menos 8 vehículos para crear los mantenimientos.');
            return;
        }

        $registros = [
            [
                'fecha_ingreso' => '2026-04-01',
                'motivo_ingreso' => 'Falla en el sistema de frenos; el vehículo presentó baja respuesta al frenado y ruido en balatas delanteras.',
                'fecha_salida' => '2026-04-03',
                'estatus' => 'Reparado',
                'notas' => 'Se reemplazaron balatas delanteras, se rectificaron discos y se purgó el sistema de frenos.',
                'costo_final' => 3850.00,
            ],
            [
                'fecha_ingreso' => '2026-04-02',
                'motivo_ingreso' => 'Cambio de aceite y filtros por mantenimiento preventivo al alcanzar el kilometraje programado.',
                'fecha_salida' => '2026-04-02',
                'estatus' => 'Reparado',
                'notas' => 'Se realizó cambio de aceite de motor, filtro de aceite y filtro de aire; se revisaron niveles generales.',
                'costo_final' => 1650.00,
            ],
            [
                'fecha_ingreso' => '2026-04-04',
                'motivo_ingreso' => 'Sobrecalentamiento de motor durante recorrido; se detectó incremento anormal de temperatura.',
                'fecha_salida' => null,
                'estatus' => 'En reparación',
                'notas' => 'Se encuentra en diagnóstico de sistema de enfriamiento, revisión de termostato, mangueras y posible fuga en radiador.',
                'costo_final' => 4200.00,
            ],
            [
                'fecha_ingreso' => '2026-04-05',
                'motivo_ingreso' => 'Ruido en suspensión delantera al circular sobre topes y vialidades irregulares.',
                'fecha_salida' => '2026-04-07',
                'estatus' => 'Reparado',
                'notas' => 'Se reemplazaron bujes y terminales; se ajustó suspensión y se realizó prueba de manejo.',
                'costo_final' => 2950.00,
            ],
            [
                'fecha_ingreso' => '2026-04-06',
                'motivo_ingreso' => 'Falla de arranque por batería descargada y revisión del sistema de carga.',
                'fecha_salida' => '2026-04-06',
                'estatus' => 'Reparado',
                'notas' => 'Se sustituyó batería y se verificó correcto funcionamiento del alternador.',
                'costo_final' => 3100.00,
            ],
            [
                'fecha_ingreso' => '2026-04-08',
                'motivo_ingreso' => 'Encendido del testigo Check Engine; se solicita diagnóstico electrónico del motor.',
                'fecha_salida' => null,
                'estatus' => 'En reparación',
                'notas' => 'Se detectaron códigos relacionados con sensor de oxígeno; pendiente reemplazo y borrado de códigos.',
                'costo_final' => 2800.00,
            ],
            [
                'fecha_ingreso' => '2026-04-09',
                'motivo_ingreso' => 'Desgaste irregular en neumáticos; se requiere alineación, balanceo y revisión de dirección.',
                'fecha_salida' => '2026-04-09',
                'estatus' => 'Reparado',
                'notas' => 'Se realizó alineación de 4 ruedas, balanceo y ajuste menor en dirección.',
                'costo_final' => 1450.00,
            ],
            [
                'fecha_ingreso' => '2026-04-10',
                'motivo_ingreso' => 'Fuga de anticongelante en radiador detectada durante inspección preventiva.',
                'fecha_salida' => '2026-04-12',
                'estatus' => 'No reparado',
                'notas' => 'Se confirmó daño estructural en el radiador; se cotizó reemplazo completo y quedó pendiente autorización.',
                'costo_final' => 5200.00,
            ],
        ];

        foreach ($registros as $index => $registro) {
            Mantenimiento::updateOrCreate(
                ['vehiculo_id' => $vehiculos[$index]->id],
                [
                    'fecha_ingreso' => $registro['fecha_ingreso'],
                    'motivo_ingreso' => $registro['motivo_ingreso'],
                    'fecha_salida' => $registro['fecha_salida'],
                    'estatus' => $registro['estatus'],
                    'notas' => $registro['notas'],
                    'costo_final' => $registro['costo_final'],
                    'taller_id' => $talleres[$index % $talleres->count()]->id,
                    'vehiculo_id' => $vehiculos[$index]->id,
                ]
            );
        }
    }
}
