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
        return response()->json($registros);
    }
}
