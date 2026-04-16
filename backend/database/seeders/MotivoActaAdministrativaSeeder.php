<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotivoActa;

class MotivoActaAdministrativaSeeder extends Seeder
{
    public function run(): void
    {
        $motivos = [
            [
                'motivo' => 'Retardo injustificado',
                'descripcion' => 'El empleado se presentó después de la hora establecida sin previo aviso ni justificación válida.',
            ],
            [
                'motivo' => 'Inasistencia injustificada',
                'descripcion' => 'El empleado no se presentó a su turno laboral y no notificó su ausencia al supervisor.',
            ],
            [
                'motivo' => 'Abandono de servicio',
                'descripcion' => 'El empleado dejó su área de trabajo o servicio asignado sin autorización durante su jornada.',
            ],
            [
                'motivo' => 'Incumplimiento de consignas',
                'descripcion' => 'El empleado no siguió las instrucciones operativas o protocolos establecidos para su puesto.',
            ],
            [
                'motivo' => 'Falta de respeto al supervisor',
                'descripcion' => 'El empleado se dirigió al supervisor con palabras o actitudes inapropiadas durante el servicio.',
            ],
            [
                'motivo' => 'Negligencia en el servicio',
                'descripcion' => 'El empleado omitió actividades importantes de vigilancia, control o reporte durante su turno.',
            ],
            [
                'motivo' => 'Uso indebido del equipo',
                'descripcion' => 'El empleado utilizó herramientas, radios, bitácoras o equipo de trabajo de forma incorrecta o no autorizada.',
            ],
            [
                'motivo' => 'Dormir en horario laboral',
                'descripcion' => 'El empleado fue encontrado dormido o en evidente estado de somnolencia durante su jornada.',
            ],
            [
                'motivo' => 'Presentarse sin uniforme completo',
                'descripcion' => 'El empleado acudió a laborar sin portar el uniforme reglamentario o la imagen requerida.',
            ],
            [
                'motivo' => 'Omisión de reporte de incidente',
                'descripcion' => 'El empleado no informó un hecho relevante ocurrido durante el turno, afectando el seguimiento operativo.',
            ],
            [
                'motivo' => 'Uso de teléfono personal en servicio',
                'descripcion' => 'El empleado hizo uso no autorizado de su teléfono personal mientras se encontraba en funciones operativas.',
            ],
            [
                'motivo' => 'Discusión con compañero de trabajo',
                'descripcion' => 'El empleado protagonizó una discusión o conflicto verbal con otro elemento durante la jornada laboral.',
            ],
        ];

        foreach ($motivos as $motivo) {
            MotivoActa::updateOrCreate(
                ['motivo' => $motivo['motivo']],
                $motivo
            );
        }
    }
}
