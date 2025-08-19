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
        $guardias = Guardia::with('sucursal_empresa')->where('eliminado', false)->latest()->get();

        return response()->json($guardias->append(['curp_url', 'ine_url', 'acta_nacimiento_url', 'comprobante_domicilio_url', 'constancia_situacion_fiscal_url', 'comprobante_estudios_url', 'carta_recomendacion_url', 'antecedentes_no_penales_url', 'antidoping_url', 'foto_url']));
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

            return response()->json(['message' => 'Revisa la listra negra, se encontraron coincidencias en el nombre.'], 422);
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
        $guardias = Guardia::where('estatus', 'Asignado')->where('eliminado', false)->get();

        return response()->json($guardias->append(['curp_url', 'ine_url', 'acta_nacimiento_url', 'comprobante_domicilio_url', 'constancia_situacion_fiscal_url', 'comprobante_estudios_url', 'carta_recomendacion_url', 'antecedentes_no_penales_url', 'antidoping_url', 'foto_url']));
    }

    // guardias por sucursal
    public function getGuardiaBySucursal(Request $request)
    {
        $registro = Guardia::with('sucursal_empresa')
            ->where('sucursal_empresa_id', $request->id)
            ->where('estatus', 'Disponible')
            ->where('rango', 'Guardia')
            ->where('eliminado', false)->get();

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    public function getSupervisorBySucursal(Request $request)
    {
        $registro = Guardia::with('sucursal_empresa')
            ->where('sucursal_empresa_id', $request->id)
            ->where('rango', 'Supervisor')
            ->where('eliminado', false)->get();

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    public function getJefeBySucursal(Request $request)
    {
        $registro = Guardia::with('sucursal_empresa')
            ->where('sucursal_empresa_id', $request->id)
            ->where('rango', 'Jefe de turno')
            ->where('eliminado', false)->get();

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    // Obtener supervisores
    public function getSupervisores()
    {
        $supervisores = Guardia::where('rango', 'Supervisor')->where('eliminado', false)->get();

        return response()->json($supervisores);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_p' => 'required|string|max:100',
            'apellido_m' => 'required|string|max:100',
            'correo' => 'required|email|unique:guardias,correo',
            'calle' => 'required|string|max:100',
            'numero' => 'required|string|max:20',
            'colonia' => 'required|string|max:50',
            'cp' => 'required|numeric|min:1',
            'municipio' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
            'telefono' => 'required|string|max:15',
            'enfermedades' => 'required|string|max:100',
            'alergias' => 'required|string|max:100',
            'edad' => 'required|numeric|min:1|max:100',
            'telefono_emergencia' => 'required|string|max:15',
            'contacto_emergencia' => 'required|string|max:100',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'curp' => 'required|file|mimes:pdf|max:2048',
            'ine' => 'required|file|mimes:pdf|max:2048',
            'acta_nacimiento' => 'required|file|mimes:pdf|max:2048',
            'comprobante_domicilio' => 'required|file|mimes:pdf|max:2048',
            'constancia_situacion_fiscal' => 'required|file|mimes:pdf|max:2048',

            'comprobante_estudios' => 'nullable|file|mimes:pdf|max:2048',
            'carta_recomendacion' => 'nullable|file|mimes:pdf|max:2048',
            'antecedentes_no_penales' => 'nullable|file|mimes:pdf|max:2048',

            'fecha_antidoping' => 'nullable|date',
            'antidoping' => 'nullable|file|mimes:pdf|max:2048',

            'rango' => 'required|in:Guardia,Supervisor,Jefe de turno',

            'sueldo_base' => 'required|numeric',
            'dias_laborales' => 'required|numeric',
            'aguinaldo' => 'required|numeric',
            'imss' => 'required|numeric',
            'infonavit' => 'required|numeric',
            'fonacot' => 'required|numeric',
            'retencion_isr' => 'required|numeric',

            'sucursal_empresa_id' => 'required|exists:sucursales_empresa,id',
            'numero_empleado' => 'required|string|unique:guardias,numero_empleado',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->subirFoto($request->file('foto'));
        }
        if ($request->hasFile('curp')) {
            $data['curp'] = $this->subirDocumento($request->file('curp'));
        }
        if ($request->hasFile('ine')) {
            $data['ine'] = $this->subirDocumento($request->file('ine'));
        }
        if ($request->hasFile('acta_nacimiento')) {
            $data['acta_nacimiento'] = $this->subirDocumento($request->file('acta_nacimiento'));
        }
        if ($request->hasFile('comprobante_domicilio')) {
            $data['comprobante_domicilio'] = $this->subirDocumento($request->file('comprobante_domicilio'));
        }
        if ($request->hasFile('constancia_situacion_fiscal')) {
            $data['constancia_situacion_fiscal'] = $this->subirDocumento($request->file('constancia_situacion_fiscal'));
        }
        if ($request->hasFile('comprobante_estudios')) {
            $data['comprobante_estudios'] = $this->subirDocumento($request->file('comprobante_estudios'));
        }
        if ($request->hasFile('carta_recomendacion')) {
            $data['carta_recomendacion'] = $this->subirDocumento($request->file('carta_recomendacion'));
        }
        if ($request->hasFile('antecedentes_no_penales')) {
            $data['antecedentes_no_penales'] = $this->subirDocumento($request->file('antecedentes_no_penales'));
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
        $registro = Guardia::with('sucursal_empresa')->where('eliminado', false)->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro->append(['curp_url', 'ine_url', 'acta_nacimiento_url', 'comprobante_domicilio_url', 'constancia_situacion_fiscal_url', 'comprobante_estudios_url', 'carta_recomendacion_url', 'antecedentes_no_penales_url', 'antidoping_url', 'foto_url']));
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Guardia::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'apellido_p' => 'sometimes|string|max:100',
            'apellido_m' => 'sometimes|string|max:100',
            'correo' => 'sometimes|email|unique:guardias,correo,' . $id,
            'calle' => 'sometimes|string|max:100',
            'numero' => 'sometimes|string|max:20',
            'colonia' => 'sometimes|string|max:50',
            'cp' => 'sometimes|numeric|min:1',
            'municipio' => 'sometimes|string|max:100',
            'estado' => 'sometimes|string|max:100',
            'pais' => 'sometimes|string|max:100',
            'telefono' => 'sometimes|string|max:15',
            'enfermedades' => 'sometimes|string|max:100',
            'alergias' => 'sometimes|string|max:100',
            'edad' => 'sometimes|numeric|min:1|max:100',
            'telefono_emergencia' => 'sometimes|string|max:15',
            'contacto_emergencia' => 'sometimes|string|max:100',
            'foto' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'curp' => 'sometimes|file|mimes:pdf|max:2048',
            'ine' => 'sometimes|file|mimes:pdf|max:2048',
            'acta_nacimiento' => 'sometimes|file|mimes:pdf|max:2048',
            'comprobante_domicilio' => 'sometimes|file|mimes:pdf|max:2048',
            'constancia_situacion_fiscal' => 'sometimes|file|mimes:pdf|max:2048',

            'comprobante_estudios' => 'nullable|file|mimes:pdf|max:2048',
            'carta_recomendacion' => 'nullable|file|mimes:pdf|max:2048',
            'antecedentes_no_penales' => 'nullable|file|mimes:pdf|max:2048',

            'fecha_antidoping' => 'nullable|date',
            'antidoping' => 'nullable|file|mimes:pdf|max:2048',

            'estatus' => 'sometimes|in:Disponible,Descansado,Dado de baja,Asignado',
            'rango' => 'sometimes|in:Guardia,Supervisor,Jefe de turno',

            'sueldo_base' => 'sometimes|numeric',
            'dias_laborales' => 'sometimes|numeric',
            'aguinaldo' => 'sometimes|numeric',
            'imss' => 'sometimes|numeric',
            'infonavit' => 'sometimes|numeric',
            'fonacot' => 'sometimes|numeric',
            'retencion_isr' => 'sometimes|numeric',

            'sucursal_empresa_id' => 'sometimes|exists:sucursales_empresa,id',
            'nunmero_empleado' => 'sometimes|email|unique:guardias,nunmero_empleado,' . $id,
        ]);

        if ($request->hasFile('foto')) {
            if ($registro->foto) {
                $this->eliminarFoto($registro->foto);
            }
            $data['foto'] = $this->subirFoto($request->file('foto'));
        }
        if ($request->hasFile('curp')) {
            if ($registro->curp) {
                $this->eliminarDocumento($registro->curp);
            }
            $data['curp'] = $this->subirDocumento($request->file('curp'));
        }
        if ($request->hasFile('ine')) {
            if ($registro->ine) {
                $this->eliminarDocumento($registro->ine);
            }
            $data['ine'] = $this->subirDocumento($request->file('ine'));
        }
        if ($request->hasFile('acta_nacimiento')) {
            if ($registro->acta_nacimiento) {
                $this->eliminarDocumento($registro->acta_nacimiento);
            }
            $data['acta_nacimiento'] = $this->subirDocumento($request->file('acta_nacimiento'));
        }
        if ($request->hasFile('comprobante_domicilio')) {
            if ($registro->comprobante_domicilio) {
                $this->eliminarDocumento($registro->comprobante_domicilio);
            }
            $data['comprobante_domicilio'] = $this->subirDocumento($request->file('comprobante_domicilio'));
        }
        if ($request->hasFile('constancia_situacion_fiscal')) {
            if ($registro->constancia_situacion_fiscal) {
                $this->eliminarDocumento($registro->constancia_situacion_fiscal);
            }
            $data['constancia_situacion_fiscal'] = $this->subirDocumento($request->file('constancia_situacion_fiscal'));
        }
        if ($request->hasFile('comprobante_estudios')) {
            if ($registro->comprobante_estudios) {
                $this->eliminarDocumento($registro->comprobante_estudios);
            }
            $data['comprobante_estudios'] = $this->subirDocumento($request->file('comprobante_estudios'));
        }
        if ($request->hasFile('carta_recomendacion')) {
            if ($registro->carta_recomendacion) {
                $this->eliminarDocumento($registro->carta_recomendacion);
            }
            $data['carta_recomendacion'] = $this->subirDocumento($request->file('carta_recomendacion'));
        }
        if ($request->hasFile('antecedentes_no_penales')) {
            if ($registro->antecedentes_no_penales) {
                $this->eliminarDocumento($registro->antecedentes_no_penales);
            }
            $data['antecedentes_no_penales'] = $this->subirDocumento($request->file('antecedentes_no_penales'));
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
        $registro = Guardia::find($id);

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