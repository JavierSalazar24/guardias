<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Services\BancoService;
use App\Models\AbonoPrestamo;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use DB;

class AbonoPrestamoController extends Controller
{
    public function index()
    {
        return AbonoPrestamo::with(['prestamo.guardia', 'banco'])->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'banco_id' => 'required|exists:bancos,id',
            'prestamo_id' => 'required|exists:prestamos,id',
            'monto' => 'required|numeric|min:1',
            'fecha' => 'required|date',
            'metodo_pago' => 'required|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques,Descuento nómina,Otro',
            'referencia' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $prestamo = Prestamo::find($request->prestamo_id);

            if (!$prestamo) {
                return response()->json(['error' => 'Prestamo no encontrado'], 404);
            }

            if ($data['monto'] > $prestamo->saldo_restante) {
                return response()->json(['message' => 'El abono excede el saldo pendiente.'], 422);
            }

            $abono = AbonoPrestamo::create($data);

            // actualizar saldo del préstamo
            $prestamo->saldo_restante -= $data['monto'];
            if ($prestamo->saldo_restante <= 0) {
                $prestamo->saldo_restante = 0;
                $prestamo->estatus = "Pagado";
                $prestamo->fecha_pagado = $data['fecha'];
            }
            $prestamo->save();

            // Crea el movimiento bancario (ingreso)
            $banco = Banco::findOrFail($data['banco_id']);
            $bancoService = new BancoService();
            $movimiento = $bancoService->registrarIngreso(
                $banco,
                $data['monto'],
                "Abono del préstamo del guardia: {$prestamo->guardia->numero_empleado}",
                $data['metodo_pago'],
                $abono
            );

            if($data['metodo_pago'] === 'Transferencia bancaria' || $data['metodo_pago'] === 'Tarjeta de crédito/débito') {
                $movimiento->referencia = $data['referencia'];
                $movimiento->save();
            }

            DB::commit();

            return $abono;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar el abono', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return AbonoPrestamo::with(['prestamo.guardia', 'banco'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = AbonoPrestamo::find($id);
        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'metodo_pago' => 'sometimes|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques,Descuento nómina,Otro',
            'referencia' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $metodoPago = $data['metodo_pago'] ?? $registro->metodo_pago;
            if ($metodoPago !== 'Transferencia bancaria' && $metodoPago !== 'Tarjeta de crédito/débito') {
                $data['referencia'] = null;
            }

            $registro->update($data);

            $prestamo = Prestamo::find($request->prestamo_id);

            $movimiento = $registro->movimientosBancarios()->first();
            if ($movimiento) {
                $movimiento->update([
                    'concepto'    => "Abono del préstamo del guardia: {$prestamo->guardia->numero_empleado}",
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
        $registro = AbonoPrestamo::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        DB::beginTransaction();

        try {

            $prestamo = $registro->prestamo;

            // Revertir saldo si se elimina abono
            $prestamo->saldo_restante += $registro->monto;
            $prestamo->estatus = "Pendiente";
            $prestamo->fecha_pagado = NULL;
            $prestamo->save();

            $registro->movimientosBancarios()->delete();
            $registro->delete();


            DB::commit();
            return response()->json(['message' => 'Registro eliminado con éxito']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar el abono', 'error' => $e->getMessage()], 500);
        }
    }
}
