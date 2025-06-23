@php
    use Carbon\Carbon;

    // Configurar Carbon en español
    Carbon::setLocale('es');

    $guardiaNombre = $reporteIncidente->guardia->nombre ?? 'No disponible';
    $guardiaApellido = $reporteIncidente->guardia->apellido_p ?? 'No disponible';
    $guardiaApellidoMat = $reporteIncidente->guardia->apellido_m ?? 'No disponible';
    $guardiaNumEmpleado = $reporteIncidente->guardia->numero_empleado ?? 'No disponible';

    $fechaIncidente = Carbon::parse($reporteIncidente->fecha);
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Incidente - Orden de servicio #{{ $reporteIncidente->orden_servicio->codigo_orden_servicio }}</title>
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
        }

        .incident-section {
            background-color: white;
            border: 2px solid #e74c3c;
            margin-bottom: 15px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .section-header {
            background-color: #e74c3c;
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

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
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

        .priority-section {
            background-color: #f39c12;
            color: white;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
        }

        .priority-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .priority-grid td {
            width: 33.33%;
            padding: 10px;
            text-align: center;
            border: 2px solid #2c3e50;
        }

        .priority-box {
            background-color: #ecf0f1;
            color: #2c3e50;
            padding: 12px;
            border: 2px solid #34495e;
        }

        .priority-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #7f8c8d;
        }

        .priority-value {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pendiente {
            background-color: #e74c3c;
            color: white;
            border: 2px solid #c0392b;
        }

        .status-resuelto {
            background-color: #27ae60;
            color: white;
            border: 2px solid #229954;
        }

        .status-proceso {
            background-color: #f39c12;
            color: white;
            border: 2px solid #e67e22;
        }

        .incident-details {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
        }

        .details-header {
            font-weight: bold;
            color: #856404;
            margin-bottom: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .location-section {
            background-color: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            margin: 15px 0;
            page-break-inside: avoid;
        }

        .location-header {
            font-weight: bold;
            color: #0c5460;
            margin-bottom: 8px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .actions-section {
            background-color: #d4edda;
            border: 2px solid #28a745;
            margin: 15px 0;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .actions-header {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .actions-content {
            padding: 15px;
        }

        .text-area {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            padding: 12px;
            margin-bottom: 15px;
            font-size: 11px;
            line-height: 1.6;
            min-height: 60px;
            color: #495057;
        }

        .photo-section {
            background-color: white;
            border: 2px solid #6f42c1;
            margin: 15px 0;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .photo-header {
            background-color: #6f42c1;
            color: white;
            padding: 10px 15px;
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .photo-content {
            padding: 15px;
            text-align: center;
        }

        .photo-container {
            background-color: #f8f9fa;
            padding: 15px;
            border: 2px dashed #dee2e6;
            text-align: center;
        }

        .photo-container img {
            max-width: 400px;
            max-height: 300px;
            border: 3px solid #6f42c1;
            object-fit: cover;
        }

        .photo-label {
            margin-top: 10px;
            font-size: 10px;
            font-weight: bold;
            color: #6c757d;
            text-transform: uppercase;
        }

        .no-photo {
            color: #6c757d;
            font-style: italic;
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
        }

        .severity-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .severity-high {
            background-color: #e74c3c;
        }

        .severity-medium {
            background-color: #f39c12;
        }

        .severity-low {
            background-color: #27ae60;
        }

        .footer-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #34495e;
            color: white;
            text-align: center;
            font-size: 9px;
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

        .incident-id {
            background-color: #2c3e50;
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 10px;
            display: inline-block;
            margin-bottom: 10px;
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
                    <h1 class="main-title">Control de Incidencias</h1>
                    <p class="sub-title">Reporte de Incidente</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="incident-section">
        <h2 class="section-header">[A] Información del Guardia Reportante</h2>
        <div class="section-content">
            <table class="info-table">
                <tr>
                    <td class="info-label">Orden de Servicio</td>
                    <td class="info-value">{{ $reporteIncidente->orden_servicio->codigo_orden_servicio }}</td>
                    <td class="info-label">Estado del Incidente</td>
                    <td class="info-value">
                        @if ($reporteIncidente->estado === 'Pendiente')
                            <span class="status-badge status-pendiente">{{ $reporteIncidente->estado }}</span>
                        @elseif ($reporteIncidente->estado === 'En Proceso')
                            <span class="status-badge status-proceso">{{ $reporteIncidente->estado }}</span>
                        @else
                            <span class="status-badge status-resuelto">{{ $reporteIncidente->estado }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Nombre del Guardia</td>
                    <td class="info-value" colspan="3">{{ $guardiaNombre }} {{ $guardiaApellido }} {{ $guardiaApellidoMat }}</td>
                </tr>
                <tr>
                    <td class="info-label">Número de Empleado</td>
                    <td class="info-value">{{ $guardiaNumEmpleado }}</td>
                    <td class="info-label">Turno</td>
                    <td class="info-value">{{ $reporteIncidente->turno }}</td>
                </tr>
                <tr>
                    <td class="info-label">Punto de Vigilancia</td>
                    <td class="info-value" colspan="3">{{ $reporteIncidente->punto_vigilancia ?? 'No especificado' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="priority-section">
        <table class="priority-grid">
            <tr>
                <td>
                    <div class="priority-box">
                        <div class="priority-label">Fecha del Incidente</div>
                        <div class="priority-value">{{ $fechaIncidente->format('d/m/Y') }}</div>
                    </div>
                </td>
                <td>
                    <div class="priority-box">
                        <div class="priority-label">Hora del Incidente</div>
                        <div class="priority-value">{{ $fechaIncidente->format('H:i:s') }}</div>
                    </div>
                </td>
                <td>
                    <div class="priority-box">
                        <div class="priority-label">Día de la Semana</div>
                        <div class="priority-value">{{ $fechaIncidente->translatedFormat('l') }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="incident-section">
        <h2 class="section-header">[B] Detalles del Incidente</h2>
        <div class="section-content">
            <table class="info-table">
                <tr>
                    <td class="info-label">Tipo de Incidente</td>
                    <td class="info-value" colspan="3">{{ $reporteIncidente->incidente ?? 'No especificado' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Causa Identificada</td>
                    <td class="info-value" colspan="3">{{ $reporteIncidente->causa ?? 'No determinada' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Quién Reporta</td>
                    <td class="info-value" colspan="3">{{ $reporteIncidente->quien_reporta ?? 'No especificado' }}</td>
                </tr>
            </table>

            <div class="incident-details">
                <div class="details-header">Descripción Detallada del Incidente</div>
                <div class="text-area">{{ $reporteIncidente->descripcion ?? 'No se proporcionó descripción detallada' }}</div>
            </div>
        </div>
    </div>

    <div class="location-section">
        <div class="location-header">[C] Ubicación del Incidente</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Ubicación General</td>
                <td class="info-value">{{ $reporteIncidente->ubicacion ?? 'No especificada' }}</td>
            </tr>
            <tr>
                <td class="info-label">Lugar Específico</td>
                <td class="info-value">{{ $reporteIncidente->lugar_incidente ?? 'No especificado' }}</td>
            </tr>
        </table>
    </div>

    <div class="actions-section">
        <h2 class="actions-header">[D] Acciones y Recomendaciones</h2>
        <div class="actions-content">
            <div style="margin-bottom: 15px;">
                <div class="details-header">Acciones Tomadas Inmediatamente</div>
                <div class="text-area">{{ $reporteIncidente->acciones ?? 'No se registraron acciones específicas' }}</div>
            </div>

            <div>
                <div class="details-header">Recomendaciones para Prevención</div>
                <div class="text-area">{{ $reporteIncidente->recomendaciones ?? 'No se proporcionaron recomendaciones' }}</div>
            </div>
        </div>
    </div>

    <div class="photo-section">
        <h2 class="photo-header">[E] Evidencia Fotográfica</h2>
        <div class="photo-content">
            @if(isset($base64Foto) && $base64Foto)
                <div class="photo-container">
                    <img src="{{ $base64Foto }}" alt="Evidencia del Incidente">
                    <div class="photo-label">Evidencia Fotográfica del Incidente</div>
                </div>
            @else
                <div class="no-photo">
                    No se registró evidencia fotográfica para este incidente
                </div>
            @endif
        </div>
    </div>

    <div class="incident-section">
        <h2 class="section-header">[F] Resumen del Reporte</h2>
        <div class="section-content">
            <table class="info-table">
                <tr>
                    <td class="info-label">Fecha y Hora Completa</td>
                    <td class="info-value">{{ $fechaIncidente->format('d/m/Y H:i:s') }} - {{ $fechaIncidente->translatedFormat('d \d\e F \d\e Y') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tiempo Transcurrido</td>
                    <td class="info-value">{{ $fechaIncidente->diffForHumans() }}</td>
                </tr>
                <tr>
                    <td class="info-label">Prioridad del Caso</td>
                    <td class="info-value">
                        @if ($reporteIncidente->estado === 'Pendiente')
                            <strong style="color: #e74c3c;">ALTA - REQUIERE ATENCIÓN INMEDIATA</strong>
                        @elseif ($reporteIncidente->estado === 'En Proceso')
                            <strong style="color: #f39c12;">MEDIA - EN SEGUIMIENTO</strong>
                        @else
                            <strong style="color: #27ae60;">BAJA - CASO CERRADO</strong>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Seguimiento Requerido</td>
                    <td class="info-value">
                        {{ $reporteIncidente->estado === 'Resuelto' ? 'No requiere seguimiento adicional' : 'Requiere seguimiento y monitoreo' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
