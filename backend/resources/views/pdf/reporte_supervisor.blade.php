@php
    use Carbon\Carbon;
    $guardiaNombre = $reporteSupervisor->guardia->nombre ?? 'No disponible';
    $guardiaApellido = $reporteSupervisor->guardia->apellido_p ?? 'No disponible';
    $guardiaApellidoMat = $reporteSupervisor->guardia->apellido_m ?? 'No disponible';
    $guardiaNumEmpleado = $reporteSupervisor->guardia->numero_empleado ?? 'No disponible';
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Supervisor - Orden de servicio #{{ $reporteSupervisor->orden_servicio->codigo_orden_servicio }}</title>
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

        .form-section {
            border: 2px solid #1a365d;
            margin-bottom: 15px;
            background-color: white;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #1a365d;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-content {
            padding: 15px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        .info-label {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 25%;
            font-size: 10px;
            text-transform: uppercase;
            color: #495057;
        }

        .info-value {
            background-color: white;
            font-weight: bold;
            color: #2c3e50;
        }

        .equipment-section {
            border: 2px solid #e67e22;
            margin-bottom: 15px;
            background-color: white;
            page-break-inside: avoid;
        }

        .equipment-header {
            background-color: #e67e22;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .projection-section {
            border: 2px solid #3498db;
            margin-bottom: 15px;
            background-color: white;
            page-break-inside: avoid;
        }

        .projection-header {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .projection-item {
            background-color: #ebf3fd;
            border: 1px solid #d6eaf8;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
        }

        .projection-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .projection-grid td {
            padding: 6px 10px;
            border: 1px solid #d6eaf8;
            font-size: 10px;
            vertical-align: top;
        }

        .projection-label {
            background-color: #d6eaf8;
            font-weight: bold;
            color: #2980b9;
            text-transform: uppercase;
            font-size: 9px;
            width: 30%;
        }

        .projection-value {
            background-color: white;
            color: #2c3e50;
            font-weight: 600;
        }

        .consignas-section {
            border: 2px solid #27ae60;
            margin-bottom: 15px;
            background-color: white;
            page-break-inside: avoid;
        }

        .consignas-header {
            background-color: #27ae60;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .consigna-item {
            background-color: #eafaf1;
            border-left: 4px solid #27ae60;
            padding: 12px 16px;
            margin: 10px 15px;
            border-radius: 0 6px 6px 0;
        }

        .time-badge {
            background-color: #27ae60;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 8px;
            display: inline-block;
            text-transform: uppercase;
        }

        .consigna-text {
            color: #2c3e50;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
        }

        .observations-section {
            border: 2px solid #f39c12;
            margin-bottom: 15px;
            background-color: white;
            page-break-inside: avoid;
        }

        .observations-header {
            background-color: #f39c12;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .observation-item {
            background-color: #fef9e7;
            border-left: 4px solid #f39c12;
            padding: 12px 16px;
            margin: 10px 15px;
            border-radius: 0 6px 6px 0;
        }

        .observation-badge {
            background-color: #f39c12;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 8px;
            display: inline-block;
            text-transform: uppercase;
        }

        .observation-text {
            color: #2c3e50;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
        }

        .stats-section {
            background-color: #34495e;
            color: white;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
            page-break-inside: avoid;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stats-table td {
            width: 25%;
            padding: 10px;
            text-align: center;
            background-color: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
            font-family: 'Arial', sans-serif;
        }

        .stat-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .no-data-message {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-style: italic;
            font-size: 11px;
            margin: 10px 15px;
        }

        .footer-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #1a365d;
            color: white;
            text-align: center;
            font-size: 9px;
            page-break-inside: avoid;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
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
                    <h1 class="main-title">REPORTE DE SUPERVISOR</h1>
                    <p class="sub-title">SUPERVISOR</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="form-section">
        <h2 class="section-title">[A] INFORMACIÓN DEL SUPERVISOR</h2>
        <div class="form-content">
            <table class="info-table">
                <tr>
                    <td class="info-label">Orden de Servicio</td>
                    <td class="info-value">{{ $reporteSupervisor->orden_servicio->codigo_orden_servicio ?? 'N/A' }}</td>
                    <td class="info-label">Número de Empleado</td>
                    <td class="info-value">{{ $guardiaNumEmpleado }}</td>
                </tr>
                <tr>
                    <td class="info-label">Supervisor Responsable</td>
                    <td class="info-value">{{ $guardiaNombre }} {{ $guardiaApellido }} {{ $guardiaApellidoMat }}</td>
                    <td class="info-label">Zona Asignada</td>
                    <td class="info-value">{{ $reporteSupervisor->zona ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Turno</td>
                    <td class="info-value">{{ $reporteSupervisor->turno ?? 'N/A' }}</td>
                    <td class="info-label">Fecha del Reporte</td>
                    <td class="info-value">{{ Carbon::parse($reporteSupervisor->fecha ?? now())->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="equipment-section">
        <h2 class="equipment-header">[B] TRANSFERENCIA DE EQUIPAMIENTO</h2>
        <div class="form-content">
            <table class="info-table">
                <tr>
                    <td class="info-label">Personal que Entrega</td>
                    <td class="info-value" colspan="3">{{ $reporteSupervisor->quien_entrega ?? 'No especificado' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Personal que Recibe</td>
                    <td class="info-value" colspan="3">{{ $reporteSupervisor->quien_recibe ?? 'No especificado' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="projection-section">
        <h2 class="projection-header">[C] PROYECCIÓN</h2>
        <div class="form-content">
            @if($reporteSupervisor->proyeccion && count($reporteSupervisor->proyeccion) > 0)
                @foreach($reporteSupervisor->proyeccion as $index => $item)
                    <div class="projection-item">
                        <strong style="color: #2980b9; font-size: 11px;">PROYECCIÓN {{ $index + 1 }}</strong>
                        <br>
                        <br>
                        <table class="projection-grid">
                            <tr>
                                <td class="projection-label">Cubre</td>
                                <td class="projection-value">{{ $item['cubre'] ?? 'No disponible' }}</td>
                            </tr>
                            <tr>
                                <td class="projection-label">Faltas</td>
                                <td class="projection-value">{{ $item['faltas'] ?? 'No disponible' }}</td>
                            </tr>
                            <tr>
                                <td class="projection-label">Servicio</td>
                                <td class="projection-value">{{ $item['servicio'] ?? 'No disponible' }}</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @else
                <div class="no-data-message">
                    No se registraron proyecciones de servicios para este turno
                </div>
            @endif
        </div>
    </div>

    <div class="consignas-section">
        <h2 class="consignas-header">[D] CONSIGNAS</h2>
        <div class="form-content">
            @if($reporteSupervisor->consignas && count($reporteSupervisor->consignas) > 0)
                @foreach($reporteSupervisor->consignas as $index => $consigna)
                    <div class="consigna-item">
                        <div class="time-badge">{{ $consigna['hora'] ?? 'N/A' }} HRS</div>
                        <p class="consigna-text">
                            <strong>CONSIGNA {{ $index + 1 }}:</strong> {{ $consigna['texto'] ?? 'Sin descripción' }}
                        </p>
                    </div>
                @endforeach
            @else
                <div class="no-data-message">
                    No se registraron consignas durante este turno de supervisión
                </div>
            @endif
        </div>
    </div>

    <div class="observations-section">
        <h2 class="observations-header">[E] OBSERVACIONES</h2>
        <div class="form-content">
            @if($reporteSupervisor->observaciones && count($reporteSupervisor->observaciones) > 0)
                @foreach($reporteSupervisor->observaciones as $index => $observacion)
                    <div class="observation-item">
                        <div class="observation-badge">{{ $observacion['hora'] ?? 'N/A' }} HRS</div>
                        <p class="observation-text">
                            <strong>OBSERVACIÓN {{ $index + 1 }}:</strong> {{ $observacion['texto'] ?? 'Sin descripción' }}
                        </p>
                    </div>
                @endforeach
            @else
                <div class="no-data-message">
                    No se registraron observaciones durante este turno de supervisión
                </div>
            @endif
        </div>
    </div>
</body>
</html>
