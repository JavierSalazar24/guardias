<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use App\Models\BlackList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Guardia;
use App\Models\Usuario;

class GuardiaController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $usuario = auth()->user();

        $guardias = Guardia::with(['sucursal_empresa', 'rango', 'sucursal'])
            ->where('eliminado', false)
            ->filtrarPorSucursalEmpresaUsuario($usuario)
            ->latest()
            ->get();

        return response()->json($guardias->append(['antidoping_url', 'foto_url']));
    }

    // Guardias totales
    public function getGuardiasTotales()
    {
        $usuario = auth()->user();

        $queryBase = Guardia::where('eliminado', false)->filtrarPorSucursalEmpresaUsuario($usuario);

        $guardiasEnTurno = (clone $queryBase)
            ->where('estatus', 'Asignado')
            ->count();

        $guardiasTotales = (clone $queryBase)->count();

        $guardiasData = [
            'guardiasEnTurno' => $guardiasEnTurno,
            'guardiasTotales' => $guardiasTotales,
        ];

        return response()->json($guardiasData);
    }

    //  Revisar si está en blacklist
    public function checkBlackList(Request $request)
    {
        $nombre     = $request->nombre;
        $apellido_p = $request->apellido_p;
        $apellido_m = $request->apellido_m;

        // Buscar coincidencias en la lista negra
        $coincidencias = BlackList::whereHas('guardia', function ($query) use ($nombre, $apellido_p, $apellido_m) {
            $query->where('nombre', $nombre)
                ->where('apellido_p', $apellido_p)
                ->where('apellido_m', $apellido_m);
        })->with('guardia')->get();

        if ($coincidencias->count() > 0) {
            $nombres = $coincidencias->map(function ($item) {
                return $item->guardia->nombre . ' ' . $item->guardia->apellido_p . ' ' . $item->guardia->apellido_m . ' - Motivo: ' . ($item->motivo_baja ?? 'No especificado');
            });

            return response()->json(['message' => 'Revisa la lista negra, se encontraron coincidencias en el nombre.'], 422);
        }else{
            return response()->json(['message' => 'No se encontró ninguna coincidencia en la lista negra.'], 200);
        }
    }

    // consulta de la app
    public function getGuardiaApp(Request $request)
    {
        $guardias = Guardia::where('numero_empleado', $request->numero_empleado)->where('eliminado', false)->get();

        return response()->json($guardias);
    }

    //  * Mostrar todos los registros.
    public function guardiaAsignado()
    {
        $usuario = auth()->user();

        $guardias = Guardia::where('estatus', 'Asignado')
            ->where('eliminado', false)
            ->filtrarPorSucursalEmpresaUsuario($usuario)
            ->get();

        return response()->json($guardias->append(['antidoping_url', 'foto_url']));
    }

    // guardias por sucursal
    public function getGuardiaBySucursal(Request $request)
    {
        $usuario = auth()->user();

        $registro = Guardia::with(['sucursal_empresa', 'rango', 'sucursal'])
            ->where('sucursal_empresa_id', $request->id)
            ->where('estatus', 'Disponible')
            ->where('eliminado', false)
            ->filtrarPorSucursalEmpresaUsuario($usuario)
            ->get();

        if ($registro->isEmpty()) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nombre' => 'required|string|max:100',
            'apellido_p' => 'required|string|max:100',
            'apellido_m' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|unique:guardias,correo',
            'enfermedades' => 'required|string|max:100',
            'alergias' => 'required|string|max:100',
            'curp' => 'required|string',
            'clave_elector' => 'required|string',
            'calle' => 'required|string|max:100',
            'numero' => 'required|string|max:20',
            'entre_calles' => 'required|string',
            'colonia' => 'required|string|max:50',
            'cp' => 'required|string',
            'estado' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
            'contacto_emergencia' => 'required|string|max:100',
            'telefono_emergencia' => 'required|string|max:15',
            'sucursal_empresa_id' => 'required|exists:sucursales_empresa,id',
            'numero_empleado' => 'required|string|unique:guardias,numero_empleado',
            'cargo' => 'required|string',
            'cuip' => 'nullable|string',
            'numero_cuenta' => 'required|string',
            'clabe' => 'required|string',
            'banco' => 'required|string',
            'nombre_propietario' => 'required|string',
            'comentarios_generales' => 'nullable|string',
            'sueldo_base' => 'required|numeric',
            'dias_laborales' => 'required|numeric',
            'aguinaldo' => 'required|numeric',
            'imss' => 'required|numeric',
            'infonavit' => 'required|numeric',
            'fonacot' => 'required|numeric',
            'retencion_isr' => 'required|numeric',
            'fecha_alta' => 'required|date',
            'rango_id' => 'required|exists:rangos,id',
            'fecha_baja' => 'nullable|date',
            'motivo_baja' => 'nullable|string',
            'sucursal_id' => 'nullable|exists:sucursales,id',

            'fecha_antidoping' => 'nullable|date',
            'antidoping' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->subirFoto($request->file('foto'));
        }
        if ($request->hasFile('antidoping')) {
            $data['antidoping'] = $this->subirDocumento($request->file('antidoping'));
        }

        $registro = Guardia::create($data);

        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $usuario = auth()->user();

        $registro = Guardia::with(['sucursal_empresa', 'rango', 'sucursal'])
            ->where('eliminado', false)
            ->filtrarPorSucursalEmpresaUsuario($usuario)
            ->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro->append(['antidoping_url', 'foto_url']));
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $usuario = auth()->user();

        $registro = Guardia::filtrarPorSucursalEmpresaUsuario($usuario)->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'foto' => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nombre' => 'sometimes|string|max:100',
            'apellido_p' => 'sometimes|string|max:100',
            'apellido_m' => 'sometimes|string|max:100',
            'fecha_nacimiento' => 'sometimes|date',
            'telefono' => 'sometimes|string|max:15',
            'correo' => 'sometimes|email|unique:guardias,correo,' . $id,
            'enfermedades' => 'sometimes|string|max:100',
            'alergias' => 'sometimes|string|max:100',
            'curp' => 'sometimes|string',
            'clave_elector' => 'sometimes|string',
            'calle' => 'sometimes|string|max:100',
            'numero' => 'sometimes|string|max:20',
            'entre_calles' => 'sometimes|string',
            'colonia' => 'sometimes|string|max:50',
            'cp' => 'sometimes|string',
            'estado' => 'sometimes|string|max:100',
            'municipio' => 'sometimes|string|max:100',
            'pais' => 'sometimes|string|max:100',
            'contacto_emergencia' => 'sometimes|string|max:100',
            'telefono_emergencia' => 'sometimes|string|max:15',
            'sucursal_empresa_id' => 'sometimes|exists:sucursales_empresa,id',
            'numero_empleado' => 'sometimes|string|unique:guardias,numero_empleado,' . $id,
            'cargo' => 'sometimes|string',
            'cuip' => 'nullable|string',
            'numero_cuenta' => 'sometimes|string',
            'clabe' => 'sometimes|string',
            'banco' => 'sometimes|string',
            'nombre_propietario' => 'sometimes|string',
            'comentarios_generales' => 'nullable|string',
            'sueldo_base' => 'sometimes|numeric',
            'dias_laborales' => 'sometimes|numeric',
            'aguinaldo' => 'sometimes|numeric',
            'imss' => 'sometimes|numeric',
            'infonavit' => 'sometimes|numeric',
            'fonacot' => 'sometimes|numeric',
            'retencion_isr' => 'sometimes|numeric',
            'fecha_alta' => 'sometimes|date',
            'rango_id' => 'sometimes|exists:rangos,id',
            'fecha_baja' => 'nullable|date',
            'estatus' => 'sometimes|in:Disponible,Descansado,Dado de baja,Asignado',
            'motivo_baja' => 'nullable|string',
            'sucursal_id' => 'nullable|exists:sucursales,id',

            'fecha_antidoping' => 'nullable|date',
            'antidoping' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if($data['estatus'] !== 'Asignado'){
            $data['sucursal_id'] = null;
        }

        if($data['estatus'] !== 'Dado de baja'){
            $data['fecha_baja'] = null;
            $data['motivo_baja'] = null;
        }

        if ($request->hasFile('foto')) {
            if ($registro->foto) {
                $this->eliminarFoto($registro->foto);
            }
            $data['foto'] = $this->subirFoto($request->file('foto'));
        }
        if ($request->hasFile('antidoping')) {
            if ($registro->antidoping) {
                $this->eliminarDocumento($registro->antidoping);
            }
            $data['antidoping'] = $this->subirDocumento($request->file('antidoping'));
        }

        $registro->update($data);

        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $usuario = auth()->user();

        $registro = Guardia::filtrarPorSucursalEmpresaUsuario($usuario)->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        // Eliminación lógica
        $registro->update(['eliminado' => true]);
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    // * Función para subir una foto
    private function subirFoto($archivo)
    {
        return ArchivosHelper::subirArchivoConPermisos($archivo, 'public/fotos_guardias');
    }

    // * Función para eliminar una foto
    private function eliminarFoto($nombreArchivo)
    {
        ArchivosHelper::eliminarArchivo('public/fotos_guardias', $nombreArchivo);
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
