<?php

namespace App\Http\Controllers;

use App\Models\Rango;
use Illuminate\Http\Request;
use DB;

class RangoController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Rango::get();
        return response()->json($registros);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $registro = Rango::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Rango::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Rango::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'nombre' => 'sometimes|string|max:50',
            'descripcion' => 'nullable|string',
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Rango::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
