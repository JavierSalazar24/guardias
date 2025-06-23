<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ReportePatrulla;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\RevisarOrdenSupervisor;

class ReportePatrullaController extends Controller
{
    public function index()
    {
        $query = ReportePatrulla::with(['guardia', 'orden_servicio.guardias'])->latest();
        $registros = RevisarOrdenSupervisor::mostrarOrdenesRelacionadas($query)->get();
        return response()->json($registros);
    }

    public function store(Request $request)
    {
         $data = $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'orden_servicio_id' => 'required|exists:ordenes_servicios,id',
            'licencia_manejo' => 'nullable|string',
            'tarjeta_combustible' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'recibido_por' => 'nullable|string',
            'datos_vehiculo' => 'nullable|array',
            'llantas' => 'nullable|array',
            'niveles' => 'nullable|array',
            'interior_motor' => 'nullable|array',
            'interior_vehiculo' => 'nullable|array',
            'marcadores_tablero' => 'nullable|array',
            'herramientas' => 'nullable|array',
            'documentacion' => 'nullable|array',
            'condiciones_mecanicas' => 'nullable|array',
            'costado_derecho' => 'nullable|array',
            'costado_izquierda' => 'nullable|array',
            'llaves_accesos' => 'nullable|array',
        ]);

        $reporte = ReportePatrulla::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    public function destroy($id)
    {
        $registro = ReportePatrulla::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function generarReportePatrulla($id)
    {
        $reporte = ReportePatrulla::with(['guardia', 'orden_servicio'])->find($id);

        if (!$reporte) {
            return response()->json(['error' => 'Reporte no encontrado'], 404);
        }

        $pdf = Pdf::loadView('pdf.reporte_patrullas', compact('reporte'))->setPaper('letter', 'portrait');

        $guardiaNombre = $reporte->guardia->nombre . ' ' . $reporte->guardia->apellido_p . ' ' . $reporte->guardia->apellido_m;
        $numeroEmpleado = $reporte->guardia->numero_empleado;
        $codigoOrden = $reporte->orden_servicio->codigo_orden_servicio;

        $fileName = "Reporte de Patrulla - Orden de servicio #{$codigoOrden}.pdf";

        return $pdf->stream($fileName);
    }
}