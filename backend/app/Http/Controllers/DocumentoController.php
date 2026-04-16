<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use App\Models\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Documento::with(['guardia', 'tipoDocumento'])
        ->orderBy('guardia_id', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($registros->append('documento_url'));
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_documento_id' => 'required|exists:tipos_documentos,id',
            'guardia_id' => 'required|exists:guardias,id',
            'documento' => 'required|file|mimes:pdf,jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('documento')) {
            $data['documento'] = $this->subirDocumento($request->file('documento'));
        }

        $registro = Documento::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Documento::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Documento::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'tipo_documento_id' => 'sometimes|exists:tipos_documentos,id',
            'guardia_id' => 'sometimes|exists:guardias,id',
            'documento' => 'sometimes|file|mimes:pdf,jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('documento')) {
            if ($registro->documento) {
                $this->eliminarDocumento($registro->documento);
            }
            $data['documento'] = $this->subirDocumento($request->file('documento'));
        }

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado', 'request' => $request->all()], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Documento::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        if ($registro->documento) {
            $this->eliminarDocumento($registro->documento);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    // * Función para subir un documento
    private function subirDocumento($archivo)
    {
        return ArchivosHelper::subirArchivoConPermisos($archivo, 'public/documentos_guardias');
    }

    // * Función para eliminar un documento
    private function eliminarDocumento($nombreArchivo)
    {
        ArchivosHelper::eliminarArchivo('public/documentos_guardias', $nombreArchivo);
    }
}
