<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cotizacion;
use App\Models\ServicioCotizacion;
use App\Models\Venta;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class CotizacionController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Cotizacion::with(['sucursal.cliente', 'venta', 'sucursal_empresa', 'serviciosCotizaciones.tipoServicio'])->get();
        return response()->json($registros);
    }

    // PDF de la cotización
    public function generarPDF($id)
    {
        $cotizacion = Cotizacion::with('sucursal.cliente', 'venta', 'sucursal_empresa')->findOrFail($id);

        $nombre = $cotizacion->sucursal->nombre_empresa;
        $nombre = str_replace(' ', '_', $nombre);

        $pdf = Pdf::loadView('pdf.cotizacion', compact('cotizacion'));
        return $pdf->stream('cotizacion_de_' . $nombre . '.pdf');
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'sucursal_empresa_id' => 'required|exists:sucursales_empresa,id',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'credito_dias' => 'required|integer|min:0',
            'guardias_dia' => 'required|integer|min:0',
            'precio_guardias_dia' => 'required|numeric|min:0',
            'precio_guardias_dia_total' => 'required|numeric|min:0',
            'guardias_noche' => 'required|integer|min:0',
            'precio_guardias_noche' => 'required|numeric|min:0',
            'precio_guardias_noche_total' => 'required|numeric|min:0',
            'cantidad_guardias' => 'required|integer|min:0',
            'jefe_turno' => 'required|in:SI,NO',
            'precio_jefe_turno' => 'nullable|numeric|min:0',
            'supervisor' => 'required|in:SI,NO',
            'precio_supervisor' => 'nullable|numeric|min:0',
            'fecha_servicio' => 'required|date',
            'soporte_documental' => 'required|in:SI,NO',
            'observaciones_soporte_documental' => 'nullable|string',
            'requisitos_pago_cliente' => 'nullable|string',
            'impuesto' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0',
            'costo_extra' => 'nullable|numeric',
            'total' => 'required|numeric|min:0',
            'notas' => 'nullable|string',

            // Validación para los servicios
            'tipo_servicio_id' => 'required|array',
            'tipo_servicio_id.*.value' => 'required|integer|exists:tipos_servicios,id',
            'precio_total_servicios' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $registro = Cotizacion::create($data);

            foreach ($request->tipo_servicio_id as $servicio) {
                ServicioCotizacion::create([
                    'cotizacion_id' => $registro->id,
                    'tipo_servicio_id' => $servicio['value'],
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Registro guardado'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar los datos', 'error' => $e->getMessage()], 500);
        }
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Cotizacion::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Cotizacion::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'aceptada' => 'sometimes|in:NO,SI,PENDIENTE',
            'sucursal_empresa_id' => 'sometimes|exists:sucursales_empresa,id',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'credito_dias' => 'sometimes|integer|min:0',
            'guardias_dia' => 'sometimes|integer|min:0',
            'precio_guardias_dia' => 'sometimes|numeric|min:0',
            'precio_guardias_dia_total' => 'sometimes|numeric|min:0',
            'guardias_noche' => 'sometimes|integer|min:0',
            'precio_guardias_noche' => 'sometimes|numeric|min:0',
            'precio_guardias_noche_total' => 'sometimes|numeric|min:0',
            'cantidad_guardias' => 'sometimes|integer|min:0',
            'jefe_turno' => 'sometimes|in:SI,NO',
            'precio_jefe_turno' => 'nullable|numeric|min:0',
            'supervisor' => 'sometimes|in:SI,NO',
            'precio_supervisor' => 'nullable|numeric|min:0',
            'fecha_servicio' => 'sometimes|date',
            'soporte_documental' => 'sometimes|in:SI,NO',
            'observaciones_soporte_documental' => 'nullable|string',
            'requisitos_pago_cliente' => 'nullable|string',
            'impuesto' => 'sometimes|numeric|min:0',
            'subtotal' => 'sometimes|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0',
            'costo_extra' => 'nullable|numeric|min:0',
            'total' => 'sometimes|numeric|min:0',
            'notas' => 'nullable|string',

            // Validación para los servicios
            'tipo_servicio_id' => 'sometimes|array',
            'tipo_servicio_id.*.value' => 'sometimes|integer|exists:tipos_servicios,id',
            'precio_total_servicios' => 'sometimes|numeric|min:0',
        ]);

        if($request->aceptada === 'SI'){
            $venta = Venta::where('cotizacion_id', $id)->first();

            if (!$venta) {
                $venta_data = $request->validate([
                    'fecha_emision' => 'required|date',
                    'nota_credito' => 'nullable|numeric',
                    'tipo_pago' => 'required|in:Crédito,Contado',
                ]);

                $venta_data['nota_credito'] =  $request->nota_credito ?? 0;
                $total = $request->nota_credito > 0 ? $request->total - $request->nota_credito : $request->total;

                $venta_create = Venta::create([
                    'cotizacion_id'   => $id,
                    'nota_credito' => $venta_data['nota_credito'],
                    'fecha_emision' => $venta_data['fecha_emision'],
                    'tipo_pago' => $venta_data['tipo_pago'],
                    'total' => $total,
                    'fecha_vencimiento' => Carbon::parse($venta_data['fecha_emision'])->addDays($request->credito_dias ?? 0)->format('Y-m-d'),
                ]);

                app(VentaController::class)->registrarHistorial($venta_create, 'creada desde cotización', $request->credito_dias);
            }else{
                $venta_data = $request->validate([
                    'nota_credito' => 'nullable|numeric',
                    'fecha_emision' => 'sometimes|date',
                    'tipo_pago' => 'sometimes|in:Crédito,Contado',
                ]);

                $venta_data['nota_credito'] =  $request->nota_credito ?? 0;
                $venta_data['total'] = $request->nota_credito > 0 ? $request->total - $request->nota_credito : $request->total;
                $venta_data['fecha_vencimiento'] = Carbon::parse($venta_data['fecha_emision'])->addDays($request->credito_dias ?? 0)->format('Y-m-d');

                $venta->update($venta_data);
                app(VentaController::class)->registrarHistorial($venta, 'actualizada desde cotización', $request->credito_dias);
            }

        }

        DB::beginTransaction();
        try {
            $registro->update($data);

            // Guardamos los IDs de todos los servicios que deben estar asignados
            $nuevosServicios = collect($request->tipo_servicio_id)->pluck('value')->toArray();

            // Obtenemos los actuales para comparar
            $serviciosActuales = $registro->serviciosCotizaciones->pluck('tipo_servicio_id')->toArray();

            // Calculamos diferencias
            $serviciosEliminados = array_diff($serviciosActuales, $nuevosServicios);
            $serviciosNuevos = array_diff($nuevosServicios, $serviciosActuales);

            ServicioCotizacion::where('cotizacion_id', $registro->id)
            ->whereIn('tipo_servicio_id', $serviciosEliminados)
            ->delete();

            foreach ($serviciosNuevos as $servicioId) {
                ServicioCotizacion::create([
                    'cotizacion_id' => $registro->id,
                    'tipo_servicio_id' => $servicioId,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Registro actualizado'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al actualizar el registro', 'error' => $e->getMessage()], 500);
        }
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Cotizacion::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
