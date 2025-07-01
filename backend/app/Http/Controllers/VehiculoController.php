<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use App\Models\Vehiculo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class VehiculoController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Vehiculo::get();
        return response()->json($registros->append(['fotos_vehiculo_url', 'archivo_seguro_url']));
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_vehiculo' => 'required|in:Carro,Motocicleta',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:15',
            'color' => 'required|string|max:15',
            'placas' => 'required|string|max:20|unique:vehiculos,placas',

            'fotos_vehiculo' => 'required|array',
            'fotos_vehiculo.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'rotulado' => 'required|in:SI,NO',
            'gps' => 'required|in:SI,NO',
            'torreta' => 'required|in:SI,NO',
            'impuestos_pagados' => 'required|in:SI,NO',

            'aseguradora' => 'required|string|max:50',
            'telefono_aseguradora' => 'required|string|max:15',
            'archivo_seguro' => 'required|file|mimes:pdf|max:2048',
            'numero_poliza' => 'required|string',
            'fecha_vencimiento' => 'required|date',
        ]);

        if ($request->hasFile('fotos_vehiculo')) {
            $nombreZip = $this->crearZip($request->file('fotos_vehiculo'));
            $data['fotos_vehiculo'] = $nombreZip;
        }

        if ($request->hasFile('archivo_seguro')) {
            $data['archivo_seguro'] = $this->subirDocumento($request->file('archivo_seguro'));
        }

        $registro = Vehiculo::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Vehiculo::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Mostrar un solo registro por su ID.
    public function getVehiculosDisponibles()
    {
        $registros = Vehiculo::where('estado', 'Disponible')->get();
        return response()->json($registros);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Vehiculo::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'tipo_vehiculo' => 'sometimes|in:Carro,Motocicleta',
            'marca' => 'sometimes|string|max:50',
            'modelo' => 'sometimes|string|max:15',
            'color' => 'sometimes|string|max:15',
            'placas' => 'sometimes|string|max:20|unique:vehiculos,placas,' . $id,
            'estado' => 'sometimes|in:Disponible,Asignado,En reparación,Fuera de servicio,Accidente,Robado,Vendido',

            'fotos_vehiculo' => 'sometimes|array',
            'fotos_vehiculo.*' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'rotulado' => 'sometimes|in:SI,NO',
            'gps' => 'sometimes|in:SI,NO',
            'torreta' => 'sometimes|in:SI,NO',
            'impuestos_pagados' => 'sometimes|in:SI,NO',

            'aseguradora' => 'sometimes|string|max:50',
            'telefono_aseguradora' => 'sometimes|string|max:15',
            'archivo_seguro' => 'sometimes|file|mimes:pdf|max:2048',
            'numero_poliza' => 'sometimes|string',
            'fecha_vencimiento' => 'sometimes|date',
        ]);

        if ($request->hasFile('fotos_vehiculo')) {
            if ($registro->fotos_vehiculo) {
                $this->eliminarZip($registro->fotos_vehiculo);
            }

            $nuevoZip = $this->crearZip($request->file('fotos_vehiculo'));
            $data['fotos_vehiculo'] = $nuevoZip;
        }

        if ($request->hasFile('archivo_seguro')) {
            if ($registro->archivo_seguro) {
                $this->eliminarDocumento($registro->archivo_seguro);
            }

            $data['archivo_seguro'] = $this->subirDocumento($request->file('archivo_seguro'));
        }

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Vehiculo::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        if ($registro->archivo_seguro) {
            $this->eliminarDocumento($registro->archivo_seguro);
        }

        $registro->delete();

        $carpeta = 'public/seguros_vehiculos/';
        if (empty(Storage::files($carpeta))) {
            Storage::deleteDirectory($carpeta);
        }

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    // crear ZIP de fotos
    private function crearZip($archivos)
    {
        Storage::makeDirectory("public/fotos_vehiculos");

        $nombreZip = time() . '_' . uniqid() . '.zip';
        $rutaZip = storage_path("app/public/fotos_vehiculos/{$nombreZip}");

        $zip = new ZipArchive;
        if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($archivos as $archivo) {
                $nombreArchivo = time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
                $zip->addFromString($nombreArchivo, file_get_contents($archivo->getRealPath()));
            }
            $zip->close();
        }

        return $nombreZip;
    }

    public function descargarZip(Vehiculo $vehiculo): StreamedResponse
    {
        if (!$vehiculo->fotos_vehiculo) {
            abort(404, 'El vehículo no tiene fotos asociadas');
        }

        $ruta = "fotos_vehiculos/{$vehiculo->fotos_vehiculo}";

        if (!Storage::disk('public')->exists($ruta)) {
            abort(404, 'Archivo no encontrado en el servidor');
        }

        // Opcional: comprueba permisos aquí (roles, guards, etc.)

        return Storage::disk('public')->download($ruta);
    }

    // eliminar ZIP de fotos
    private function eliminarZip($nombreArchivo)
    {
        if($nombreArchivo === 'default.zip'){
            return;
        }

        $ruta = storage_path("app/public/fotos_vehiculos/{$nombreArchivo}");
        if (file_exists($ruta)) {
            unlink($ruta);
        }
    }

    // * Función para subir un documento
    private function subirDocumento($archivo)
    {
        return ArchivosHelper::subirArchivoConPermisos($archivo, 'public/seguros_vehiculos');
    }

    // * Función para eliminar un documento
    private function eliminarDocumento($nombreArchivo)
    {
        if($nombreArchivo === 'default.pdf'){
            return;
        }
        ArchivosHelper::eliminarArchivo('public/seguros_vehiculos', $nombreArchivo);
    }
}
