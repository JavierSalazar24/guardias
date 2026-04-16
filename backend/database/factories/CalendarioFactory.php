<?php
namespace Database\Factories;

use App\Models\Calendario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalendarioFactory extends Factory
{
    protected $model = Calendario::class;

    public function definition(): array
    {
        $usuarios = Usuario::pluck('id')->values();

        if ($usuarios->count() < 2) {
            throw new \Exception('Se requieren al menos 2 usuarios para generar registros en calendario.');
        }

        return [
            'creador_id' => $usuarios[0],
            'invitado_id' => $usuarios[1],
            'titulo' => 'Actividad programada',
            'descripcion' => 'Seguimiento interno de actividades del mes.',
            'fecha_hora' => now()->startOfMonth()->setTime(9, 0),
            'notas' => 'Evento genérico generado por factory.',
        ];
    }
}
