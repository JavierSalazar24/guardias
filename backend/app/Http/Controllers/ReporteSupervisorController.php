<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ReporteSupervisor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\RevisarOrdenSupervisor;

class ReporteSupervisorController extends Controller
{
    public function index()
    {
        $query = ReporteSupervisor::with(['guardia', 'orden_servicio.guardias'])->latest();
        $registros = RevisarOrdenSupervisor::mostrarOrdenesRelacionadas($query)->get();
        return response()->json($registros);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'orden_servicio_id' => 'required|exists:ordenes_servicios,id',
            'zona' => 'nullable|string',
            'turno' => 'nullable|in:DIA,NOCHE,24H',
            'quien_entrega' => 'nullable|string',
            'quien_recibe' => 'nullable|string',
            'observaciones' => 'nullable|array',
            'consignas' => 'nullable|array',
            'proyeccion' => 'nullable|array',
            'tipo' => 'nullable|string',
        ]);

        $reporte = ReporteSupervisor::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    public function destroy($id)
    {
        $registro = ReporteSupervisor::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function generarReporteSupervisor($reporteId)
    {
        $reporteSupervisor = ReporteSupervisor::find($reporteId);

        if (!$reporteSupervisor) {
            return response()->json(['error' => 'Reporte de supervisor no encontrado'], 404);
        }

        $observaciones = $reporteSupervisor->observaciones ?? 'No hay observaciones';
        $consignas = $reporteSupervisor->consignas ?? 'No hay consignas';

        $proyeccion = $reporteSupervisor->proyeccion;
        $proyeccionList = [
            'Cubre' => $proyeccion['cubre'] ?? 'No disponible',
            'Faltas' => $proyeccion['faltas'] ?? 'No disponible',
            'Servicio' => $proyeccion['servicio'] ?? 'No disponible'
        ];

        $data = [
            'reporteSupervisor' => $reporteSupervisor,
            'observaciones' => $observaciones,
            'consignas' => $consignas,
            'proyeccionList' => $proyeccionList
        ];

        $pdf = PDF::loadView('pdf.reporte_supervisor', $data)->setPaper('letter', 'portrait');

        $codigoOrden = $reporteSupervisor->orden_servicio->codigo_orden_servicio;
        $fileName = "Reporte de Supervisor - Orden de servicio #{$codigoOrden}.pdf";

        return $pdf->stream($fileName);
    }
}
