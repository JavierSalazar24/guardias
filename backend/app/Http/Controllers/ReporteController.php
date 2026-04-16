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
use Carbon\Carbon;

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
            $registros = Equipamiento::with(['guardia', 'vehiculo', 'detalles.articulo'])->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])->get();
        }else{
            $registros = ReporteService::obtenerRegistros($request->modulo, $request->all());
        }

        return response()->json($registros);
    }

    public function generateReportRH(Request $request)
    {
        $request->validate([
            'modulo' => 'required|in:pagos-empleados,incapacidades,tiempo-extra,faltas,descuentos,vacaciones,prestamos',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'guardia_id' => 'required',
        ]);

        $config = [
            'pagos-empleados' => [
                'model' => PagoEmpleado::class,
                'with' => ['guardia', 'banco'],
                'type' => 'range',
                'start_field' => 'periodo_inicio',
                'end_field' => 'periodo_fin',
            ],
            'incapacidades' => [
                'model' => Incapacidad::class,
                'with' => ['guardia'],
                'type' => 'range',
                'start_field' => 'fecha_inicio',
                'end_field' => 'fecha_fin',
            ],
            'tiempo-extra' => [
                'model' => TiempoExtra::class,
                'with' => ['guardia'],
                'type' => 'range',
                'start_field' => 'fecha_inicio',
                'end_field' => 'fecha_fin',
            ],
            'faltas' => [
                'model' => Falta::class,
                'with' => ['guardia'],
                'type' => 'range',
                'start_field' => 'fecha_inicio',
                'end_field' => 'fecha_fin',
            ],
            'vacaciones' => [
                'model' => Vacacion::class,
                'with' => ['guardia'],
                'type' => 'range',
                'start_field' => 'fecha_inicio',
                'end_field' => 'fecha_fin',
            ],
            'descuentos' => [
                'model' => Descuento::class,
                'with' => ['guardia', 'modulo_descuento'],
                'type' => 'single',
                'date_field' => 'fecha',
            ],
            'prestamos' => [
                'model' => Prestamo::class,
                'with' => ['guardia', 'modulo_prestamo', 'abonos'],
                'type' => 'single',
                'date_field' => 'fecha_prestamo',
            ],
        ];

        $modulo = $request->modulo;

        if (!isset($config[$modulo])) {
            return response()->json(['error' => 'Módulo no válido'], 400);
        }

        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->endOfDay();

        $cfg = $config[$modulo];

        $query = $cfg['model']::with($cfg['with'] ?? [])
            ->when($request->guardia_id !== 'todos', function ($q) use ($request) {
                $q->where('guardia_id', $request->guardia_id);
            });

        if ($cfg['type'] === 'range') {
            $startField = $cfg['start_field'];
            $endField = $cfg['end_field'];

            $query->whereDate($startField, '<=', $fechaFin->toDateString())
                ->whereDate($endField, '>=', $fechaInicio->toDateString())
                ->orderBy($startField, 'desc');
        }

        if ($cfg['type'] === 'single') {
            $dateField = $cfg['date_field'];

            $query->whereBetween($dateField, [
                    $fechaInicio->toDateString(),
                    $fechaFin->toDateString()
                ])
                ->orderBy($dateField, 'desc');
        }

        return response()->json($query->get());
    }

}
