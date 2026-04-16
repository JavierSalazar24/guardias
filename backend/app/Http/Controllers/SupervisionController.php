<?php

namespace App\Http\Controllers;

use App\Models\Supervision;
use App\Helpers\ArchivosHelper;
use Illuminate\Http\Request;

class SupervisionController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Supervision::with(['guardia', 'guardia.sucursal_empresa', 'guardia.sucursal', 'usuario'])->get();
        return response()->json($registros->append('evidencia_url'));
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'evidencia' => 'required|image|mimes:jpg,jpeg,png,webp',
            'asistencia' => 'required|in:Asistió,Faltó',
            'falta' => 'nullable|string',
            'uniforme' => 'required|in:Completo,Incompleto',
            'uniforme_incompleto' => 'nullable|string',
            'equipamiento' => 'required|in:Completo,Incompleto',
            'equipamiento_incompleto' => 'nullable|string',
            'lugar_trabajo' => 'required|in:Activo,Ausente',
            'motivo_ausente' => 'nullable|string',
            'comentarios_adicionales' => 'nullable|string',
            'guardia_id' => 'required|exists:guardias,id',
        ]);

        if ($request->hasFile('evidencia')) {
            $data['evidencia'] = $this->subirFoto($request->file('evidencia'));
        }

        $data['usuario_id'] = auth()->id();

        $registro = Supervision::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Supervision::with(['guardia', 'guardia.sucursal_empresa', 'guardia.sucursal', 'usuario'])->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro->append('evidencia_url'));
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Supervision::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'evidencia' => 'sometimes|image|mimes:jpg,jpeg,png,webp',
            'asistencia' => 'sometimes|in:Asistió,Faltó',
            'falta' => 'nullable|string',
            'uniforme' => 'sometimes|in:Completo,Incompleto',
            'uniforme_incompleto' => 'nullable|string',
            'equipamiento' => 'sometimes|in:Completo,Incompleto',
            'equipamiento_incompleto' => 'nullable|string',
            'lugar_trabajo' => 'sometimes|in:Activo,Ausente',
            'motivo_ausente' => 'nullable|string',
            'comentarios_adicionales' => 'nullable|string',
            'guardia_id' => 'sometimes|exists:guardias,id',
        ]);

        if ($request->hasFile('evidencia')) {
            if ($registro->evidencia) {
                $this->eliminarFoto($registro->evidencia);
            }
            $data['evidencia'] = $this->subirFoto($request->file('evidencia'));
        }

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Supervision::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        if ($registro->evidencia) {
            $this->eliminarFoto($registro->evidencia);
        }

        $registro->delete();
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    // * Función para subir una foto
    private function subirFoto($archivo)
    {
        return ArchivosHelper::subirArchivoConPermisos($archivo, 'public/evidencia_supervisores');
    }

    // * Función para eliminar una foto
    private function eliminarFoto($nombreArchivo)
    {
        ArchivosHelper::eliminarArchivo('public/evidencia_supervisores', $nombreArchivo);
    }
}
