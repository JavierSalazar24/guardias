<?php
namespace Database\Factories;

use App\Models\ActaAdministrativa;
use App\Models\Guardia;
use App\Models\MotivoActa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActaAdministrativaFactory extends Factory
{
    protected $model = ActaAdministrativa::class;

    public function definition(): array
    {
        $guardias = Guardia::pluck('id')->toArray();

        if (count($guardias) < 4) {
            throw new \Exception('Se requieren al menos 4 guardias para generar actas administrativas.');
        }

        $ids = collect($guardias)->shuffle()->take(4)->values();

        $motivo = MotivoActa::inRandomOrder()->first();

        if (!$motivo) {
            $motivo = MotivoActa::factory()->create();
        }

        $comentarios = [
            'Retardo injustificado' => [
                'supervisor' => 'El supervisor manifiesta que el empleado se presentó tarde a su turno, afectando la cobertura del servicio y sin informar previamente la causa del retraso.',
                'empleado' => 'El empleado reconoce que llegó tarde por causas personales, indicando que no pudo avisar a tiempo y se compromete a evitar que vuelva a ocurrir.',
            ],
            'Inasistencia injustificada' => [
                'supervisor' => 'El supervisor hace constar que el empleado no se presentó a laborar en la fecha y horario asignados, sin existir aviso previo o justificación formal.',
                'empleado' => 'El empleado señala que tuvo una situación personal que le impidió asistir, aceptando que no siguió el procedimiento correcto para reportar su falta.',
            ],
            'Abandono de servicio' => [
                'supervisor' => 'El supervisor indica que el empleado se retiró temporalmente de su puesto sin autorización, dejando desprotegida el área asignada.',
                'empleado' => 'El empleado menciona que se ausentó del punto por un motivo urgente, aunque reconoce que debió informar primero a su superior inmediato.',
            ],
            'Incumplimiento de consignas' => [
                'supervisor' => 'El supervisor manifiesta que el empleado omitió seguir las consignas establecidas para el servicio, pese a haber sido previamente instruido.',
                'empleado' => 'El empleado comenta que entendió de forma incorrecta las instrucciones operativas y acepta que debió confirmar antes de actuar.',
            ],
            'Falta de respeto al supervisor' => [
                'supervisor' => 'El supervisor señala que el empleado respondió de manera inapropiada durante una indicación de servicio, generando una falta al orden interno.',
                'empleado' => 'El empleado reconoce que contestó en un tono incorrecto debido a la tensión del momento y ofrece una disculpa por lo ocurrido.',
            ],
            'Negligencia en el servicio' => [
                'supervisor' => 'El supervisor hace constar que el empleado descuidó actividades esenciales de vigilancia y control, comprometiendo el cumplimiento del servicio.',
                'empleado' => 'El empleado declara que no actuó con la atención debida durante el turno y acepta su responsabilidad en la omisión detectada.',
            ],
            'Uso indebido del equipo' => [
                'supervisor' => 'El supervisor reporta que el empleado utilizó equipo asignado de manera incorrecta, contraviniendo las indicaciones de operación.',
                'empleado' => 'El empleado menciona que desconocía el alcance del uso permitido del equipo, aunque acepta que debió solicitar orientación antes de utilizarlo.',
            ],
            'Dormir en horario laboral' => [
                'supervisor' => 'El supervisor manifiesta que encontró al empleado en condiciones de somnolencia durante su turno, afectando la vigilancia del servicio.',
                'empleado' => 'El empleado declara que se encontraba cansado por una situación previa, pero reconoce que eso no justifica su conducta en servicio.',
            ],
            'Presentarse sin uniforme completo' => [
                'supervisor' => 'El supervisor hace constar que el empleado se presentó sin el uniforme completo requerido, incumpliendo la imagen y lineamientos del servicio.',
                'empleado' => 'El empleado señala que tuvo un inconveniente con una prenda del uniforme y acepta que debió reportarlo antes de iniciar labores.',
            ],
            'Omisión de reporte de incidente' => [
                'supervisor' => 'El supervisor indica que el empleado no reportó oportunamente un incidente ocurrido durante su turno, dificultando la atención del evento.',
                'empleado' => 'El empleado comenta que consideró el incidente como menor en ese momento, aunque reconoce que debió reportarlo conforme al protocolo.',
            ],
            'Uso de teléfono personal en servicio' => [
                'supervisor' => 'El supervisor manifiesta que el empleado hizo uso de su teléfono personal durante el servicio sin justificación operativa.',
                'empleado' => 'El empleado acepta que utilizó su teléfono por un asunto personal breve, reconociendo que esto no estaba permitido en ese momento.',
            ],
            'Discusión con compañero de trabajo' => [
                'supervisor' => 'El supervisor reporta que el empleado sostuvo una discusión verbal con otro compañero, alterando el ambiente laboral durante el turno.',
                'empleado' => 'El empleado menciona que hubo una diferencia de opiniones con su compañero, pero reconoce que debió mantener una conducta profesional.',
            ],
        ];

        $texto = $comentarios[$motivo->motivo] ?? [
            'supervisor' => 'El supervisor hace constar una conducta contraria a las disposiciones internas durante el servicio.',
            'empleado' => 'El empleado manifiesta estar enterado de los hechos asentados en la presente acta.',
        ];

        return [
            'empleado_id' => $ids[0],
            'supervisor_id' => $ids[1],
            'testigo1_id' => $ids[2],
            'testigo2_id' => $ids[3],
            'motivo_id' => $motivo->id,
            'fecha_hora' => now()->subDays(rand(1, 30))->setTime(rand(8, 20), [0, 15, 30, 45][array_rand([0, 15, 30, 45])]),
            'dice_supervisor' => $texto['supervisor'],
            'dice_empleado' => $texto['empleado'],
        ];
    }
}
