<?php

namespace App\Http\Controllers;

use App\Models\Incapacidad;
use Illuminate\Http\Request;

class IncapacidadController extends Controller
{
    public function index()
    {
        return Incapacidad::with('guardia')->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'pago_empresa' => 'nullable|numeric',
            'motivo' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        return Incapacidad::create($data);
    }

    public function show($id)
    {
        return Incapacidad::with('guardia')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $incapacidad = Incapacidad::find($id);
        if (!$incapacidad) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date|after_or_equal:fecha_inicio',
            'pago_empresa' => 'nullable|numeric',
            'motivo' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $incapacidad->update($data);

        return $incapacidad;
    }

    public function destroy($id)
    {
        $registro = Incapacidad::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
