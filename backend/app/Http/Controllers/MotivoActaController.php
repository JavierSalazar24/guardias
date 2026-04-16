<?php

namespace App\Http\Controllers;

use App\Models\MotivoActa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class MotivoActaController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = MotivoActa::get();
        return response()->json($registros);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'motivo' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        $registro = MotivoActa::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = MotivoActa::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = MotivoActa::find($id);

        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'motivo' => 'sometimes|string',
            'descripcion' => 'nullable|string',
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = MotivoActa::find($id);

        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $registro->delete();
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
