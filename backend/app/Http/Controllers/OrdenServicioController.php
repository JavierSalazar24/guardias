<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Guardia;
use App\Models\OrdenServicioGuardia;
use App\Models\OrdenServicio;
use App\Models\Almacen;
use App\Models\AlmacenEntrada;
use App\Models\AlmacenSalida;
use App\Models\Venta;
use App\Models\DetalleEquipamientoOrdenServicio;
use Illuminate\Http\Request;
use DB;

class OrdenServicioController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = OrdenServicio::with(['venta.cotizacion.sucursal', 'ordenesServicioGuardias.guardia.rango', 'detalles.articulo'])->where('eliminado', false)->latest()->get();

        return response()->json($registros);
    }

    //  * Mostrar todos los registros.
    public function ordenServicioEliminadas()
    {
        $registros = OrdenServicio::with(['venta.cotizacion.sucursal','ordenesServicioGuardias.guardia.rango'])->where('eliminado', true)->latest()->get();

        return response()->json($registros);
    }

    public function ordenServicioGuardia(Request $request)
    {
        $request->validate([
            'guardia_id' => 'required|exists:guardias,id'
        ]);

        $guardiaId = $request->guardia_id;

        $orden = OrdenServicio::where('estatus', 'En proceso')
            ->where('eliminado', false)
            ->whereHas('guardias', function ($query) use ($guardiaId) {
                $query->where('guardia_id', $guardiaId);
            })
            ->latest()
            ->first();

        return response()->json($orden);
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'domicilio_servicio' => 'required|string',
            'codigo_orden_servicio' => 'required|string|unique:ordenes_servicios,codigo_orden_servicio',
            'nombre_responsable_sitio' => 'required|string|max:100',
            'telefono_responsable_sitio' => 'required|string|max:15',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'observaciones' => 'nullable|string',

            // Validación para los guardias
            'guardias_id' => 'required|array',
            'guardias_id.*.value' => 'required|integer|exists:guardias,id',

            // Validación para los seleccionados
            'seleccionados' => 'nullable|array',
            'seleccionados.*.numero_serie' => 'nullable|string',
            'seleccionados.*.id' => 'nullable|integer|exists:articulos,id'
        ]);

        DB::beginTransaction();
        try {
            $registro = OrdenServicio::create($data);

            $venta = Venta::find($data['venta_id']);
            $empresaAsignada = $venta->cotizacion->sucursal->id;

            foreach ($request->guardias_id as $guardia) {
                OrdenServicioGuardia::create([
                    'orden_servicio_id' => $registro->id,
                    'guardia_id' => $guardia['value'],
                ]);

                Guardia::find($guardia['value'])->update(['estatus' => 'Asignado', 'sucursal_id' => $empresaAsignada]);
            }

            if($request->seleccionados){
                foreach ($request->seleccionados as $seleccionado) {
                    // Guardar los detalles de los artículos entregados
                    DetalleEquipamientoOrdenServicio::create([
                        'orden_servicio_id' => $registro->id,
                        'articulo_id' => $seleccionado['id'],
                        'numero_serie' => $seleccionado['numero_serie'],
                    ]);

                    // Guardar salida de almacén
                    AlmacenSalida::create([
                        'orden_servicio_id' => $registro->id,
                        'articulo_id'       => $seleccionado['id'],
                        'numero_serie'      => $seleccionado['numero_serie'],
                        'fecha_salida'      => $registro->fecha_inicio,
                        'motivo_salida'     => "Asignado a servicio",
                    ]);

                    // Actualizar almacén
                    Almacen::where('articulo_id', $seleccionado['id'])
                        ->where('numero_serie', $seleccionado['numero_serie'])
                        ->update([
                            'fecha_salida' => $registro->fecha_inicio,
                            'estado'       => 'Asignado a servicio',
                        ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Registros guardados correctamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            if($e->getCode() === '23000' && $e->errorInfo[1] == 1062){
                return response()->json(['message' => 'La orden de servicio ya existe para esta empresa.'], 500);
            }
            return response()->json(['message' => 'Error al registrar los datos', 'error' => $e->getMessage()], 500);
        }
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = OrdenServicio::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $orden = OrdenServicio::with(['detalles'])->find($id);

        if (!$orden) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'venta_id' => 'sometimes|exists:ventas,id',
            'domicilio_servicio' => 'sometimes|string',
            'codigo_orden_servicio' => 'sometimes|string|unique:ordenes_servicios,codigo_orden_servicio,' . $id,
            'nombre_responsable_sitio' => 'sometimes|string|max:100',
            'telefono_responsable_sitio' => 'sometimes|string|max:15',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date|after_or_equal:fecha_inicio',
            'estatus' => 'sometimes|in:En proceso,Cancelada,Finalizada',
            'observaciones' => 'nullable|string',

            'guardias_id' => 'sometimes|array',
            'guardias_id.*.value' => 'sometimes|integer|exists:guardias,id',

            // Validación para los seleccionados
            'seleccionados' => 'nullable|array',
            'seleccionados.*.numero_serie' => 'nullable|string',
            'seleccionados.*.id' => 'nullable|integer|exists:articulos,id'
        ]);

        DB::beginTransaction();
        try {
            // Guardamos los IDs de todos los guardias que deben estar asignados
            $nuevosGuardias = collect($request->guardias_id)->pluck('value')->toArray();

            // Obtenemos los actuales para comparar
            $guardiasActuales = $orden->ordenesServicioGuardias->pluck('guardia_id')->toArray();

            // Calculamos diferencias
            $guardiasEliminados = array_diff($guardiasActuales, $nuevosGuardias);
            $guardiasNuevos = array_diff($nuevosGuardias, $guardiasActuales);

            // Actualizamos estatus de los guardias eliminados
            Guardia::whereIn('id', $guardiasEliminados)->update(['estatus' => 'Disponible', 'sucursal_id' => null]);

            // Obtener la sucursal asignada a la orden de servicio
            $venta = Venta::find($data['venta_id']);
            $empresaAsignada = $venta->cotizacion->sucursal->id;

            // Actualizamos estatus de los nuevos guardias
            Guardia::whereIn('id', $guardiasNuevos)->update(['estatus' => 'Asignado', 'sucursal_id' => $empresaAsignada]);

            OrdenServicioGuardia::where('orden_servicio_id', $orden->id)
            ->whereIn('guardia_id', $guardiasEliminados)
            ->delete();

            foreach ($guardiasNuevos as $guardiaId) {
                OrdenServicioGuardia::create([
                    'orden_servicio_id' => $orden->id,
                    'guardia_id' => $guardiaId,
                ]);
            }

            if($request->estatus === 'Cancelada' || $request->estatus === 'Finalizada'){
                // Si la orden se cancela o finaliza, liberamos todos los guardias asignados
                Guardia::whereIn('id', $guardiasActuales)->update(['estatus' => 'Disponible', 'sucursal_id' => null]);
                OrdenServicioGuardia::where('orden_servicio_id', $orden->id)->delete();

                // Si la orden se cancela o finaliza, liberamos todos los articulos a disponible
                $detalles = DetalleEquipamientoOrdenServicio::where('orden_servicio_id', $orden->id)->get();
                foreach($detalles as $detalle){
                    Almacen::where('articulo_id', $detalle->articulo_id)
                        ->where('numero_serie', $detalle->numero_serie)
                        ->update([
                            'fecha_salida' => null,
                            'estado' => 'Disponible',
                        ]);

                    // Registrar entrada en almacén
                    AlmacenEntrada::create([
                        'orden_servicio_id' => $orden->id,
                        'articulo_id' => $detalle->articulo_id,
                        'numero_serie' => $detalle->numero_serie,
                        'fecha_entrada' => $request->estatus === 'Cancelada' ? now() : $orden->fecha_fin,
                        'tipo_entrada' => 'Devolución de servicio',
                    ]);
                }
            }else{
                // Artículos anteriores (para devolución)
                $detallesAnteriores = $orden->detalles;
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
                            ->where('orden_servicio_id', $orden->id)
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
                            ->where('orden_servicio_id', $orden->id)
                            ->delete();
                    }
                }

                // Eliminar todos los detalles anteriores
                $orden->detalles()->delete();

                // Guardar en sus respectivas tablas los nuevos datos
                foreach ($request->seleccionados as $seleccionado) {
                    // Crear nuevo detalle
                    DetalleEquipamientoOrdenServicio::create([
                        'orden_servicio_id' => $orden->id,
                        'articulo_id' => $seleccionado['id'],
                        'numero_serie' => $seleccionado['numero_serie'],
                    ]);

                    // Eliminar cualquier salida existente para este artículo (por si cambió de número de serie)
                    AlmacenSalida::where('articulo_id', $seleccionado['id'])
                    ->where('orden_servicio_id', $orden->id)
                    ->delete();

                    // Crear nueva salida de almacén
                    AlmacenSalida::create([
                        'orden_servicio_id' => $orden->id,
                        'articulo_id' => $seleccionado['id'],
                        'numero_serie' => $seleccionado['numero_serie'],
                        'fecha_salida' => $data['fecha_inicio'] ?? $orden->fecha_inicio,
                        'motivo_salida' => "Asignado a servicio",
                    ]);

                    // Actualizar estado en almacén
                    Almacen::where('articulo_id', $seleccionado['id'])
                        ->where('numero_serie', $seleccionado['numero_serie'])
                        ->update([
                            'fecha_salida' => $data['fecha_inicio'] ?? $orden->fecha_inicio,
                            'estado' => 'Asignado a servicio',
                        ]);
                }


            }

            // Actualizar equipamiento
            $orden->update($data);

            DB::commit();
            return response()->json(['message' => 'Orden actualizada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al actualizar la orden', 'error' => $e->getMessage()], 500);
        }
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = OrdenServicio::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        DB::beginTransaction();

        try {
            $guardias = $registro->ordenesServicioGuardias->pluck('guardia_id')->toArray();
            Guardia::whereIn('id', $guardias)->update(['estatus' => 'Disponible', 'sucursal_id' => null]);

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
                    'orden_servicio_id' => $registro->id,
                    'articulo_id' => $detalle->articulo_id,
                    'numero_serie' => $detalle->numero_serie,
                    'fecha_entrada' => Carbon::now()->format('Y-m-d'),
                    'tipo_entrada' => 'Devolución de servicio',
                ]);
            }

            // $registro->delete();
            $registro->update(['estatus' => 'Finalizada','eliminado' => true]);

            DB::commit();
            return response()->json(['message' => 'Registro eliminado con éxito']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar el abono', 'error' => $e->getMessage()], 500);
        }

    }
}
