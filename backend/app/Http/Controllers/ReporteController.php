<?php

namespace App\Http\Controllers;

use App\Models\Incapacidad;
use App\Models\TiempoExtra;
use App\Models\Falta;
use App\Models\Descuento;
use App\Models\Vacacion;
use App\Models\Prestamo;
use App\Models\AbonoPrestamo;
use App\Models\Almacen;
use App\Models\Equipamiento;
use Illuminate\Http\Request;
use App\Services\ReporteService;

class ReporteController extends Controller
{
    //  * Mostrar un solo registro por su ID.
    public function getReport(Request $request)
    {

        $request->validate([
            'modulo' => 'required|in:movimientos,orden-compra,compras,gastos,ventas,almacen,equipo,boletas-gasolina',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',

            'metodo_pago' => 'nullable|in:todos,Transferencia bancaria,Tarjeta de crédito/débito,Efectivo,Cheques',
            'tipo_pago' => 'nullable|in:todos,Crédito,Contado',
            'estatus' => 'nullable|in:todos,Pagada,Pendiente,Cancelada',
            'tipo_movimiento' => 'nullable|in:todos,Ingreso,Egreso',
        ]);

        if($request->modulo === 'almacen') {
            $registros = Almacen::with(['articulo'])->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])->get();
        }else if($request->modulo === 'equipo') {
            $registros = Equipamiento::with(['guardia', 'vehiculo', 'detalles.articulo'])
                ->where('eliminado', false)
                ->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])->get();
        }else{
            $registros = ReporteService::obtenerRegistros($request->modulo, $request->all());
        }

        return response()->json($registros);
    }

    public function generateReportRH(Request $request)
    {
        $request->validate([
            'modulo' => 'required|in:incapacidades,tiempo-extra,faltas,descuentos,vacaciones,prestamos',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'guardia_id' => 'required'
        ]);

        $modelos = [
            'incapacidades' => Incapacidad::class,
            'tiempo-extra' => TiempoExtra::class,
            'faltas' => Falta::class,
            'descuentos' => Descuento::class,
            'vacaciones' => Vacacion::class,
            'prestamos' => Prestamo::class,
        ];

        $with = [
            'incapacidades' => ['guardia'],
            'tiempo-extra' => ['guardia'],
            'faltas' => ['guardia'],
            'descuentos' => ['guardia'],
            'vacaciones' => ['guardia'],
            'prestamos' => ['guardia', 'abonos'],
        ];

        $modulo = $request->modulo;
        if (!array_key_exists($modulo, $modelos)) {
            return response()->json(['error' => 'Módulo no válido'], 400);
        }

        $query = $modelos[$modulo]::with($with[$modulo] ?? [])
        ->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])
        ->when($request->guardia_id !== 'todos', function ($q) use ($request) {
            $q->where('guardia_id', $request->guardia_id);
        })
        ->latest();

    return $query->get();
    }

}