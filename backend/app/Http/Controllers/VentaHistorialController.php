<?php

namespace App\Http\Controllers;

use App\Models\VentaHistorial;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VentaHistorialController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = VentaHistorial::with(['cotizacion.sucursal', 'venta.cotizacion.sucursal', 'usuario.rol', 'banco', 'venta.banco'])->get();
        return response()->json($registros);
    }
}