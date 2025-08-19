<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Services\BancoService;
use App\Services\ValidadorSaldoBanco;
use App\Models\Vehiculo;
use App\Models\BoletaGasolina;
use Illuminate\Http\Request;
use DB;

class BoletaGasolinaController extends Controller
{
    public function index()
    {
        return BoletaGasolina::with(['vehiculo', 'banco'])->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'banco_id' => 'required|exists:bancos,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'kilometraje' => 'required|numeric|min:0',
            'litros' => 'required|numeric|min:1',
            'costo_litro' => 'required|numeric|min:1',
            'costo_total' => 'required|numeric|min:1',
            'metodo_pago' => 'required|in:Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques',
            'referencia' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $banco = Banco::findOrFail($data['banco_id']);
            $resultado = ValidadorSaldoBanco::validar($banco, $data['costo_total']);
            if (!$resultado['ok']) {
                return response()->json(['message' => $resultado['error']], 422);
            }

            $boleta = BoletaGasolina::create($data);

            $bancoService = new BancoService();
            $movimiento = $bancoService->registrarEgreso(
                $banco,
                $data['costo_total'],
                "Boleta de gasolina al carro con placas: {$boleta->vehiculo->placas}",
                $data['metodo_pago'],
                $boleta
            );

            if($data['metodo_pago'] === 'Transferencia bancaria' || $data['metodo_pago'] === 'Tarjeta de crédito/débito') {
                $movimiento->referencia = $data['referencia'];
                $movimiento->save();
            }

            DB::commit();
            return response()->json(['message' => 'Registro guardado'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar el abono', 'error' => $e->getMessage()], 500);
        }

    }

    public function show($id)
    {
        return BoletaGasolina::with('guardia')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = BoletaGasolina::find($id);
        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'kilometraje' => 'sometimes|numeric|min:0',
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

            $movimiento = $registro->movimientosBancarios()->first();
            if ($movimiento) {
                $movimiento->update([
                    'concepto'    => "Boleta de gasolina al carro con placas: {$registro->vehiculo->placas}",
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
        $registro = BoletaGasolina::find($id);

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
}
