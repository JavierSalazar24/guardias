<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Venta;
use App\Models\VentaHistorial;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteCarteraVencidaController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = Venta::with('cotizacion.sucursal.cliente')
            ->where('tipo_pago', 'Crédito')
            ->whereNotIn('estatus', ['Pagada', 'Cancelada'])
            ->whereBetween('fecha_vencimiento', [
                now()->subMonths(3)->startOfDay(),
                now()->subMonth()->endOfDay()
            ])
            ->where('eliminado', false)->get();

        return response()->json($registros);
    }

}
