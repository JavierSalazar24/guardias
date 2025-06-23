<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QRGenerado;
use App\Models\QRPuntoRecorrido;
use App\Models\OrdenServicio;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRGeneradoController extends Controller
{
     public function index()
    {
        $registros = QRGenerado::with('orden_servicio')->get();
        return response()->json($registros);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'orden_servicio_id' => 'required|exists:ordenes_servicios,id',
            'cantidad' => 'required|integer|min:1|max:50',
            'notas' => 'nullable|string'
        ]);

        $registro = QRGenerado::create($data);

        $puntos = [];
        for ($i = 1; $i <= $request->cantidad; $i++) {
            $puntos[] = QRPuntoRecorrido::create([
                'qr_generado_id' => $registro->id,
                'nombre_punto' => "Punto $i",
                'codigo_qr' => Str::uuid(),
            ]);
        }

        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {

        $registro = QRGenerado::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'notas' => 'sometimes|string|max:50',
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);

        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = QRGenerado::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function generarPdf($ordenId)
    {
        $orden = OrdenServicio::with(['venta.cotizacion.sucursal.cliente', 'ordenesServicioGuardias.guardia'])->find($ordenId);
        if (!$orden) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $qrs = QRGenerado::with('puntos_recorrido')->where('orden_servicio_id', $ordenId)->get();

        $puntos = [];

        foreach ($qrs as $qrGenerado) {
            foreach ($qrGenerado->puntos_recorrido as $punto) {
                $svg = QrCode::format('svg')->size(200)->generate($punto->codigo_qr);
                $punto->image_base64 = base64_encode($svg);
                $puntos[] = $punto;
            }
        }

        $data = [
            'orden' => $orden,
            'puntos' => collect($puntos),
        ];

        $pdf = Pdf::loadView('pdf.qrs_recorrido', $data)->setPaper('letter', 'portrait');
        return $pdf->stream("qrs_recorrido_orden_{$orden->codigo_orden_servicio}.pdf");
    }
}