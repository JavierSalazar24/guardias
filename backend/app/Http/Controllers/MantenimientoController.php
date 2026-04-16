<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;
use DB;

class MantenimientoController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Mantenimiento::with(['taller', 'vehiculo'])->latest()->get();
        return response()->json($registros);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'taller_id' => 'required|exists:talleres,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'fecha_ingreso' => 'required|date',
            'fecha_salida' => 'nullable|date',
            'motivo_ingreso' => 'required|string',
            'estatus' => 'required|in:Reparado,No reparado,En reparación',
            'notas' => 'required|string',
            'costo_final' => 'required|numeric|min:0',
        ]);

        $registro = Mantenimiento::create($data);

        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Mantenimiento::with(['taller', 'vehiculo'])->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Mantenimiento::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'taller_id' => 'sometimes|exists:talleres,id',
            'vehiculo_id' => 'sometimes|exists:vehiculos,id',
            'fecha_ingreso' => 'sometimes|date',
            'fecha_salida' => 'nullable|date',
            'motivo_ingreso' => 'sometimes|string',
            'estatus' => 'sometimes|in:Reparado,No reparado,En reparación',
            'notas' => 'sometimes|string',
            'costo_final' => 'sometimes|numeric|min:0',
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Mantenimiento::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
