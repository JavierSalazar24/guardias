@php
    use Carbon\Carbon;

    Carbon::setLocale('es');

    $nombre = $checkGuardia->nombre_guardia ?? "{$checkGuardia->guardia->nombre} {$checkGuardia->guardia->apellido_p} {$checkGuardia->guardia->apellido_m} ({$checkGuardia->guardia->numero_empleado})";
    $fechaEntrada = Carbon::parse($checkGuardia->fecha_entrada);
    $fechaSalida = $checkGuardia->fecha_salida ? Carbon::parse($checkGuardia->fecha_salida) : null;
    $tiempoTotal = $fechaSalida ? $fechaEntrada->diffAsCarbonInterval($fechaSalida) : null;

    $horasTotales = $tiempoTotal ? ($tiempoTotal->d * 24 + $tiempoTotal->h) : 0;
    $minutos      = $tiempoTotal ? str_pad($tiempoTotal->i, 2, '0', STR_PAD_LEFT) : '00';
    $segundos     = $tiempoTotal ? str_pad($tiempoTotal->s, 2, '0', STR_PAD_LEFT) : '00';
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Check-in/Check-out - Orden de servicio #{{ $checkGuardia->orden_servicio->codigo_orden_servicio }}</title>
    <style>
        @page {
            margin: 10mm;
            size: A4;
        }

        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 0;
            color: #1a1a1a;
            line-height: 1.3;
            font-size: 10px;
            background-color: #fafafa;
        }

        .inspection-header {
            border: 3px solid #2c3e50;
            background-color: #1a365d;
            color: white;
            padding: 15px;
            margin-bottom: 15px;
            text-align: center;
        }

        .header-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .header-grid td {
            padding: 5px;
            vertical-align: middle;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            background-color: rgba(255,255,255,0.1);
            text-align: center;
            line-height: 60px;
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .company-logo img {
            width: 90%;
        }

        .main-title {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-left: 20px;
        }

        .sub-title {
            font-size: 12px;
            margin: 5px 0 0 0;
            text-transform: uppercase;
            opacity: 0.9;
            margin-left: 20px;
        }

        .report-timestamp {
            background-color: #2c3e50;
            color: white;
            padding: 8px 15px;
            font-weight: bold;
            font-size: 11px;
            border: 2px solid #34495e;
            border-radius: 20px;
        }

        .status-section {
            background-color: white;
            border: 2px solid #34495e;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .section-header {
            background-color: #1a365d;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-content {
            padding: 15px;
        }

        .guard-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .guard-info-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        .info-label {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 30%;
            font-size: 10px;
            text-transform: uppercase;
            color: #495057;
        }

        .info-value {
            background-color: white;
            font-weight: bold;
            color: #2c3e50;
        }

        .time-tracking-section {
            background-color: #1a365d;
            color: white;
            padding: 20px;
            margin: 15px 0;
            text-align: center;
            border-radius: 8px;
            page-break-inside: avoid;
        }

        .time-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .time-grid td {
            width: 50%;
            padding: 15px;
            text-align: center;
        }

        .time-box {
            background-color: #ecf0f1;
            color: #2c3e50;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #34495e;
        }

        .time-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: bold;
            color: #7f8c8d;
        }

        .time-value {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .time-date {
            font-size: 12px;
            color: #34495e;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-completed {
            background-color: #cce5ff;
            color: #004085;
            border: 1px solid #99d6ff;
        }

        .location-section {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            page-break-inside: avoid;
        }

        .location-header {
            font-weight: bold;
            color: #856404;
            margin-bottom: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .coordinates-table {
            width: 100%;
            border-collapse: collapse;
        }

        .coordinates-table td {
            padding: 8px;
            border: 2px solid #856404;
            background-color: white;
            text-align: center;
        }

        .coord-label {
            background-color: #fff8dc;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            color: #856404;
        }

        .coord-value {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #2c3e50;
        }

        .comments-section {
            background-color: #e8f4fd;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin: 15px 0;
            border-radius: 0 8px 8px 0;
            page-break-inside: avoid;
        }

        .comments-header {
            font-weight: bold;
            color: #2980b9;
            margin-bottom: 8px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .comments-text {
            font-style: italic;
            color: #34495e;
            line-height: 1.5;
        }

        .photos-section {
            background-color: white;
            border: 2px solid #e74c3c;
            margin: 15px 0;
            border-radius: 8px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .photos-header {
            background-color: #e74c3c;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .photos-content {
            padding: 15px;
            text-align: center;
        }

        .photos-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .photos-grid td {
            padding: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        .photo-container {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
        }

        .photo-container img {
            width: 180px;
            height: 135px;
            border-radius: 6px;
            border: 2px solid #e74c3c;
            object-fit: cover;
        }

        .photo-label {
            margin-top: 8px;
            font-size: 10px;
            font-weight: bold;
            color: #6c757d;
            text-transform: uppercase;
        }

        .mileage-section {
            background-color: #1a365d;
            color: white;
            padding: 12px;
            text-align: center;
            margin: 12px 0;
        }

        .mileage-table {
            width: 100%;
            border-collapse: collapse;
        }

        .mileage-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .mileage-number {
            font-size: 16px;
            font-weight: bold;
            font-family: 'Arial', sans-serif;
        }

        .mileage-label {
            font-size: 12px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .footer-section {
            margin-top: 20px;
            padding: 5px;
            background-color: #1a365d;
            color: white;
            text-align: center;
            font-size: 9px;
            border-radius: 8px;
            page-break-inside: avoid;
        }

        .footer-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-grid td {
            padding: 5px;
        }

        .footer-logo {
            font-weight: bold;
            text-align: left;
        }

        .footer-confidential {
            text-align: center;
            font-style: italic;
        }

        .footer-page {
            text-align: right;
        }

        .no-photos {
            color: #6c757d;
            font-style: italic;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="inspection-header">
        <table class="header-grid">
            <tr>
                <td style="width: 60px;">
                    <div class="company-logo">
                        <img src="{{ public_path('logo/logo.png') }}" alt="Logo de la empresa">
                    </div>
                </td>
                <td>
                    <h1 class="main-title">Control de Asistencia</h1>
                    <p class="sub-title">Reporte de Check-in / Check-out</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="status-section">
        <h2 class="section-header">[A] Información del Guardia</h2>
        <div class="section-content">
            <table class="guard-info-table">
                <tr>
                    <td class="info-label">Orden de Servicio</td>
                    <td class="info-value">{{ $checkGuardia->orden_servicio->codigo_orden_servicio }}</td>
                    <td class="info-label">Estado del Turno</td>
                    <td class="info-value">
                        @if($checkGuardia->fecha_salida)
                            <span class="status-badge status-completed">Completado</span>
                        @else
                            <span class="status-badge status-active">En Servicio</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Nombre del Guardia</td>
                    <td class="info-value" colspan="3">{{ $nombre }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tipo de Guardia</td>
                    <td class="info-value">{{ $checkGuardia->tipo_guardia }}</td>
                    <td class="info-label">Número de Empleado</td>
                    <td class="info-value">{{ $checkGuardia->guardia->numero_empleado ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="status-section">
        <h2 class="section-header">[B] Resumen del Registro</h2>
        <div class="section-content">
            <table class="guard-info-table">
                <tr>
                    <td class="info-label">Fecha de Entrada</td>
                    <td class="info-value">{{ $fechaEntrada->format('d/m/Y H:i:s') }} - {{ $fechaEntrada->translatedFormat('l') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Fecha de Salida</td>
                    <td class="info-value">
                        @if($fechaSalida)
                            {{ $fechaSalida->format('d/m/Y H:i:s') }} - {{ $fechaSalida->translatedFormat('l') }}
                        @else
                            Turno en curso - Sin check-out registrado
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Duración del Turno</td>
                    <td class="info-value">
                        @if($tiempoTotal)
                            {{ $tiempoTotal->format('%d días, %H horas, %I minutos') }}
                        @else
                            Turno en progreso
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Estado Final</td>
                    <td class="info-value">
                        @if($checkGuardia->fecha_salida)
                            <strong style="color: #27ae60;">TURNO COMPLETADO</strong>
                        @else
                            <strong style="color: #e74c3c;">TURNO EN CURSO</strong>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mileage-section">
        <table class="mileage-table">
            <tr>
                <td>
                    <div class="mileage-number">{{ $tiempoTotal ? $horasTotales . ':' . $minutos . ':' . $segundos : 'N/A' }}</div>
                    <div class="mileage-label">Tiempo Total</div>
                </td>
                <td>
                    <div class="mileage-number">{{ $tiempoTotal ? $horasTotales : 'N/A' }}</div>
                    <div class="mileage-label">Horas Trabajadas</div>
                </td>
                <td>
                    <div class="mileage-number">
                         {{ $fechaEntrada->translatedFormat('l') }}
                    </div>
                    <div class="mileage-label">Día de la Semana</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="location-section">
        <div class="location-header">[C] Ubicación del guardia en Check-In</div>
        <table class="guard-info-table">
            <tr>
                <td class="info-label">Dirección</td>
                <td class="info-value" colspan="3">{{ $checkGuardia->ubicacion }}</td>
            </tr>
        </table>

        <table class="coordinates-table" style="margin-top: 10px;">
            <tr>
                <td class="coord-label">Coordenada</td>
                <td class="coord-label">Valor</td>
                <td class="coord-label">Precisión</td>
            </tr>
            <tr>
                <td class="coord-label">Latitud</td>
                <td class="coord-value">{{ $checkGuardia->latitude }}</td>
                <td class="coord-value">GPS</td>
            </tr>
            <tr>
                <td class="coord-label">Longitud</td>
                <td class="coord-value">{{ $checkGuardia->longitude }}</td>
                <td class="coord-value">GPS</td>
            </tr>
        </table>
    </div>

    @if($checkGuardia->ubicacion_salida && $checkGuardia->latitude_salida && $checkGuardia->longitude_salida)
        <div class="location-section">
            <div class="location-header">[D] Ubicación del guardia en Check-Out</div>
            <table class="guard-info-table">
                <tr>
                    <td class="info-label">Dirección</td>
                    <td class="info-value" colspan="3">{{ $checkGuardia->ubicacion_salida }}</td>
                </tr>
            </table>

            <table class="coordinates-table" style="margin-top: 10px;">
                <tr>
                    <td class="coord-label">Coordenada</td>
                    <td class="coord-label">Valor</td>
                    <td class="coord-label">Precisión</td>
                </tr>
                <tr>
                    <td class="coord-label">Latitud</td>
                    <td class="coord-value">{{ $checkGuardia->latitude_salida }}</td>
                    <td class="coord-value">GPS</td>
                </tr>
                <tr>
                    <td class="coord-label">Longitud</td>
                    <td class="coord-value">{{ $checkGuardia->longitude_salida }}</td>
                    <td class="coord-value">GPS</td>
                </tr>
            </table>
        </div>
    @endif

    @if($checkGuardia->comentarios)
        <div class="comments-section">
            <div class="comments-header">[E] Observaciones en Check-In</div>
            <div class="comments-text">{{ $checkGuardia->comentarios }}</div>
        </div>
    @endif

    @if($checkGuardia->comentarios_salida)
        <div class="comments-section">
            <div class="comments-header">[F] Observaciones en Check-Out</div>
            <div class="comments-text">{{ $checkGuardia->comentarios_salida }}</div>
        </div>
    @endif

    <div class="photos-section">
        <h2 class="photos-header">[G] Evidencia Fotográfica</h2>
        <div class="photos-content">
            @if(isset($base64Fotos) && count($base64Fotos) > 0)
                <table class="photos-grid">
                    <tr>
                        @foreach($base64Fotos as $index => $foto)
                            @if($index % 2 == 0 && $index > 0)
                                </tr><tr>
                            @endif
                            <td style="width: 50%;">
                                <div class="photo-container">
                                    <img src="{{ $foto }}" alt="Evidencia {{ $index + 1 }}">
                                    <div class="photo-label">Evidencia {{ $index + 1 }}</div>
                                </div>
                            </td>
                        @endforeach
                        @if(count($base64Fotos) % 2 == 1)
                            <td style="width: 50%;"></td>
                        @endif
                    </tr>
                </table>
            @else
                <div class="no-photos">
                    No se registraron fotografías para este check-in/check-out
                </div>
            @endif
        </div>
    </div>

    {{-- <div class="footer-section">
        <table class="footer-grid">
            <tr>
                <td class="footer-logo">
                    <strong>GRUPO PROEJE</strong>
                </td>
                <td class="footer-confidential">
                    DOCUMENTO CONFIDENCIAL - USO INTERNO
                </td>
                <td class="footer-page">
                    Generado: {{ Carbon::now()->format('d/m/Y H:i:s') }}
                </td>
            </tr>
        </table>
    </div> --}}
</body>
</html>
