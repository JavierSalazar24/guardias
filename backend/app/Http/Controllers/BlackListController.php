<?php

namespace App\Http\Controllers;

use App\Models\Guardia;
use App\Models\BlackList;
use Illuminate\Http\Request;

class BlackListController extends Controller
{
    //  * Mostrar todos los registros.
    public function index()
    {
         $registros = BlackList::with('guardia.sucursal_empresa')->get();

        $registros->map(function ($blacklist) {
            if ($blacklist->guardia) {
                $blacklist->guardia->append(['foto_url']);
            }
            return $blacklist;
        });

        return response()->json($registros);
    }

    // agregar guardia a la lista negra
    public function store(Request $request)
    {
        $request->validate([
            'motivo_baja' => 'required|string'
        ]);

        if($request->id){
            $guardia_id = $request->id;
        }else{
            $guardia_id = $request->guardia_id;
        }

        $blackList = BlackList::create([
            'motivo_baja' => $request->motivo_baja,
            'guardia_id' => $guardia_id
        ]);

        Guardia::find($guardia_id)->update(['eliminado' => true]);

        return response()->json($blackList);
    }

    // actualizar guardia en la lista negra
    public function update(Request $request, $id)
    {
        $blackList = BlackList::find($id);
        if (!$blackList) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $request->validate(['motivo_baja' => 'required|string']);

        $blackList->update(['motivo_baja' => $request->motivo_baja]);

        return response()->json($blackList);
    }

    // eliminar guardia en la lista negra
    public function destroy($id)
    {
        $blackList = BlackList::find($id);
        if (!$blackList) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        Guardia::find($blackList->guardia_id)->update(['eliminado' => false]);

        $blackList->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
