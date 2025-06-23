<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\BancoService;
use App\Models\Banco;
use App\Models\Cotizacion;
use App\Models\MovimientoBancario;
use App\Models\Venta;
use App\Models\VentaHistorial;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VentaController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Venta::with(['cotizacion.sucursal', 'cotizacion.sucursal_empresa', 'banco'])->where('eliminado', false)->get();
        return response()->json($registros);
    }

    //  * Mostrar todos los registros.
    public function ventaOrdenServicio()
    {
        $registros = Venta::with('cotizacion.sucursal')
            ->where('eliminado', false)
            ->where(function($query) {
                $query->where('estatus', 'Pendiente')
                    ->orWhere('estatus', 'Pagada');
            })->get();

        return response()->json($registros);
    }


    //  * Crear un nuevo registro.
    public function store(Request $request)
    {
        $data = $request->validate([
            'cotizacion_id' => 'required|exists:cotizaciones,id|unique:ventas,cotizacion_id',
            'banco_id' => 'required|exists:bancos,id',
            'tipo_pago' => 'required|in:Crédito,Contado',
            'metodo_pago' => 'required|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques',
            'referencia' => 'nullable|string',
            'numero_factura' => 'required|string',
            'fecha_emision' => 'required|date',
            'nota_credito' => 'nullable|numeric',
        ]);

        $cotizacion = Cotizacion::find($request->cotizacion_id);
        $data['fecha_vencimiento'] =  Carbon::parse($request->fecha_emision)->addDays($cotizacion->credito_dias ?? 0)->format('Y-m-d');

        $data['nota_credito'] =  $request->nota_credito ?? 0;
        $data['total'] = $request->nota_credito > 0 ? $cotizacion->total - $request->nota_credito : $cotizacion->total;

        $registro = Venta::create($data);
        $cotizacion->update(['aceptada' => 'SI']);
        $this->registrarHistorial($registro, 'creada desde ventas', $cotizacion->credito_dias);

        return response()->json(['message' => 'Registro guardada'], 201);
    }

    //  * Mostrar un solo registro por su ID.
    public function show($id)
    {
        $registro = Venta::with(['cotizacion.sucursal', 'cotizacion.sucursal_empresa'])->find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    //  * Actualizar un registro.
    public function update(Request $request, $id)
    {
        $registro = Venta::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $baseRules = [
            'cotizacion_id' => 'sometimes|exists:cotizaciones,id|unique:ventas,cotizacion_id,' . $id,
            'banco_id' => 'sometimes|exists:bancos,id',
            'estatus' => 'sometimes|in:Pendiente,Pagada,Vencida,Cancelada',
            'fecha_emision' => 'sometimes|date',
            'nota_credito' => 'nullable|numeric',
            'tipo_pago' => 'sometimes|in:Crédito,Contado',
        ];

        $pagadoRules = [
            'numero_factura' => 'required|string',
            'metodo_pago' => 'required|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques',
            'referencia' => 'nullable|string',
        ];

        $rules = $request->estatus === 'Pagada' ? array_merge($baseRules, $pagadoRules) : $baseRules;
        $data = $request->validate($rules);

        $cotizacion = Cotizacion::find($request->cotizacion_id);
        $data['fecha_vencimiento'] =  Carbon::parse($request->fecha_emision)->addDays($cotizacion->credito_dias ?? 0)->format('Y-m-d');

        $data['nota_credito'] =  $request->nota_credito ?? 0;
        $data['total'] = $request->nota_credito > 0 ? $cotizacion->total - $request->nota_credito : $cotizacion->total;

        $registro->update($data);
        $this->registrarHistorial($registro, 'actualizada desde ventas', $cotizacion->credito_dias);


        if($registro->estatus === 'Pagada'){
            $banco = Banco::findOrFail($data['banco_id'] ?? $registro->banco_id);
            $bancoService = new BancoService();

            $movimiento = $bancoService->registrarIngreso(
                $banco,
                $registro->total,
                'Venta: ' . ($data['numero_factura'] ?? $registro->numero_factura),
                $data['metodo_pago'] ?? $registro->metodo_pago,
                $registro
            );

            if($data['referencia'] && ($data['metodo_pago'] === 'Transferencia bancaria' || $data['metodo_pago'] === 'Tarjeta de crédito/débito')) {
                $movimiento->referencia = $data['referencia'];
                $movimiento->save();
            }
        }

        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    // * Cancelar venta
    public function cancelarVenta(Request $request)
    {
        $registro = Venta::find($request->id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'estatus' => 'required|in:Cancelada',
            'motivo_cancelada' => 'required|string',
        ]);

        $registro->update($data);
        $this->registrarHistorial($registro, 'cancelada desde ventas');
        return response()->json(['message' => 'Venta cancelada'], 201);
    }

    //  * Eliminar un registro.
    public function destroy($id)
    {
        $registro = Venta::find($id);
        $cotizacion = Cotizacion::find($registro->cotizacion_id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->update(['eliminado' => true]);
        $cotizacion->update(['aceptada' => 'PENDIENTE']);
        $this->registrarHistorial($registro, 'eliminada desde ventas');

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    function registrarHistorial($venta, $accion, $credito_dias = null)
    {
        $estatus = $venta->estatus ?? 'Pendiente';
        $motivo_cancelada = $venta->motivo_cancelada ?? '';
        $credito = $credito_dias ?? $venta->cotizacion->credito_dias;

        VentaHistorial::create([
            'usuario_id' => Auth::id(),
            'venta_id' => $venta->id,
            'banco_id' => $venta->banco_id,
            'cotizacion_id' => $venta->cotizacion_id,
            'numero_factura' => $venta->numero_factura,
            'fecha_emision' => $venta->fecha_emision,
            'fecha_vencimiento' => $venta->fecha_vencimiento,
            'total' => $venta->total,
            'nota_credito' => $venta->nota_credito,
            'credito_dias' => $credito,
            'tipo_pago' => $venta->tipo_pago,
            'metodo_pago' => $venta->metodo_pago,
            'estatus' => $estatus,
            'motivo_cancelada' => $motivo_cancelada,
            'accion' => $accion,
        ]);
    }

    public function ingresosMensuales()
    {
        $añoActual = now()->year;

        $ventas = Venta::selectRaw("MONTH(fecha_emision) as mes, SUM(total - nota_credito) as total")
            ->whereYear('fecha_emision', $añoActual)
            ->where('eliminado', false)
            ->where('estatus', 'Pagada')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];

        $data = collect($meses)->map(function ($nombreMes, $numeroMes) use ($ventas) {
            $venta = $ventas->firstWhere('mes', $numeroMes);
            return [
                'mes' => $nombreMes,
                'total' => $venta ? round($venta->total, 2) : 0
            ];
        })->values();

        return response()->json($data);
    }
}
