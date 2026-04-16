<?php
namespace Database\Factories;

use App\Models\Mantenimiento;
use App\Models\Taller;
use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class MantenimientoFactory extends Factory
{
    protected $model = Mantenimiento::class;

    public function definition(): array
    {
        $tallerId = Taller::query()->inRandomOrder()->value('id');
        $vehiculoId = Vehiculo::query()
            ->whereNotIn('id', Mantenimiento::pluck('vehiculo_id'))
            ->inRandomOrder()
            ->value('id');

        if (!$tallerId) {
            throw new \Exception('No existen talleres registrados.');
        }

        if (!$vehiculoId) {
            throw new \Exception('No existen vehículos disponibles para asignar al mantenimiento.');
        }

        return [
            'fecha_ingreso' => now()->toDateString(),
            'motivo_ingreso' => 'Revisión mecánica general y diagnóstico preventivo.',
            'fecha_salida' => null,
            'estatus' => 'En reparación',
            'notas' => 'Unidad ingresada para inspección inicial en taller.',
            'costo_final' => 0.00,
            'taller_id' => $tallerId,
            'vehiculo_id' => $vehiculoId,
        ];
    }
}
