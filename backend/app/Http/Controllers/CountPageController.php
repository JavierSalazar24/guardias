<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Guardia;
use App\Models\Articulo;
use Illuminate\Http\Request;

class CountPageController extends Controller
{
    //  * Mostrar todos los registros.
    public function getCount()
    {
        $clientes = Cliente::count();
        $proveedores = Proveedor::count();
        $guardias = Guardia::count();
        $articulos = Articulo::count();
        return response()->json(['clientes' => $clientes, 'proveedores' => $proveedores, 'guardias' => $guardias, 'articulos' => $articulos]);
    }

}
