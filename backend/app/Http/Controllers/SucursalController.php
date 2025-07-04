<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Sucursal::with('cliente')->get();
        return response()->json($registros->append('situacion_fiscal_url'));
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_empresa' => 'required|string|max:100',
            'calle' => 'required|string|max:100',
            'numero' => 'required|string|max:20',
            'colonia' => 'required|string|max:50',
            'cp' => 'required|digits:5',
            'municipio' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
            'telefono_empresa' => 'required|string|max:15',
            'extension_empresa' => 'nullable|string|max:10',
            'nombre_contacto' => 'required|string|max:100',
            'telefono_contacto' => 'required|string|max:15',
            'correo_contacto' => 'required|email|unique:sucursales,correo_contacto',
            'cliente_id' => 'required|exists:clientes,id',

            'rfc' => 'required|string|max:13',
            'razon_social' => 'required|string',
            'uso_cfdi' => 'required|string',
            'regimen_fiscal' => 'required|string',
            'situacion_fiscal' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('situacion_fiscal')) {
            $data['situacion_fiscal'] = $this->subirDocumento($request->file('situacion_fiscal'));
        }

        $registro = Sucursal::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Sucursal::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Sucursal::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'nombre_empresa' => 'sometimes|string|max:100',
            'calle' => 'sometimes|string|max:100',
            'numero' => 'sometimes|string|max:20',
            'colonia' => 'sometimes|string|max:50',
            'cp' => 'sometimes|digits:5',
            'municipio' => 'sometimes|string|max:100',
            'estado' => 'sometimes|string|max:100',
            'pais' => 'sometimes|string|max:100',
            'telefono_empresa' => 'sometimes|string|max:15',
            'extension_empresa' => 'nullable|string|max:10',
            'nombre_contacto' => 'sometimes|string|max:100',
            'telefono_contacto' => 'sometimes|string|max:15',
            'correo_contacto' => 'sometimes|email',
            'cliente_id' => 'sometimes|exists:clientes,id',

            'rfc' => 'sometimes|string|max:13',
            'razon_social' => 'sometimes|string',
            'uso_cfdi' => 'sometimes|string',
            'regimen_fiscal' => 'sometimes|string',
            'situacion_fiscal' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('situacion_fiscal')) {
            if ($registro->situacion_fiscal) {
                $this->eliminarDocumento($registro->situacion_fiscal);
            }
            $data['situacion_fiscal'] = $this->subirDocumento($request->file('situacion_fiscal'));
        }

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Sucursal::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        if ($registro->situacion_fiscal) {
            $this->eliminarDocumento($registro->situacion_fiscal);
        }

        $registro->delete();

        $carpeta = 'public/documentos_sucursales/';
        if (empty(Storage::files($carpeta))) {
            Storage::deleteDirectory($carpeta);
        }

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function sucursalesCliente(Request $request)
    {
        $clienteId = $request->query('cliente_id'); // también puedes usar $request->input() si lo mandas por body

        if (!$clienteId) {
            return response()->json(['error' => 'Debe proporcionar un cliente_id'], 400);
        }

        $sucursales = Sucursal::where('cliente_id', $clienteId)
            ->with('cliente') // si quieres incluir info del cliente
            ->get();

        return response()->json($sucursales);
    }

    // * Función para subir un documento
    private function subirDocumento($archivo)
    {
        return ArchivosHelper::subirArchivoConPermisos($archivo, 'public/documentos_sucursales');
    }

    // * Función para eliminar un documento
    private function eliminarDocumento($nombreArchivo)
    {
        if($nombreArchivo === 'default.pdf'){
            return;
        }
        ArchivosHelper::eliminarArchivo('public/documentos_sucursales', $nombreArchivo);
    }
}
