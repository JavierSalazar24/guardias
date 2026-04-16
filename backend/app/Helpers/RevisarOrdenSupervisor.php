<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RevisarOrdenSupervisor
{
    /**
     * Filtra el query para que solo muestre los registros
     * si el guardia del usuario está asignado en la orden de servicio.
     */

    public static function mostrarOrdenesRelacionadas($query)
    {
        $usuario = Auth::user();

        if ($usuario && $usuario->guardia_id) {
            return $query->whereHas('orden_servicio.guardias', function ($q) use ($usuario) {
                $q->where('guardias.id', $usuario->guardia_id);
            });
        }

        // Si es admin u otro rol, ve todo
        return $query;
    }
}