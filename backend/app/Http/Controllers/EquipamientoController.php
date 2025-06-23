<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use App\Models\Almacen;
use App\Models\AlmacenEntrada;
use App\Models\AlmacenSalida;
use App\Models\Vehiculo;
use App\Models\DetalleEquipamiento;
use App\Models\Equipamiento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class EquipamientoController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Equipamiento::with(['guardia', 'vehiculo', 'detalles.articulo'])->where('eliminado', false)->get();
        return response()->json($registros->append('firma_guardia_url'));
    }

    //  * Mostrar todos los registros.
    public function equipamientoCompleto()
    {
        $registros = Equipamiento::with(['guardia', 'vehiculo', 'detalles.articulo'])->get();
        return response()->json($registros->append('firma_guardia_url'));
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'fecha_entrega' => 'required|date',
            'firma_guardia' => 'required|image|mimes:jpg,jpeg,png|max:2048',

            'fornitura' => 'sometimes|boolean',
            'celular' => 'sometimes|boolean',
            'radio' => 'sometimes|boolean',
            'garret' => 'sometimes|boolean',
            'impermeable' => 'sometimes|boolean',
            'botas' => 'sometimes|boolean',
            'plumas' => 'sometimes|boolean',
            'caparas' => 'sometimes|boolean',
            'equipo_cpat' => 'sometimes|boolean',
            'otro' => 'nullable|string',

            // Validación para los seleccionados
            'seleccionados' => 'required|array',
            'seleccionados.*.numero_serie' => 'required|string',
            'seleccionados.*.id' => 'required|integer|exists:articulos,id'
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('firma_guardia')) {
                $data['firma_guardia'] = $this->subirFoto($request->file('firma_guardia'));
            }

            // Guardar equipamiento
            $registro = Equipamiento::create($data);

            // Actualizar estatus del vehiculo
            $vehiculo = Vehiculo::find($registro->vehiculo_id)->update(['estado' => 'Asignado']);

            foreach ($request->seleccionados as $seleccionado) {
                // Guardar los detalles de los artículos entregados
                DetalleEquipamiento::create([
                    'equipamiento_id' => $registro->id,
                    'articulo_id' => $seleccionado['id'],
                    'numero_serie' => $seleccionado['numero_serie'],
                ]);

                // Guardar salida de almacén
                AlmacenSalida::create([
                    'guardia_id'        => $registro->guardia_id,
                    'articulo_id'       => $seleccionado['id'],
                    'numero_serie'      => $seleccionado['numero_serie'],
                    'fecha_salida'      => $registro->fecha_entrega,
                    'motivo_salida'     => "Asignado",
                ]);

                // Actualizar almacén
                Almacen::where('articulo_id', $seleccionado['id'])
                    ->where('numero_serie', $seleccionado['numero_serie'])
                    ->update([
                        'fecha_salida' => $registro->fecha_entrega,
                        'estado'       => 'Asignado',
                    ]);
            }

            DB::commit();

            return response()->json(['message' => 'Registros guardados correctamente'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar la entrega', 'error' => $e->getMessage()], 500);
        }
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Equipamiento::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Equipamiento::with(['guardia', 'vehiculo', 'detalles.articulo'])->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'guardia_id' => 'sometimes|exists:guardias,id',
            'vehiculo_id' => 'sometimes|exists:vehiculos,id',
            'fecha_entrega' => 'sometimes|date',
            'fecha_devuelto' => 'required_if:devuelto,SI|date|nullable',
            'devuelto' => 'required|in:SI,NO',
            'firma_guardia' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',

            'fornitura' => 'sometimes|boolean',
            'celular' => 'sometimes|boolean',
            'radio' => 'sometimes|boolean',
            'garret' => 'sometimes|boolean',
            'impermeable' => 'sometimes|boolean',
            'botas' => 'sometimes|boolean',
            'plumas' => 'sometimes|boolean',
            'caparas' => 'sometimes|boolean',
            'equipo_cpat' => 'sometimes|boolean',
            'otro' => 'nullable|string',

            // Validación para los seleccionados
            'seleccionados' => 'sometimes|array',
            'seleccionados.*.numero_serie' => 'sometimes|string',
            'seleccionados.*.id' => 'sometimes|integer|exists:articulos,id'
        ]);


        DB::beginTransaction();
        try {

            if ($request->hasFile('firma_guardia')) {
                if ($registro->firma_guardia) {
                    $this->eliminarFoto($registro->firma_guardia);
                }
                $data['firma_guardia'] = $this->subirFoto($request->file('firma_guardia'));
            }

            if ($request->devuelto === 'SI') {
                // Actualizar vehículo a Disponible
                Vehiculo::find($registro->vehiculo_id)->update(['estado' => 'Disponible']);

                // Procesar devolución de todos los artículos
                foreach ($registro->detalles as $detalle) {
                    // Devolver al almacén
                    Almacen::where('articulo_id', $detalle->articulo_id)
                        ->where('numero_serie', $detalle->numero_serie)
                        ->update([
                            'fecha_salida' => null,
                            'estado' => 'Disponible'
                        ]);

                    // Registrar entrada en almacén
                    AlmacenEntrada::create([
                        'guardia_id' => $registro->guardia_id,
                        'articulo_id' => $detalle->articulo_id,
                        'numero_serie' => $detalle->numero_serie,
                        'fecha_entrada' => $data['fecha_devuelto'],
                        'tipo_entrada' => 'Devolución de guardia',
                    ]);
                }

                // 3. Actualizar registro principal
                $registro->update([
                    'fecha_devuelto' => $data['fecha_devuelto'],
                    'devuelto' => 'SI'
                ]);

                DB::commit();

                return response()->json(['message' => 'Devolución registrada correctamente'], 200);
            } else {
                // Actualizar estatus del vehiculo si es que cambió
                if($registro->vehiculo_id != $request->vehiculo_id){
                    Vehiculo::find($registro->vehiculo_id)->update(['estado' => 'Disponible']);
                    Vehiculo::find($request->vehiculo_id)->update(['estado' => 'Asignado']);
                }

                // Artículos anteriores (para devolución)
                $detallesAnteriores = $registro->detalles;
                $nuevosSeleccionados = collect($request->seleccionados);

                foreach ($detallesAnteriores as $detalle) {
                    // Buscar si este artículo sigue en los nuevos seleccionados pero con diferente número de serie
                    $nuevoSeleccionado = $nuevosSeleccionados->firstWhere('id', $detalle->articulo_id);

                    if ($nuevoSeleccionado && $nuevoSeleccionado['numero_serie'] != $detalle->numero_serie) {
                        // Devolver al almacén el número de serie anterior
                        Almacen::where('articulo_id', $detalle->articulo_id)
                            ->where('numero_serie', $detalle->numero_serie)
                            ->update([
                                'fecha_salida' => null,
                                'estado' => 'Disponible'
                            ]);

                        // Eliminar salida de almacén correspondiente al número de serie anterior
                        AlmacenSalida::where('articulo_id', $detalle->articulo_id)
                            ->where('numero_serie', $detalle->numero_serie)
                            ->where('guardia_id', $registro->guardia_id)
                            ->delete();
                    }
                }

                // Procesar artículos que fueron completamente removidos
                foreach ($detallesAnteriores as $detalle) {
                    if (!$nuevosSeleccionados->contains('id', $detalle->articulo_id)) {
                        // Devolver al almacén
                        Almacen::where('articulo_id', $detalle->articulo_id)
                            ->where('numero_serie', $detalle->numero_serie)
                            ->update([
                                'fecha_salida' => null,
                                'estado' => 'Disponible'
                            ]);

                        // Eliminar salida de almacén correspondiente
                        AlmacenSalida::where('articulo_id', $detalle->articulo_id)
                            ->where('numero_serie', $detalle->numero_serie)
                            ->where('guardia_id', $registro->guardia_id)
                            ->delete();
                    }
                }

                // Eliminar todos los detalles anteriores
                $registro->detalles()->delete();

                // Guardar en sus respectivas tablas los nuevos datos
                foreach ($request->seleccionados as $seleccionado) {
                    // Crear nuevo detalle
                    DetalleEquipamiento::create([
                        'equipamiento_id' => $registro->id,
                        'articulo_id' => $seleccionado['id'],
                        'numero_serie' => $seleccionado['numero_serie'],
                    ]);

                    // Eliminar cualquier salida existente para este artículo (por si cambió de número de serie)
                    AlmacenSalida::where('articulo_id', $seleccionado['id'])
                    ->where('guardia_id', $registro->guardia_id)
                    ->delete();

                    // Crear nueva salida de almacén
                    AlmacenSalida::create([
                        'guardia_id' => $registro->guardia_id,
                        'articulo_id' => $seleccionado['id'],
                        'numero_serie' => $seleccionado['numero_serie'],
                        'fecha_salida' => $data['fecha_entrega'] ?? $registro->fecha_entrega,
                        'motivo_salida' => "Asignado",
                    ]);

                    // Actualizar estado en almacén
                    Almacen::where('articulo_id', $seleccionado['id'])
                        ->where('numero_serie', $seleccionado['numero_serie'])
                        ->update([
                            'fecha_salida' => $data['fecha_entrega'] ?? $registro->fecha_entrega,
                            'estado' => 'Asignado'
                        ]);
                }

                // Actualizar equipamiento
                $registro->update($data);

                DB::commit();

                return response()->json(['message' => 'Registros guardados correctamente'], 201);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar la entrega', 'error' => $e->getMessage()], 500);
        }
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Equipamiento::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        DB::beginTransaction();
        try {

            // Actualizar vehículo a Disponible
            Vehiculo::find($registro->vehiculo_id)->update(['estado' => 'Disponible']);

            // Procesar devolución de todos los artículos
            foreach ($registro->detalles as $detalle) {
                // Devolver al almacén
                Almacen::where('articulo_id', $detalle->articulo_id)
                    ->where('numero_serie', $detalle->numero_serie)
                    ->update([
                        'fecha_salida' => null,
                        'estado' => 'Disponible'
                    ]);

                // Registrar entrada en almacén
                AlmacenEntrada::create([
                    'guardia_id' => $registro->guardia_id,
                    'articulo_id' => $detalle->articulo_id,
                    'numero_serie' => $detalle->numero_serie,
                    'fecha_entrada' => Carbon::now()->format('Y-m-d'),
                    'tipo_entrada' => 'Devolución de guardia',
                ]);
            }

            // 3. Actualizar registro principal con eliminado lógico
            $registro->update([
                'fecha_devuelto' => Carbon::now()->format('Y-m-d'),
                'devuelto'       => 'SI',
                'eliminado'      => true
            ]);

            DB::commit();

            return response()->json(['message' => 'Registro eliminado con éxito'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar la entrega', 'error' => $e->getMessage()], 500);
        }
    }

    // * Función para subir una foto
    private function subirFoto($archivo)
    {
        return ArchivosHelper::subirArchivoConPermisos($archivo, 'public/firma_guardia');
    }

    // * Función para eliminar una foto
    private function eliminarFoto($nombreArchivo)
    {
        ArchivosHelper::eliminarArchivo('public/firma_guardia', $nombreArchivo);
    }
}
