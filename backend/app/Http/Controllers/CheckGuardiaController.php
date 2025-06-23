<?php

namespace App\Http\Controllers;

use App\Helpers\RevisarOrdenSupervisor;
use App\Helpers\ImageHelper;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CheckGuardia;
use App\Models\Guardia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckGuardiaController extends Controller
{
    public function index()
    {
        $query = CheckGuardia::with(['guardia', 'orden_servicio.guardias'])->latest();
        $registros = RevisarOrdenSupervisor::mostrarOrdenesRelacionadas($query)->get();

        return response()->json($registros);

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'orden_servicio_id' => 'required|exists:ordenes_servicios,id',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'ubicacion' => 'required|string',
            'comentarios' => 'nullable|string',
            'foto' => 'required|string'
        ]);

        // Verificar si hay un checkin abierto
        $checkAbierto = CheckGuardia::where('guardia_id', $request->guardia_id)
            ->whereNull('fecha_salida')
            ->latest()
            ->first();

        if ($checkAbierto) {
            return response()->json([
                'message' => 'Ya has realizado un check-in. Debes hacer check-out antes de registrar uno nuevo.',
                'check_id' => $checkAbierto->id,
                'fecha_entrada' => Carbon::parse($checkAbierto->fecha_entrada)->format('d/m/Y h:i:s A')
            ], 409);
        }

        $data['fecha_entarda'] = Carbon::now();

        $registro = CheckGuardia::create($data);
        return response()->json(['message' => 'Check-in registrado', 'id' => $registro->id], 201);
    }

    // Registrar Check-out
    public function update(Request $request, $id)
    {
        $registro = CheckGuardia::find($id);

        if(!$registro){
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }elseif ($registro->fecha_salida) {
            return response()->json(['message' => 'Ya se registró la salida anteriormente'], 400);
        }

        $request->validate([
            'foto' => 'required|string',
            'latitude_salida' => 'required|numeric|between:-90,90',
            'longitude_salida' => 'required|numeric|between:-180,180',
            'ubicacion_salida' => 'required|string',
            'comentarios_salida' => 'nullable|string'
        ]);

        // Transormación para guardar el tiempo trabajado
        $entrada = Carbon::parse($registro->fecha_entrada);
        $salida = Carbon::now();
        $diff = $entrada->diff($salida);
        $horasTotales = $diff->days * 24 + $diff->h;
        $tiempoTrabajado = sprintf('%02d:%02d:%02d', $horasTotales, $diff->i, $diff->s);
        $tiempoTrabajadoSegundos = $entrada->diffInSeconds($salida);

        $horasTotales = $diff->days * 24 + $diff->h;
        $tiempoTrabajado = sprintf('%02d:%02d:%02d', $horasTotales, $diff->i, $diff->s);

        $registro->update([
            'tiempo_trabajado'          => $tiempoTrabajado,
            'tiempo_trabajado_segundos' => $tiempoTrabajadoSegundos,
            'fecha_salida'              => $salida,
            'foto'                      => "{$registro->foto},{$request->foto}",
            'latitude_salida'           => $request->latitude_salida,
            'longitude_salida'          => $request->longitude_salida,
            'ubicacion_salida'          => $request->ubicacion_salida,
            'comentarios_salida'        => $request->comentarios_salida
        ]);

        return response()->json(['message' => 'Check-out registrado correctamente']);
    }

    // Obtener último check-in abierto de un guardia
    public function ultimoCheckAbierto($guardiaId)
    {
        $registro = CheckGuardia::where('guardia_id', $guardiaId)
            ->whereNull('fecha_salida')
            ->latest('fecha_entrada')
            ->first();

        if($registro){
            return response()->json($registro);
        }else{
            return response()->json(['message' => 'No se encontraron registros'], 200);
        }
    }

    public function destroy($id)
    {
        $registro = CheckGuardia::find($id);

        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function createGuardiaEventual(Request $request)
    {
        $data = $request->validate([
            'nombre_guardia' => 'required|string',
            'orden_servicio_id' => 'required|exists:ordenes_servicios,id',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'ubicacion' => 'required|string',
            'comentarios' => 'nullable|string',
            'foto' => 'required|string'
        ]);

        // Verificar si hay un checkin abierto
        $checkAbierto = CheckGuardia::where('nombre_guardia', $request->nombre_guardia)
            ->whereNull('fecha_salida')
            ->latest()
            ->first();

        if ($checkAbierto) {
            return response()->json([
                'message' => 'Ya has realizado un check-in. Debes hacer check-out antes de registrar uno nuevo.',
                'check_id' => $checkAbierto->id,
                'fecha_entrada' => Carbon::parse($checkAbierto->fecha_entrada)->format('d/m/Y h:i:s A')
            ], 409);
        }

        $data['fecha_entarda'] = Carbon::now();
        $data['tipo_guardia'] = 'Eventual';

        $registro = CheckGuardia::create($data);
        return response()->json(['message' => 'Check-in registrado', 'id' => $registro->id], 201);
    }

    public function ultimoCheckAbiertoEventual($nombreGuardia)
    {
        $registro = CheckGuardia::where('nombre_guardia', $nombreGuardia)
            ->whereNull('fecha_salida')
            ->latest('fecha_entrada')
            ->first();

        if($registro){
            return response()->json($registro);
        }else{
            return response()->json(['message' => 'No se encontraron registros'], 200);
        }
    }

    public function generarReporteCheckGuardia($checkGuardiaId)
    {
        $checkGuardia = CheckGuardia::find($checkGuardiaId);

        if (!$checkGuardia) {
            return response()->json(['error' => 'Check Guardia no encontrado'], 404);
        }

        $fotos = explode(',', $checkGuardia->foto); // Separar las fotos si hay más de una
        $base64Fotos = [];

        foreach ($fotos as $foto) {
            $imageData = ImageHelper::get($foto);
            $base64Foto = base64_encode($imageData);
            $base64Fotos[] = 'data:image/jpeg;base64,' . $base64Foto;
        }

        $data = [
            'checkGuardia' => $checkGuardia,
            'base64Fotos' => $base64Fotos,
        ];

        $pdf = Pdf::loadView('pdf.reporte_check_guardia', $data)->setPaper('letter', 'portrait');

        $codigoOrden = $checkGuardia->orden_servicio->codigo_orden_servicio;
        $fileName = "Check-in_Check-out - Orden de servicio #{$codigoOrden}.pdf";

        return $pdf->stream($fileName);
    }

    public function reporteHorasTrabajadas(Request $request)
    {
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;
        $guardiaId = $request->guardia_id;

        $query = CheckGuardia::whereBetween('fecha_entrada', [$fechaInicio, $fechaFin])->where('guardia_id', $guardiaId);

        // SUMA total de segundos trabajados en el periodo
        $totalSegundos = $query->sum('tiempo_trabajado_segundos');

        $dias = floor($totalSegundos / 86400);
        $horas = floor(($totalSegundos % 86400) / 3600);
        $minutos = floor(($totalSegundos % 3600) / 60);
        $segundos = $totalSegundos % 60;

        // Armado del string: "x días, x horas, x minutos, x segundos"
        $partes = [];
        if ($dias > 0) $partes[] = "$dias día(s)";
        if ($horas > 0 || $dias > 0) $partes[] = "$horas hora(s)";
        if ($minutos > 0 || $horas > 0 || $dias > 0) $partes[] = "$minutos minuto(s)";
        $partes[] = "$segundos segundo(s)"; // Siempre se muestra

        $totalDetallado = implode(', ', $partes);

        return response()->json([
            'total_segundos' => $totalSegundos,
            'total_trabajado' => $totalDetallado,
        ]);
    }

    public function reporteHorasPDF(Request $request)
    {
        $request->validate([
            'guardia_id' => 'required|exists:guardias,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $guardia = Guardia::find($request->guardia_id);

        if (!$guardia) {
            return response()->json(['error' => 'Guardia no encontrado'], 404);
        }

        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;
        $guardiaId = $request->guardia_id;

        // Consulta guardia y registros
        $registros = CheckGuardia::where('guardia_id', $guardiaId)
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('created_at')
            ->get();

        // Total horas para mostrar
        $totalSegundos = $registros->sum('tiempo_trabajado_segundos');
        $total_horas = $totalSegundos / 3600;

        // Reutiliza tu formato
        $dias = floor($totalSegundos / 86400);
        $horas = floor(($totalSegundos % 86400) / 3600);
        $minutos = floor(($totalSegundos % 3600) / 60);
        $segundos = $totalSegundos % 60;
        $partes = [];
        if ($dias > 0) $partes[] = "$dias día(s)";
        if ($horas > 0 || $dias > 0) $partes[] = "$horas hora(s)";
        if ($minutos > 0 || $horas > 0 || $dias > 0) $partes[] = "$minutos minuto(s)";
        $partes[] = "$segundos segundo(s)";
        $totalDetallado = implode(', ', $partes);

        // Enriquecer cada registro
        $registros = $registros->map(function($registro) {
            $registro->orden_servicio = $registro->orden_servicio
                ? $registro->orden_servicio->codigo_orden_servicio
                : 'N/A';
            $registro->horas_trabajadas = $registro->tiempo_trabajado
                ? round($registro->tiempo_trabajado_segundos / 3600, 2)
                : 0;
            return $registro;
        });

        // Prepara data para blade
        $data = [
            'guardia' => $guardia,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'registros' => $registros,
            'total_horas' => $total_horas,
            'total_detallado' => $totalDetallado,
        ];

        $pdf = Pdf::loadView('pdf.reporte_horas_trabajadas', $data);

        return $pdf->stream('ReporteHoras_' . ($guardia->numero_empleado ?? 'guardia') . '.pdf');
    }
}
