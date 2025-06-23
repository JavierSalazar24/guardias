<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ReporteBitacora;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\RevisarOrdenSupervisor;

class ReporteBitacoraController extends Controller
{
    public function index()
    {
        $query = ReporteBitacora::with(['guardia', 'orden_servicio.guardias'])->latest();
        $registros = RevisarOrdenSupervisor::mostrarOrdenesRelacionadas($query)->get();

        return response()->json($registros);
    }

    public function store(Request $request)
    {
         $data = $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'orden_servicio_id' => 'required|exists:ordenes_servicios,id',
            'codigo_servicio' => 'nullable|string',
            'patrulla' => 'nullable|string',
            'zona' => 'nullable|string',
            'kilometraje' => 'nullable|numeric',
            'litros_carga' => 'nullable|numeric',
            'fecha' => 'nullable|date',
            'hora_inicio_recorrido' => 'nullable|date_format:H:i:s',
            'hora_fin_recorrido' => 'nullable|date_format:H:i:s',
            'guardias' => 'nullable|array',
        ]);

        $reporte = ReporteBitacora::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    public function destroy($id)
    {
        $registro = ReporteBitacora::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function generarReporteBitacora($id)
    {
        $reporte = ReporteBitacora::with(['guardia', 'orden_servicio'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.reporte_bitacoras', compact('reporte'))->setPaper('letter', 'portrait');

        $guardiaNombre = $reporte->guardia->nombre . ' ' . $reporte->guardia->apellido_p . ' ' . $reporte->guardia->apellido_m;
        $numeroEmpleado = $reporte->guardia->numero_empleado;
        $codigoOrden = $reporte->orden_servicio->codigo_orden_servicio;

        $fileName = "Reporte de Bitácora - Orden de servicio #{$codigoOrden}.pdf";

        return $pdf->stream($fileName);
    }
}
