<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActaAdministrativa;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ActaAdministrativaController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = ActaAdministrativa::with(['empleado.rango', 'supervisor.rango', 'testigo1.rango', 'testigo2.rango', 'motivo_acta'])->get();
        return response()->json($registros);
    }

    // PDF de la incidencia
    public function generarPDF($id)
    {
        $incidencia = ActaAdministrativa::with(['empleado.sucursal_empresa', 'supervisor', 'testigo1', 'testigo2', 'motivo_acta'])->find($id);

        $trabajador = strtoupper($incidencia->empleado->apellido_p . ' ' . $incidencia->empleado->apellido_m . ' ' . $incidencia->empleado->nombre);
        $supervisor = strtoupper($incidencia->supervisor->nombre . ' ' . $incidencia->supervisor->apellido_p . ' ' . $incidencia->supervisor->apellido_m);

        $hora = Carbon::now()->locale('es')->format('h:i A');
        $fecha = Carbon::now()->locale('es')->translatedFormat('d \\d\\e F \\d\\e\\l Y');
        $fechaIncidente = Carbon::parse($incidencia->fecha)->locale('es')->translatedFormat('d \\d\\e F \\d\\e\\l Y');
        $testigo1 = strtoupper($incidencia->testigo1->nombre . ' ' . $incidencia->testigo1->apellido_p . ' ' . $incidencia->testigo1->apellido_m);
        $testigo2 = strtoupper($incidencia->testigo2->nombre . ' ' . $incidencia->testigo2->apellido_p . ' ' . $incidencia->testigo2->apellido_m);

        $pdf = Pdf::loadView('pdf.acta_administrativa', compact('incidencia', 'trabajador', 'supervisor', 'fecha', 'hora', 'fechaIncidente', 'testigo1', 'testigo2'));
        return $pdf->stream('acta_administrativa_de_' . $trabajador . ' - ' . $fechaIncidente . '.pdf');
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'empleado_id' => 'required|exists:guardias,id',
            'supervisor_id' => 'required|exists:guardias,id',
            'testigo1_id' => 'required|exists:guardias,id',
            'testigo2_id' => 'required|exists:guardias,id',
            'motivo_id' => 'required|exists:motivos_actas_administrativas,id',
            'fecha_hora' => 'required|date',
            'dice_supervisor' => 'required|string',
            'dice_empleado' => 'required|string'
        ]);

        $registro = ActaAdministrativa::create($data);

        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = ActaAdministrativa::with(['empleado', 'supervisor', 'testigo1', 'testigo2', 'motivo_acta'])->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = ActaAdministrativa::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'empleado_id' => 'sometimes|exists:guardias,id',
            'supervisor_id' => 'sometimes|exists:guardias,id',
            'testigo1_id' => 'sometimes|exists:guardias,id',
            'testigo2_id' => 'sometimes|exists:guardias,id',
            'fecha_hora' => 'sometimes|date',
            'motivo_id' => 'sometimes|exists:motivos_actas_administrativas,id',
            'dice_supervisor' => 'sometimes|string',
            'dice_empleado' => 'sometimes|string'
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = ActaAdministrativa::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
