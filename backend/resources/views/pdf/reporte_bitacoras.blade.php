@php
    use Carbon\Carbon;
    $nombre = "{$reporte->guardia->nombre} {$reporte->guardia->apellido_p} {$reporte->guardia->apellido_m}";
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Bitácora - Orden de servicio #{{ $reporte->orden_servicio->codigo_orden_servicio }}</title>
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

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-header {
            background-color: #ecf0f1;
            border-left: 4px solid #3498db;
            padding: 12px 15px;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 14px;
            color: #2c3e50;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 8px;
        }

        .info-card {
            background-color: #ffffff;
            border: 1px solid #bdc3c7;
            padding: 15px;
            margin-bottom: 8px;
            min-height: 50px;
        }

        .info-label {
            font-weight: bold;
            color: #7f8c8d;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 15px;
            color: #2c3e50;
            font-weight: bold;
        }

        .employee-number {
            font-size: 12px;
            color: #3d3d3d;
            margin-top: 2px;
        }

        .stats-section {
            background-color: #34495e;
            color: white;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stats-table td {
            width: 25%;
            padding: 12px;
            text-align: center;
            background-color: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .stat-number {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 4px;
            font-family: 'Arial', sans-serif;
        }

        .stat-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .time-section {
            background-color: #ecf0f1;
            padding: 15px;
            margin-top: 15px;
        }

        .time-table {
            width: 100%;
            border-collapse: collapse;
        }

        .time-table td {
            width: 33.33%;
            text-align: center;
            padding: 10px;
            background-color: white;
            border: 1px solid #bdc3c7;
        }

        .time-label {
            font-size: 9px;
            color: #7f8c8d;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 4px;
            font-family: 'Arial', sans-serif;
        }

        .time-value {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            font-family: 'Arial', sans-serif;
        }

        .guards-container {
            background-color: #f8f9fa;
            padding: 15px;
        }

        .guard-card {
            background-color: white;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .guard-header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 8px;
        }

        .guard-header-table td {
            vertical-align: middle;
            padding-bottom: 8px;
        }

        .guard-avatar {
            width: 40px;
            height: 40px;
            background-color: #6c5ce7;
            color: white;
            text-align: center;
            line-height: 40px;
            font-weight: bold;
            font-size: 14px;
            margin-right: 12px;
        }

        .guard-name {
            font-size: 13px;
            color: #2c3e50;
            font-weight: bold;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .guard-employee {
            font-size: 11px;
            color: #6c757d;
            margin: 2px 0 0 0;
        }

        .badges-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Arial', sans-serif;
        }

        .badges-table td {
            padding: 3px;
            width: 25%;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            text-transform: capitalize;
            width: 90%;
            text-align: center;
            border: 1px solid;
        }

        .badge-yes {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .badge-no {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .badge-icon {
            margin-right: 4px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 10px;
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
            color: #495057;
            text-align: left;
        }

        .footer-date {
            text-align: right;
        }

        .footer-disclaimer {
            margin-top: 8px;
            font-size: 9px;
            font-style: italic;
        }

        /* Espaciado mejorado */
        .spacer {
            height: 10px;
        }

        /* Bordes redondeados simulados con caracteres */
        .corner-decoration {
            font-size: 8px;
            color: #bdc3c7;
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
                    <h1 class="main-title">BITACORA DE SUPERVISOR</h1>
                    <p class="sub-title">REPORTE DE BITÁCORA</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-header">
            [A] INFORMACIÓN GENERAL DEL SERVICIO
        </div>

        <table class="info-table">
            <tr>
                <td>
                    <div class="info-card">
                        <div class="info-label">Supervisor Responsable</div>
                        <div class="info-value">{{ $reporte->guardia->nombre }} {{ $reporte->guardia->apellido_p }} {{ $reporte->guardia->apellido_m }}</div>
                        <div class="employee-number">
                            Empleado: {{ $reporte->guardia->numero_empleado }}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="info-card">
                        <div class="info-label">Orden de Servicio</div>
                        <div class="info-value">{{ $reporte->orden_servicio->codigo_orden_servicio }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="info-card">
                        <div class="info-label">Patrulla Asignada</div>
                        <div class="info-value">{{ $reporte->patrulla }}</div>
                    </div>
                </td>
                <td>
                    <div class="info-card">
                        <div class="info-label">Zona de Cobertura</div>
                        <div class="info-value">{{ $reporte->zona }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="stats-section">
            <table class="stats-table">
                <tr>
                    <td>
                        <div class="stat-number">{{ $reporte->kilometraje}}</div>
                        <div class="stat-label">Kilómetros Recorridos</div>
                    </td>
                    <td>
                        <div class="stat-number">{{ $reporte->litros_carga}}</div>
                        <div class="stat-label">Litros Combustible</div>
                    </td>
                    <td>
                        <div class="stat-number">{{ count($reporte->guardias ?? [])}}</div>
                        <div class="stat-label">Personal Asignado</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="time-section">
            <table class="time-table">
                <tr>
                    <td>
                        <div class="time-label">Fecha del recorrido</div>
                        <div class="time-value">{{ Carbon::parse($reporte->fecha)->format('d/m/Y') }}</div>
                    </td>
                    <td>
                        <div class="time-label">Hora de Inicio del recorrido</div>
                        <div class="time-value">{{ Carbon::parse($reporte->hora_inicio_recorrido)->format('h:i:s A') }}</div>
                    </td>
                    <td>
                        <div class="time-label">Hora de Finalización del recorrido</div>
                        <div class="time-value">{{ Carbon::parse($reporte->hora_fin_recorrido)->format('h:i:s A') }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
           [B] PERSONAL DE SEGURIDAD ASIGNADO
        </div>

        <div class="guards-container">
            @if(isset($reporte->guardias))
                @foreach($reporte->guardias as $index => $guardia)
                    <div class="guard-card">
                        <table class="guard-header-table">
                            <tr>
                                <td>
                                    <h4 class="guard-name">{{ $guardia['nombre_guardia'] }}</h4>
                                    <p class="guard-employee">Empleado #{{ $guardia['numero_empleado'] }}</p>
                                </td>
                            </tr>
                        </table>

                        <table class="badges-table">
                            @if(isset($guardia['items']))
                                @php
                                    $items = array_chunk($guardia['items'], 4, true);
                                @endphp
                                @foreach($items as $row)
                                    <tr>
                                        @foreach($row as $key => $value)
                                            <td>
                                                <span class="badge {{ $value ? 'badge-yes' : 'badge-no' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                </span>
                                            </td>
                                        @endforeach
                                        @for($i = count($row); $i < 4; $i++)
                                            <td></td>
                                        @endfor
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                @endforeach
            @else
                <p>SIN ASIGNACIONES</p>
            @endif
        </div>
    </div>
</body>
</html>
