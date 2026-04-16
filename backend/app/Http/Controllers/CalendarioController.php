<?php

namespace App\Http\Controllers;

use App\Models\Calendario;
use Illuminate\Http\Request;
use DB;

class CalendarioController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = DB::table('calendario')
            ->join('usuarios as invitados', 'calendario.invitado_id', '=', 'invitados.id')
            ->join('usuarios as creadores', 'calendario.creador_id', '=', 'creadores.id')
            ->select(
                'calendario.*',
                'invitados.nombre_completo as nombre_invitado',
                'creadores.nombre_completo as nombre_creador'
            )
            ->where(function ($query) {
                $query->where('calendario.invitado_id', auth()->id())
                      ->orWhere('calendario.creador_id', auth()->id());
            })
            ->get();
        return response()->json($registros);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'invitado_id' => 'required|exists:usuarios,id',
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required|date',
            'notas' => 'nullable|string',
        ]);

        $data['creador_id'] = auth()->id();

        $registro = Calendario::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = DB::table('calendario')
            ->join('usuarios as invitados', 'calendario.invitado_id', '=', 'invitados.id')
            ->join('usuarios as creadores', 'calendario.creador_id', '=', 'creadores.id')
            ->select(
                'calendario.*',
                'invitados.nombre_completo as nombre_invitado',
                'creadores.nombre_completo as nombre_creador'
            )
            ->where('calendario.id', $id)
            ->where(function ($query) {
                $query->where('calendario.invitado_id', auth()->id())
                      ->orWhere('calendario.creador_id', auth()->id());
            })
            ->first();

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Calendario::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'invitado_id' => 'sometimes|exists:usuarios,id',
            'titulo' => 'sometimes|string',
            'descripcion' => 'sometimes|string',
            'fecha_hora' => 'sometimes|date',
            'notas' => 'nullable|string',
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Calendario::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
