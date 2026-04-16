<?php

namespace Database\Factories;

use App\Models\AlmacenSalida;
use App\Models\Articulo;
use App\Models\Guardia;
use App\Models\Almacen;
use App\Models\OrdenServicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlmacenSalidaFactory extends Factory
{
    protected $model = AlmacenSalida::class;

    public function definition(): array
    {
        $motivo = $this->faker->randomElement([
            'Asignado a guardia', 'Asignado a servicio', 'Devolución a proveedor', 'Venta', 'Destrucción', 'Mantenimiento', 'Robo', 'Pérdida', 'Otro'
        ]);

        // Solo tomamos artículos disponibles
        $almacen = Almacen::where('estado', 'Disponible')->inRandomOrder()->first();

        return [
            'guardia_id' => $motivo === 'Asignado a guardia' ? Guardia::inRandomOrder()->first()?->id : null,
            'orden_servicio_id' => $motivo === 'Asignado a servicio' ? OrdenServicio::inRandomOrder()->first()?->id : null,
            'articulo_id' => $almacen?->articulo_id,
            'numero_serie' => $almacen?->numero_serie,
            'fecha_salida' => $this->faker->date(),
            'motivo_salida' => $motivo,
            'motivo_salida_otro' => $motivo === 'Otro' ? $this->faker->sentence() : null,
        ];
    }
}
