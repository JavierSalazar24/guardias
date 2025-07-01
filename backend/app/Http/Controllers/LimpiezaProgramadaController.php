<?php

namespace App\Http\Controllers;

use App\Models\LimpiezaProgramada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LimpiezaProgramadaController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = LimpiezaProgramada::with('usuario')->get();
        return response()->json($registros);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'tabla' => 'required|in:guardias,equipamiento,incapacidades,tiempo_extra,faltas,descuentos,vacaciones,prestamos,pagos_empleados,check_guardia,reporte_bitacoras,reportes_incidentes_guardia,reportes_guardia,reportes_supervisor,reportes_patrulla,qr_recorridos_guardia,cotizaciones,ventas,ordenes_servicios,boletas_gasolina,ordenes_compra,gastos',
            'periodo_cantidad' => 'required|integer|min:0',
            'periodo_tipo' => 'required|in:dias,semanas,meses,anios',
        ]);
        $data['usuario_id'] = Auth::id();

        $registro = LimpiezaProgramada::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = LimpiezaProgramada::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = LimpiezaProgramada::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'periodo_cantidad' => 'sometimes|integer|min:0',
            'periodo_tipo' => 'sometimes|in:dias,semanas,meses,anios',
            'activa' => 'sometimes|boolean'
        ]);

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = LimpiezaProgramada::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
