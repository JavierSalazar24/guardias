<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LimpiezaLog;

class LimpiezaLogController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
        $registros = LimpiezaLog::get();
        // $registros = LimpiezaLog::with('usuario')->get()->map(function ($log) {
        //     $log->detalles = json_decode($log->detalles, true);
        //     return $log;
        // });
        return response()->json($registros);
    }
}
