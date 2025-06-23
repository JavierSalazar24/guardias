<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Services\BancoService;
use App\Services\ValidadorSaldoBanco;
use App\Models\Guardia;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    public function index()
    {
        return Prestamo::with(['guardia', 'abonos', 'modulo_prestamo', 'banco'])->latest()->get();
    }

    public function prestamosPendientes()
    {
        return Prestamo::with(['guardia', 'abonos', 'modulo_prestamo', 'banco'])->where('estatus', 'Pendiente')->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'banco_id' => 'required|exists:bancos,id',
            'guardia_id' => 'required|exists:guardias,id',
            'monto_total' => 'required|numeric|min:1',
            'numero_pagos' => 'required|integer|min:1',
            'fecha_prestamo' => 'required|date',
            'modulo_prestamo_id' => 'required|exists:modulo_prestamos,id',
            'metodo_pago' => 'required|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques,Descuento nómina,Otro',
            'referencia' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $banco = Banco::findOrFail($data['banco_id']);
        $resultado = ValidadorSaldoBanco::validar($banco, $data['monto_total']);

        if (!$resultado['ok']) {
            return response()->json(['message' => $resultado['error']], 422);
        }

        $data['saldo_restante'] = $data['monto_total'];
        $prestamo = Prestamo::create($data);

        $guardia = Guardia::findOrFail($data['guardia_id']);

        // Crea el movimiento bancario (egreso)
        $bancoService = new BancoService();
        $movimiento = $bancoService->registrarEgreso(
            $banco,
            $data['monto_total'],
            "Préstamo a guardia NE: {$guardia->numero_empleado}",
            $data['metodo_pago'],
            $prestamo
        );

        if($data['metodo_pago'] === 'Transferencia bancaria' || $data['metodo_pago'] === 'Tarjeta de crédito/débito') {
            $movimiento->referencia = $data['referencia'];
            $movimiento->save();
        }

        return $prestamo;
    }

    public function show($id)
    {
        return Prestamo::with(['guardia', 'abonos', 'modulo_prestamo', 'banco'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $prestamo = Prestamo::find($id);
        if (!$prestamo) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'numero_pagos' => 'sometimes|integer|min:1',
            'modulo_prestamo_id' => 'sometimes|exists:modulo_prestamos,id',
            'observaciones' => 'nullable|string',
            'metodo_pago' => 'sometimes|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques',
            'referencia' => 'nullable|string',
        ]);

        $metodoPago = $data['metodo_pago'] ?? $prestamo->metodo_pago;
        if ($metodoPago !== 'Transferencia bancaria' && $metodoPago !== 'Tarjeta de crédito/débito') {
            $data['referencia'] = null;
        }

        $prestamo->update($data);

        $guardia = Guardia::findOrFail($request->guardia_id);

        $movimiento = $prestamo->movimientosBancarios()->first();
        if ($movimiento) {
            $movimiento->update([
                'concepto'    => "Préstamo a guardia NE: {$guardia->numero_empleado}",
                'metodo_pago'  => $metodoPago,
                'referencia'   => $data['referencia'] ?? null,
            ]);
        }

        return response()->json(['message' => 'Registro actualizado'], 201);
    }

    public function destroy($id)
    {
        $registro = Prestamo::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->movimientosBancarios()->delete();
        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
