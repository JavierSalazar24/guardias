<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    //  * Mostrar todos los usuarios con sus roles.
    public function index()
    {
        $usuarios = Usuario::with(['rol', 'sucursal_empresa'])->get();
        return response()->json($usuarios);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'rol_id' => 'required|exists:roles,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sucursal_empresa_id' => 'nullable|exists:sucursales_empresa,id',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->subirFoto($request->file('foto'));
        }

        $registro = Usuario::create($data);

        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $usuario = Usuario::with(['rol', 'sucursal_empresa'])->find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $request->validate([
            'nombre_completo' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:usuarios,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'rol_id' => 'sometimes|exists:roles,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sucursal_empresa_id' => 'nullable|exists:sucursales_empresa,id',
            'seleccionar_sucursal' => 'nullable',
        ]);

        $data = $request->only('nombre_completo', 'email', 'rol_id', 'foto', 'sucursal_empresa_id');
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        if ($request->hasFile('foto')) {
            if ($usuario->foto) {
                $this->eliminarFoto($usuario->foto);
            }
            $data['foto'] = $this->subirFoto($request->file('foto'));
        }

        if($request->seleccionar_sucursal === "false") {
            $data['sucursal_empresa_id'] = null;
        }

        $usuario->update($data);

        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        if ($usuario->foto) {
            $this->eliminarFoto($usuario->foto);
        }

        $usuario->delete();

        // Si la carpeta está vacía, la eliminamos para evitar directorios innecesarios
        $carpeta = 'public/fotos_usuarios/';
        if (empty(Storage::files($carpeta))) {
            Storage::deleteDirectory($carpeta);
        }

        return response()->json(['message' => 'Registro eliminado']);
    }

    // * Función para subir una foto
    private function subirFoto($archivo)
    {
        return ArchivosHelper::subirArchivoConPermisos($archivo, 'public/fotos_usuarios');
    }

    // * Función para eliminar una foto
    private function eliminarFoto($nombreArchivo)
    {
        ArchivosHelper::eliminarArchivo('public/fotos_usuarios', $nombreArchivo);
    }

}
