<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ReporteGuardia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\RevisarOrdenSupervisor;

class ReporteGuardiaController extends Controller
{
    public function index()
    {
        $query = ReporteGuardia::with(['guardia', 'orden_servicio.guardias'])->latest();
        $registros = RevisarOrdenSupervisor::mostrarOrdenesRelacionadas($query)->get();
        return response()->json($registros);
    }

     public function store(Request $request)
    {
        $data = $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'orden_servicio_id' => 'required|exists:ordenes_servicios,id',
            'punto_vigilancia' => 'nullable|string',
            'turno' => 'nullable|in:DIA,NOCHE,24H',
            'quien_recibe' => 'nullable|string',
            'observaciones' => 'nullable|array',
            'consignas' => 'nullable|array',
            'equipo' => 'nullable|array',
        ]);

        $reporte = ReporteGuardia::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    public function destroy($id)
    {
        $registro = ReporteGuardia::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function generarReporteGuardia($reporteId)
    {
        $reporteGuardia = ReporteGuardia::find($reporteId);

        if (!$reporteGuardia) {
            return response()->json(['error' => 'Reporte de guardia no encontrado'], 404);
        }

        $equipo = implode(', ', array_keys(array_filter($reporteGuardia->equipo)));

        $data = [
            'reporteGuardia' => $reporteGuardia,
            'equipo' => $equipo,
        ];

        $pdf = Pdf::loadView('pdf.reporte_guardia', $data)->setPaper('letter', 'portrait');

        $codigoOrden = $reporteGuardia->orden_servicio->codigo_orden_servicio;
        $fileName = "Reporte de Guardia - Orden de servicio #{$codigoOrden}.pdf";

        return $pdf->stream($fileName);
    }

}
