<?php
namespace Database\Seeders;

use App\Models\Calendario;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CalendarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = Usuario::pluck('id')->values();

        if ($usuarios->count() < 2) {
            $this->command->warn('Se requieren al menos 2 usuarios para crear registros en calendario.');
            return;
        }

        $inicioMes = Carbon::now()->startOfMonth();

        $registros = [
            [
                'titulo' => 'Reunión de seguimiento operativo',
                'descripcion' => 'Revisión general de pendientes, incidencias activas y actividades programadas del mes.',
                'fecha_hora' => $inicioMes->copy()->setTime(9, 0, 0),
                'notas' => 'Se revisan prioridades, responsables y avances operativos.',
            ],
            [
                'titulo' => 'Entrega de reporte interno',
                'descripcion' => 'Presentación del resumen de actividades, incidencias y resultados acumulados.',
                'fecha_hora' => $inicioMes->copy()->addDays(4)->setTime(10, 30, 0),
                'notas' => 'La información debe estar validada antes de la reunión.',
            ],
            [
                'titulo' => 'Junta administrativa',
                'descripcion' => 'Sesión de seguimiento con enfoque en recursos, organización interna y pendientes del área.',
                'fecha_hora' => $inicioMes->copy()->addDays(9)->setTime(12, 0, 0),
                'notas' => 'Se da seguimiento a acuerdos y tareas asignadas.',
            ],
            [
                'titulo' => 'Revisión de unidades y recursos',
                'descripcion' => 'Validación del estado general de recursos operativos y necesidades de mantenimiento.',
                'fecha_hora' => $inicioMes->copy()->addDays(14)->setTime(8, 30, 0),
                'notas' => 'Registrar observaciones y prioridades detectadas.',
            ],
            [
                'titulo' => 'Cierre mensual de pendientes',
                'descripcion' => 'Revisión final de tareas abiertas y preparación del cierre administrativo del mes.',
                'fecha_hora' => Carbon::now()->endOfMonth()->setTime(17, 0, 0),
                'notas' => 'Confirmar pendientes resueltos y temas que pasarán al siguiente mes.',
            ],
        ];

        foreach ($registros as $index => $registro) {
            $creadorId = $usuarios[$index % $usuarios->count()];
            $invitadoId = $usuarios[($index + 1) % $usuarios->count()];

            Calendario::updateOrCreate(
                [
                    'titulo' => $registro['titulo'],
                    'fecha_hora' => $registro['fecha_hora']->format('Y-m-d H:i:s'),
                ],
                [
                    'creador_id' => $creadorId,
                    'invitado_id' => $invitadoId,
                    'descripcion' => $registro['descripcion'],
                    'notas' => $registro['notas'],
                ]
            );
        }
    }
}
