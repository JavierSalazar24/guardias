<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Cliente::get();
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
            'pagina_web' => 'nullable|url|max:100',

            'nombre_contacto_admin' => 'required|string|max:100',
            'telefono_contacto_admin' => 'required|string|max:15',
            'whatsapp_contacto_admin' => 'required|string|max:15',
            'correo_contacto_admin' => 'required|email',

            'nombre_contacto_opera' => 'required|string|max:100',
            'telefono_contacto_opera' => 'required|string|max:15',
            'whatsapp_contacto_opera' => 'required|string|max:15',
            'correo_contacto_opera' => 'required|email',

            'credito_dias' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques',
            'plataforma_facturas' => 'nullable|url',
            'orden_compra' => 'required|in:SI,NO',

            'rfc' => 'required|string|max:13',
            'razon_social' => 'required|string',
            'uso_cfdi' => 'required|string',
            'regimen_fiscal' => 'required|string',
            'situacion_fiscal' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('situacion_fiscal')) {
            $data['situacion_fiscal'] = $this->subirDocumento($request->file('situacion_fiscal'));
        }

        $registro = Cliente::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Cliente::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Cliente::find($id);

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
            'pagina_web' => 'nullable|url|max:100',

            'nombre_contacto_admin' => 'sometimes|string|max:100',
            'telefono_contacto_admin' => 'sometimes|string|max:15',
            'whatsapp_contacto_admin' => 'sometimes|string|max:15',
            'correo_contacto_admin' => 'sometimes|email',

            'nombre_contacto_opera' => 'sometimes|string|max:100',
            'telefono_contacto_opera' => 'sometimes|string|max:15',
            'whatsapp_contacto_opera' => 'sometimes|string|max:15',
            'correo_contacto_opera' => 'sometimes|email',

            'credito_dias' => 'sometimes|numeric|min:0',
            'metodo_pago' => 'sometimes|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques',
            'plataforma_facturas' => 'nullable|url',
            'orden_compra' => 'sometimes|in:SI,NO',

            'rfc' => 'sometimes|string|max:13',
            'razon_social' => 'sometimes|string',
            'uso_cfdi' => 'sometimes|string',
            'regimen_fiscal' => 'sometimes|string',
            'situacion_fiscal' => 'sometimes|file|mimes:pdf|max:2048',
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
        $registro = Cliente::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
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
