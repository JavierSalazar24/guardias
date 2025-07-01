<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ReporteIncidenteGuardia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\RevisarOrdenSupervisor;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;

class ReporteIncidenteGuardiaController extends Controller
{
    public function index()
    {
        $query = ReporteIncidenteGuardia::with(['guardia', 'orden_servicio.guardias'])->latest();
        $registros = RevisarOrdenSupervisor::mostrarOrdenesRelacionadas($query)->get();
        return response()->json($registros->append('foto_incidente_url'));
    }

    public function store(Request $request)
    {
         $data = $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'orden_servicio_id' => 'required|exists:ordenes_servicios,id',
            'punto_vigilancia' => 'nullable|string',
            'turno' => 'nullable|in:DIA,NOCHE,24H',
            'incidente' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string',
            'causa' => 'nullable|string',
            'quien_reporta' => 'nullable|string',
            'acciones' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
            'lugar_incidente' => 'nullable|string',
            'foto' => 'nullable|string',
        ]);

        $reporte = ReporteIncidenteGuardia::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = ReporteIncidenteGuardia::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'estado' => 'required|in:Pendiente,Atendido',
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    public function destroy($id)
    {
        $registro = ReporteIncidenteGuardia::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function generarReporteIncidente($reporteId)
    {
        $reporteIncidente = ReporteIncidenteGuardia::find($reporteId);

        if (!$reporteIncidente) {
            return response()->json(['error' => 'Reporte de incidente no encontrado'], 404);
        }

        $fotoUrl = null;
        if (!empty($reporteIncidente->foto) && Storage::exists('public/incidentes_guardia/' . $reporteIncidente->foto)) {
            $fotoUrl = Storage::url('incidentes_guardia/' . $reporteIncidente->foto);
        }

        $data = [
            'reporteIncidente' => $reporteIncidente,
            'fotoUrl' => $fotoUrl,
        ];

        $pdf = Pdf::loadView('pdf.reporte_incidente_guardia', $data)->setPaper('letter', 'portrait');

        $codigoOrden = $reporteIncidente->orden_servicio->codigo_orden_servicio;
        $fileName = "Reporte de Incidente - Orden de servicio #{$codigoOrden}.pdf";

        return $pdf->stream($fileName);
    }
}
