<?php

namespace App\Http\Controllers;

use App\Models\SucursalEmpresa;
use Illuminate\Http\Request;

class SucursalEmpresaController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = SucursalEmpresa::get();
        return response()->json($registros);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_sucursal' => 'required|string|max:100',
            'calle' => 'required|string|max:100',
            'numero' => 'required|string|max:20',
            'colonia' => 'required|string|max:50',
            'cp' => 'required|string',
            'municipio' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
            'telefono_sucursal' => 'required|string|max:15',
            'extension_sucursal' => 'nullable|string|max:10',

            'nombre_contacto' => 'required|string|max:100',
            'telefono_contacto' => 'required|string|max:15',
            'correo_contacto' => 'required|email',
            'representante_legal' => 'required|string|max:100',
        ]);

        $registro = SucursalEmpresa::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = SucursalEmpresa::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = SucursalEmpresa::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'nombre_sucursal' => 'sometimes|string|max:100',
            'calle' => 'sometimes|string|max:100',
            'numero' => 'sometimes|string|max:20',
            'colonia' => 'sometimes|string|max:50',
            'cp' => 'sometimes|string',
            'municipio' => 'sometimes|string|max:100',
            'estado' => 'sometimes|string|max:100',
            'pais' => 'sometimes|string|max:100',
            'telefono_sucursal' => 'sometimes|string|max:15',
            'extension_sucursal' => 'nullable|string|max:10',

            'nombre_contacto' => 'sometimes|string|max:100',
            'telefono_contacto' => 'sometimes|string|max:15',
            'correo_contacto' => 'sometimes|email',
            'representante_legal' => 'sometimes|string|max:100',
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = SucursalEmpresa::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
