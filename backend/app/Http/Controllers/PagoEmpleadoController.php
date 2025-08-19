<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Services\BancoService;
use App\Services\ValidadorSaldoBanco;
use App\Models\PagoEmpleado;
use App\Models\Guardia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use DB;

class PagoEmpleadoController extends Controller
{
     public function index()
    {
        return PagoEmpleado::with(['banco', 'guardia'])->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'banco_id' => 'required|exists:bancos,id',
            'guardia_id' => 'required|exists:guardias,id',
            'sueldo_base' => 'required|numeric',
            'periodo_inicio' => 'required|date',
            'periodo_fin' => 'required|date|after_or_equal:periodo_inicio',
            'dias_trabajados' => 'required|numeric',
            'tiempo_extra' => 'required|numeric',
            'prima_vacacional' => 'required|numeric',
            'incapacidades_pagadas' => 'required|numeric',
            'descuentos' => 'required|numeric',
            'faltas' => 'required|numeric',
            'incapacidades_no_pagadas' => 'required|numeric',
            'imss' => 'required|numeric',
            'infonavit' => 'required|numeric',
            'fonacot' => 'required|numeric',
            'retencion_isr' => 'required|numeric',
            'total_ingresos' => 'required|numeric',
            'total_egresos' => 'required|numeric',
            'total_retenciones' => 'required|numeric',
            'pago_bruto' => 'required|numeric',
            'pago_final' => 'required|numeric',
            'metodo_pago' => 'required|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques,Descuento nómina,Otro',
            'referencia' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $banco = Banco::findOrFail($data['banco_id']);
            $resultado = ValidadorSaldoBanco::validar($banco, $data['pago_final']);
            if (!$resultado['ok']) {
                return response()->json(['message' => $resultado['error']], 422);
            }

            $registro = PagoEmpleado::create($data);

            $guardia = Guardia::findOrFail($data['guardia_id']);

            // Crea el movimiento bancario (egreso)
            $bancoService = new BancoService();
            $movimiento = $bancoService->registrarEgreso(
                $banco,
                $data['pago_final'],
                "Pago a empleado NE: {$guardia->numero_empleado}",
                $data['metodo_pago'],
                $registro
            );

            if($data['metodo_pago'] === 'Transferencia bancaria' || $data['metodo_pago'] === 'Tarjeta de crédito/débito') {
                $movimiento->referencia = $data['referencia'];
                $movimiento->save();
            }

            DB::commit();
            return $registro;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar el abono', 'error' => $e->getMessage()], 500);
        }

    }

    public function show($id)
    {
        return PagoEmpleado::with('guardia')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = PagoEmpleado::find($id);
        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'observaciones' => 'nullable|string',
            'metodo_pago' => 'sometimes|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques',
            'referencia' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $metodoPago = $data['metodo_pago'] ?? $registro->metodo_pago;
            if ($metodoPago !== 'Transferencia bancaria' && $metodoPago !== 'Tarjeta de crédito/débito') {
                $data['referencia'] = null;
            }

            $registro->update($data);

            $guardia = Guardia::findOrFail($request->guardia_id);

            $movimiento = $registro->movimientosBancarios()->first();
            if ($movimiento) {
                $movimiento->update([
                    'concepto'    => "Pago a empleado NE: {$guardia->numero_empleado}",
                    'metodo_pago'  => $metodoPago,
                    'referencia'   => $data['referencia'] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Registro actualizado'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar el abono', 'error' => $e->getMessage()], 500);
        }

    }

    public function destroy($id)
    {
        $registro = PagoEmpleado::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        DB::beginTransaction();

        try {
            $registro->movimientosBancarios()->delete();
            $registro->delete();

            DB::commit();
            return response()->json(['message' => 'Registro eliminado con éxito']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar el abono', 'error' => $e->getMessage()], 500);
        }

    }

    public function generarPdf($id)
    {
        $pago = PagoEmpleado::with('guardia')->find($id);
        if (!$pago) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $pdf = Pdf::loadView('pdf.pago_empleado', compact('pago'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream("pago_empleado_{$pago->guardia->nombre}_{$pago->guardia->apellido_p}_{$pago->guardia->apellido_m}_({$pago->guardia->numero_empleado}).pdf");
    }
}
