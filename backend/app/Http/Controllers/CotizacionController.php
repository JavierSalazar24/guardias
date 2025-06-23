<?php

namespace App\Http\Controllers;

use App\Helpers\ArchivosHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cotizacion;
use App\Models\Venta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CotizacionController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Cotizacion::with(['sucursal.cliente', 'venta', 'sucursal_empresa'])->get();
        return response()->json($registros->append('situacion_fiscal_url'));
    }

    // PDF de la cotización
    public function generarPDF($id)
    {
        $cotizacion = Cotizacion::with('sucursal.cliente', 'venta', 'sucursal_empresa')->findOrFail($id);

        $nombre = $cotizacion->nombre_empresa ?? $cotizacion->sucursal->nombre_empresa;
        $nombre = str_replace(' ', '_', $nombre);

        $pdf = Pdf::loadView('pdf.cotizacion', compact('cotizacion'));
        return $pdf->stream('cotizacion_de_' . $nombre . '.pdf');
    }

    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $baseRules = [
            'credito_dias' => 'required|integer',
            'descuento_porcentaje' => 'nullable|numeric',
            'fecha_servicio' => 'required|date',
            'servicios' => 'required|string',
            'guardias_dia' => 'required|integer',
            'precio_guardias_dia' => 'required|numeric',
            'precio_guardias_dia_total' => 'required|numeric',
            'guardias_noche' => 'required|integer',
            'precio_guardias_noche' => 'required|numeric',
            'precio_guardias_noche_total' => 'required|numeric',
            'cantidad_guardias' => 'required|integer',
            'jefe_turno' => 'required|in:SI,NO',
            'precio_jefe_turno' => 'nullable|numeric',
            'supervisor' => 'required|in:SI,NO',
            'precio_supervisor' => 'nullable|numeric',
            'notas' => 'nullable|string',
            'costo_extra' => 'nullable|numeric',
            'subtotal' => 'required|numeric',
            'impuesto' => 'required|numeric',
            'total' => 'required|numeric',
            'sucursal_id' => 'nullable|exists:sucursales,id',

            'soporte_documental' => 'required|in:SI,NO',
            'observaciones_soporte_documental' => 'nullable|string',
            'requisitos_pago_cliente' => 'nullable|string',

            'sucursal_empresa_id' => 'required|exists:sucursales_empresa,id',
        ];

        $empresaRules = [
            'nombre_empresa' => 'nullable|string',
            'calle' => 'nullable|string|max:100',
            'numero' => 'nullable|string|max:20',
            'colonia' => 'nullable|string|max:100',
            'cp' => 'nullable|digits:5',
            'municipio' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'telefono_empresa' => 'nullable|string|max:15',
            'extension_empresa' => 'nullable|string|max:10',
            'nombre_contacto' => 'nullable|string',
            'telefono_contacto' => 'nullable|string|max:15',
            'whatsapp_contacto' => 'nullable|string|max:15',
            'correo_contacto' => 'nullable|email|unique:cotizaciones,correo_contacto',

            'rfc' => 'nullable|string|max:13',
            'razon_social' => 'nullable|string',
            'uso_cfdi' => 'nullable|string',
            'regimen_fiscal' => 'nullable|string',
            'situacion_fiscal' => 'nullable|file|mimes:pdf|max:2048',
        ];

        if ($request->hasFile('situacion_fiscal')) {
            $data['situacion_fiscal'] = $this->subirDocumento($request->file('situacion_fiscal'));
        }

        $rules = $request->cliente_existente ? $baseRules : array_merge($baseRules, $empresaRules);

        $data = $request->validate($rules);

        $registro = Cotizacion::create($data);
        return response()->json(['message' => 'Registro guardado'], 201);
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

        $baseRules = [
            'credito_dias' => 'sometimes|integer',
            'descuento_porcentaje' => 'nullable|numeric',
            'fecha_servicio' => 'sometimes|date',
            'servicios' => 'sometimes|string',
            'guardias_dia' => 'sometimes|integer',
            'precio_guardias_dia' => 'sometimes|numeric',
            'precio_guardias_dia_total' => 'sometimes|numeric',
            'guardias_noche' => 'sometimes|integer',
            'precio_guardias_noche' => 'sometimes|numeric',
            'precio_guardias_noche_total' => 'sometimes|numeric',
            'cantidad_guardias' => 'sometimes|integer',
            'jefe_turno' => 'sometimes|in:SI,NO',
            'precio_jefe_turno' => 'nullable|numeric',
            'supervisor' => 'sometimes|in:SI,NO',
            'precio_supervisor' => 'nullable|numeric',
            'notas' => 'nullable|string',
            'costo_extra' => 'nullable|numeric',
            'subtotal' => 'sometimes|numeric',
            'impuesto' => 'sometimes|numeric',
            'total' => 'sometimes|numeric',
            'aceptada' => 'sometimes|in:NO,SI,PENDIENTE',
            'sucursal_id' => 'nullable|exists:sucursales,id',

            'soporte_documental' => 'sometimes|in:SI,NO',
            'observaciones_soporte_documental' => 'nullable|string',
            'requisitos_pago_cliente' => 'nullable|string',

            'sucursal_empresa_id' => 'sometimes|exists:sucursales_empresa,id',
        ];

        $empresaRules = [
            'nombre_empresa' => 'nullable|string',
            'calle' => 'nullable|string|max:100',
            'numero' => 'nullable|string|max:20',
            'colonia' => 'nullable|string|max:100',
            'cp' => 'nullable|digits:5',
            'municipio' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'telefono_empresa' => 'nullable|string|max:15',
            'extension_empresa' => 'nullable|string|max:10',
            'nombre_contacto' => 'nullable|string',
            'telefono_contacto' => 'nullable|string|max:15',
            'whatsapp_contacto' => 'nullable|string|max:15',
            'correo_contacto' => 'nullable|email|unique:cotizaciones,correo_contacto,' . $id,

            'rfc' => 'nullable|string|max:13',
            'razon_social' => 'nullable|string',
            'uso_cfdi' => 'nullable|string',
            'regimen_fiscal' => 'nullable|string',
            'situacion_fiscal' => 'nullable|file|mimes:pdf|max:2048',
        ];

        if ($request->hasFile('situacion_fiscal')) {
            if ($registro->situacion_fiscal) {
                $this->eliminarDocumento($registro->situacion_fiscal);
            }
            $data['situacion_fiscal'] = $this->subirDocumento($request->file('situacion_fiscal'));
        }

        $rules = $request->cliente_existente ? $baseRules : array_merge($baseRules, $empresaRules);

        $data = $request->validate($rules);

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

        $registro->update($data);
        return response()->json(['message' => 'Registro actualizado'], 201);
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
