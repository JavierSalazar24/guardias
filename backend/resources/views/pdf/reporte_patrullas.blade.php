@php
    use Carbon\Carbon;

@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Patrulla - Orden de servicio #{{ $reporte->orden_servicio->codigo_orden_servicio }}</title>
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

        .inspection-id {
            background-color: #e74c3c;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid white;
        }

        .form-section {
            border: 2px solid #1a365d;
            margin-bottom: 12px;
            background-color: white;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #1a365d;
            color: white;
            padding: 6px 12px;
            margin: 0;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-content {
            padding: 10px;
        }

        .field-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .field-table td {
            padding: 4px;
            border: 1px solid #bdc3c7;
            vertical-align: top;
            font-size: 9px;
        }

        .field-label {
            background-color: #ecf0f1;
            font-weight: bold;
            width: 25%;
            text-transform: uppercase;
        }

        .field-value {
            background-color: white;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
        }

        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #2c3e50;
            margin-bottom: 8px;
        }

        .checklist-table th {
            background-color: #2c3e50;
            color: white;
            padding: 4px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
        }

        .checklist-table td {
            padding: 4px;
            border: 1px solid #95a5a6;
            text-align: center;
            font-size: 9px;
        }

        .item-name {
            text-align: left !important;
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .status-buena {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
        }

        .status-mala {
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
        }

        .status-regular {
            background-color: #f39c12;
            color: white;
            font-weight: bold;
        }

        .status-true {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
        }

        .status-false {
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
        }

        .vehicle-diagram {
            text-align: center;
            background-color: #ecf0f1;
            padding: 10px;
            border: 1px solid #bdc3c7;
            margin: 8px 0;
        }

        .tire-grid {
            width: 100%;
            border-collapse: collapse;
            max-width: 400px;
            margin: 0 auto;
        }

        .tire-grid td {
            padding: 8px;
            text-align: center;
            border: 2px solid #2c3e50;
            background-color: white;
            font-size: 9px;
            font-weight: bold;
            vertical-align: middle;
            height: 50px;
        }

        .tire-front {
            color: white;
        }

        .tire-rear {
            color: white;
        }

        .tire-spare {
            color: white;
        }

        .tire-center {
            color: #2c3e50;
            font-weight: bold;
        }

        .mileage-section {
            background-color: #2c3e50;
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
            font-size: 8px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .signature-section {
            margin-top: 15px;
            border: 2px solid #2c3e50;
            background-color: white;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 33.33%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            text-align: center;
            vertical-align: bottom;
            height: 50px;
        }

        .signature-line {
            border-top: 1px solid #2c3e50;
            margin-top: 30px;
            padding-top: 5px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
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

        .code-section {
            background-color: #f8f9fa;
            border-left: 4px solid #e74c3c;
            padding: 6px;
            margin: 8px 0;
            font-family: 'Courier New', monospace;
            font-size: 8px;
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
                    <h1 class="main-title">INSPECCIÓN DE PATRULLA</h1>
                    <p class="sub-title">REPORTE DE SUPERVISIÓN VEHICULAR</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="form-section">
        <h2 class="section-title">[A] DATOS DE IDENTIFICACIÓN</h2>
        <div class="form-content">
            <table class="field-table">
                <tr>
                    <td class="field-label">SUPERVISOR</td>
                    <td class="field-value">{{ $reporte->guardia->nombre }} {{ $reporte->guardia->apellido_p }} {{ $reporte->guardia->apellido_m }}</td>
                    <td class="field-label">FECHA/HORA</td>
                    <td class="field-value">{{ now()->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="field-label">ORDEN SERVICIO</td>
                    <td class="field-value">{{ $reporte->orden_servicio->codigo_orden_servicio }}</td>
                    <td class="field-label">PLACAS</td>
                    <td class="field-value">{{ $reporte->datos_vehiculo['placas'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="field-label">RECIBIDO POR</td>
                    <td class="field-value">{{ $reporte->recibido_por ?? 'N/A' }}</td>
                    <td class="field-label">No. EMPLEADO</td>
                    <td class="field-value">{{ $reporte->guardia->numero_empleado }}</td>
                </tr>
                <tr>
                    <td class="field-label">LICENCIA MANEJO</td>
                    <td class="field-value">{{ $reporte->licencia_manejo ?? 'N/A' }}</td>
                    <td class="field-label">TARJETA COMBUSTIBLE</td>
                    <td class="field-value">{{ $reporte->tarjeta_combustible ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mileage-section">
        <table class="mileage-table">
            <tr>
                <td>
                    <div class="mileage-number">{{ $reporte->datos_vehiculo['kilometraje_inicial'] ?? 'N/A' }}</div>
                    <div class="mileage-label">KM INICIAL</div>
                </td>
                <td>
                    <div class="mileage-number">{{ $reporte->datos_vehiculo['kilometraje_final'] ?? 'N/A' }}</div>
                    <div class="mileage-label">KM FINAL</div>
                </td>
                <td>
                    <div class="mileage-number">
                        @if(isset($reporte->datos_vehiculo['kilometraje_final']) && isset($reporte->datos_vehiculo['kilometraje_inicial']))
                            {{ $reporte->datos_vehiculo['kilometraje_final'] - $reporte->datos_vehiculo['kilometraje_inicial'] }}
                        @else
                            N/A
                        @endif
                    </div>
                    <div class="mileage-label">KM RECORRIDOS</div>
                </td>
                <td>
                    <div class="mileage-number">{{ $reporte->datos_vehiculo['unidad_limpia'] ? 'LIMPIA' : 'SUCIA' }}</div>
                    <div class="mileage-label">ESTADO LIMPIEZA</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="form-section">
        <h2 class="section-title">[B] INSPECCIÓN DE NEUMÁTICOS</h2>
        <div class="form-content">
            <div class="vehicle-diagram">
                <table class="tire-grid">
                    <tr>
                        <td class="tire-front" style="width: 40%; background-color: #3498db;">
                            DELANTERA IZQUIERDA<br>
                            <strong>{{ $reporte->llantas['llanta_delantera_izquierda']['marca'] ?? 'N/A' }}</strong><br>
                            <i>Condición: {{ strtoupper($reporte->llantas['llanta_delantera_izquierda']['condicion'] ?? 'N/A') }}</i>
                        </td>
                        <td class="tire-center" style="width: 20%; background-color: #ecf0f1;">
                            FRENTE<br>
                            DEL<br>
                            VEHÍCULO
                        </td>
                        <td class="tire-front" style="width: 40%; background-color: #3498db;">
                            DELANTERA DERECHA<br>
                            <strong>{{ $reporte->llantas['llanta_delantera_derecha']['marca'] ?? 'N/A' }}</strong><br>
                            <i>Condición: {{ strtoupper($reporte->llantas['llanta_delantera_derecha']['condicion'] ?? 'N/A') }}</i>
                        </td>
                    </tr>
                    <tr>
                        <td class="tire-center" colspan="3" style="padding: 20px; background-color: #ecf0f1;">
                            <strong>[VEHÍCULO PATRULLA]</strong><br>
                            Placas: {{ $reporte->datos_vehiculo['placas'] ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tire-rear" style="background-color: #9b59b6;">
                            TRASERA IZQUIERDA<br>
                            <strong>{{ $reporte->llantas['llanta_trasera_izquierda']['marca'] ?? 'N/A' }}</strong><br>
                            <i>Condición: {{ strtoupper($reporte->llantas['llanta_trasera_izquierda']['condicion'] ?? 'N/A') }}</i>
                        </td>
                        <td class="tire-center" style="background-color: #ecf0f1;">
                            PARTE<br>
                            TRASERA
                        </td>
                        <td class="tire-rear" style="background-color: #9b59b6;">
                            TRASERA DERECHA<br>
                            <strong>{{ $reporte->llantas['llanta_trasera_derecha']['marca'] ?? 'N/A' }}</strong><br>
                            <i>Condición: {{ strtoupper($reporte->llantas['llanta_trasera_derecha']['condicion'] ?? 'N/A') }}</i>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="tire-spare" style="background-color: #95a5a6;">
                            LLANTA DE REFACCIÓN<br>
                            <strong>{{ $reporte->llantas['llanta_extra']['marca'] ?? 'N/A' }}</strong> -
                            <i>Condición: {{ strtoupper($reporte->llantas['llanta_extra']['condicion'] ?? 'N/A') }}</i>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[C] NIVELES DE FLUIDOS</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">FLUIDO</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">NIVEL AGUA BATERÍA</td>
                    <td class="status-{{ strtolower($reporte->niveles['nivel_agua_bateria'] ?? 'buena') }}">
                        {{ strtoupper($reporte->niveles['nivel_agua_bateria'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">NIVEL AGUA RADIADOR</td>
                    <td class="status-{{ strtolower($reporte->niveles['nivel_agua_radiador'] ?? 'buena') }}">
                        {{ strtoupper($reporte->niveles['nivel_agua_radiador'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">NIVEL ACEITE MOTOR</td>
                    <td class="status-{{ strtolower($reporte->niveles['nivel_aceite_motor'] ?? 'buena') }}">
                        {{ strtoupper($reporte->niveles['nivel_aceite_motor'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">NIVEL FRENOS</td>
                    <td class="status-{{ strtolower($reporte->niveles['nivel_frenos'] ?? 'buena') }}">
                        {{ strtoupper($reporte->niveles['nivel_frenos'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">NIVEL WIPERS</td>
                    <td class="status-{{ strtolower($reporte->niveles['nivel_wipers'] ?? 'buena') }}">
                        {{ strtoupper($reporte->niveles['nivel_wipers'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">NIVEL ACEITE TRANSMISIÓN</td>
                    <td class="status-{{ strtolower($reporte->niveles['nivel_aceite_transmision'] ?? 'buena') }}">
                        {{ strtoupper($reporte->niveles['nivel_aceite_transmision'] ?? 'N/A') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[D] INTERIOR DEL MOTOR</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">COMPONENTE</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">BATERÍA MARCA</td>
                    <td class="field-value">{{ $reporte->interior_motor['bateria_marca'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="item-name">TAPÓN ACEITE</td>
                    <td class="status-{{ $reporte->interior_motor['tapon_aceite'] ? 'true' : 'false' }}">
                        {{ $reporte->interior_motor['tapon_aceite'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">VARILLA MEDIDORA</td>
                    <td class="status-{{ $reporte->interior_motor['varilla_medidora'] ? 'true' : 'false' }}">
                        {{ $reporte->interior_motor['varilla_medidora'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">BANDAS VENTILADOR</td>
                    <td class="status-{{ $reporte->interior_motor['bandas_ventilador'] ? 'true' : 'false' }}">
                        {{ $reporte->interior_motor['bandas_ventilador'] ? 'BUENAS' : 'MALAS' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">CLAXON</td>
                    <td class="status-{{ $reporte->interior_motor['claxon'] ? 'true' : 'false' }}">
                        {{ $reporte->interior_motor['claxon'] ? 'FUNCIONA' : 'NO FUNCIONA' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[E] INTERIOR DEL VEHÍCULO</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 33%;">COMPONENTE</th>
                    <th style="width: 33%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">RADIO</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['radio'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['radio'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">GUANTERA</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['guantera'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['guantera'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">TAPICERÍA</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['tapiceria'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['tapiceria'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">ENCENDEDOR</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['encendedor'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['encendedor'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">LUZ INTERIOR</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['luz_interior'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['luz_interior'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">REJILLAS CLIMA</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['rejillas_clima'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['rejillas_clima'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">DESCANSABRAZOS</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['descansabrazos'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['descansabrazos'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">TAPETES</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['tapetes'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['tapetes'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">ESPEJO</td>
                    <td class="status-{{ strtolower($reporte->interior_vehiculo['espejo_retrovisor'] ?? 'buena') }}">
                        {{ strtoupper($reporte->interior_vehiculo['espejo_retrovisor'] ?? 'N/A') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[F] MARCADORES DEL TABLERO</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">MARCADOR</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">LUCES DIRECCIONALES</td>
                    <td class="status-{{ strtolower($reporte->marcadores_tablero['luces_direccionales'] ?? 'buena') }}">
                        {{ strtoupper($reporte->marcadores_tablero['luces_direccionales'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">A/C CALEFACCIÓN</td>
                    <td class="status-{{ strtolower($reporte->marcadores_tablero['ac_calefaccion'] ?? 'buena') }}">
                        {{ strtoupper($reporte->marcadores_tablero['ac_calefaccion'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">SWITCH IGNICIÓN</td>
                    <td class="status-{{ strtolower($reporte->marcadores_tablero['swicth_ignicion'] ?? 'buena') }}">
                        {{ strtoupper($reporte->marcadores_tablero['swicth_ignicion'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">INTERRUPTOR PARABRISAS</td>
                    <td class="status-{{ strtolower($reporte->marcadores_tablero['interrumptor_parabrisas'] ?? 'buena') }}">
                        {{ strtoupper($reporte->marcadores_tablero['interrumptor_parabrisas'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">VELOCÍMETRO</td>
                    <td class="status-{{ strtolower($reporte->marcadores_tablero['velocimetro'] ?? 'buena') }}">
                        {{ strtoupper($reporte->marcadores_tablero['velocimetro'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">MEDIDOR GASOLINA</td>
                    <td class="status-{{ strtolower($reporte->marcadores_tablero['medidor_gasolina'] ?? 'buena') }}">
                        {{ strtoupper($reporte->marcadores_tablero['medidor_gasolina'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">MEDIDOR TEMPERATURA</td>
                    <td class="status-{{ strtolower($reporte->marcadores_tablero['medidor_temperatura'] ?? 'buena') }}">
                        {{ strtoupper($reporte->marcadores_tablero['medidor_temperatura'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">MEDIDOR ACEITE</td>
                    <td class="status-{{ strtolower($reporte->marcadores_tablero['medidor_aceite'] ?? 'buena') }}">
                        {{ strtoupper($reporte->marcadores_tablero['medidor_aceite'] ?? 'N/A') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[G] HERRAMIENTAS Y EQUIPAMIENTO</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">HERRAMIENTA</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">HERRAMIENTAS</td>
                    <td class="status-{{ $reporte->herramientas['herramientas'] ? 'true' : 'false' }}">
                        {{ $reporte->herramientas['herramientas'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">GATO</td>
                    <td class="status-{{ $reporte->herramientas['gato'] ? 'true' : 'false' }}">
                        {{ $reporte->herramientas['gato'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">CRUCETAS</td>
                    <td class="status-{{ $reporte->herramientas['crucetas'] ? 'true' : 'false' }}">
                        {{ $reporte->herramientas['crucetas'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">PALANCA GATO</td>
                    <td class="status-{{ $reporte->herramientas['palanca_gato'] ? 'true' : 'false' }}">
                        {{ $reporte->herramientas['palanca_gato'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">TRIÁNGULOS</td>
                    <td class="status-{{ $reporte->herramientas['triangulos'] ? 'true' : 'false' }}">
                        {{ $reporte->herramientas['triangulos'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">EXTINTOR</td>
                    <td class="status-{{ $reporte->herramientas['extintor'] ? 'true' : 'false' }}">
                        {{ $reporte->herramientas['extintor'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[H] DOCUMENTACIÓN</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">DOCUMENTO</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">MANUAL VEHÍCULO</td>
                    <td class="status-{{ $reporte->documentacion['manual_vehiculo'] ? 'true' : 'false' }}">
                        {{ $reporte->documentacion['manual_vehiculo'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">PÓLIZA SEGURO</td>
                    <td class="status-{{ $reporte->documentacion['poliza_seguro'] ? 'true' : 'false' }}">
                        {{ $reporte->documentacion['poliza_seguro'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">PLACA DELANTERA</td>
                    <td class="status-{{ $reporte->documentacion['placa_delantera'] ? 'true' : 'false' }}">
                        {{ $reporte->documentacion['placa_delantera'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">PLACA TRASERA</td>
                    <td class="status-{{ $reporte->documentacion['placa_trasera'] ? 'true' : 'false' }}">
                        {{ $reporte->documentacion['placa_trasera'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">TORRETA</td>
                    <td class="status-{{ $reporte->documentacion['torreta'] ? 'true' : 'false' }}">
                        {{ $reporte->documentacion['torreta'] ? 'PRESENTE' : 'AUSENTE' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[I] CONDICIONES MECÁNICAS</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">SISTEMA</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">SISTEMA FRENOS</td>
                    <td class="status-{{ strtolower($reporte->condiciones_mecanicas['sistema_frenos'] ?? 'buena') }}">
                        {{ strtoupper($reporte->condiciones_mecanicas['sistema_frenos'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">SISTEMA CLUTCH</td>
                    <td class="status-{{ strtolower($reporte->condiciones_mecanicas['sistema_clutch'] ?? 'buena') }}">
                        {{ strtoupper($reporte->condiciones_mecanicas['sistema_clutch'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">SISTEMA SUSPENSIÓN</td>
                    <td class="status-{{ strtolower($reporte->condiciones_mecanicas['sistema_suspension'] ?? 'buena') }}">
                        {{ strtoupper($reporte->condiciones_mecanicas['sistema_suspension'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">SISTEMA MOTOR</td>
                    <td class="status-{{ strtolower($reporte->condiciones_mecanicas['sistema_motor'] ?? 'buena') }}">
                        {{ strtoupper($reporte->condiciones_mecanicas['sistema_motor'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">SISTEMA LUCES</td>
                    <td class="status-{{ strtolower($reporte->condiciones_mecanicas['sistema_luces'] ?? 'buena') }}">
                        {{ strtoupper($reporte->condiciones_mecanicas['sistema_luces'] ?? 'N/A') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[J] COSTADO DERECHO</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">COMPONENTE</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">CONDICIÓN GENERAL</td>
                    <td class="status-{{ strtolower($reporte->costado_derecho['condicion'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_derecho['condicion'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">VIDRIOS LATERALES</td>
                    <td class="status-{{ strtolower($reporte->costado_derecho['vidrios_laterales'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_derecho['vidrios_laterales'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">MANIJA</td>
                    <td class="status-{{ strtolower($reporte->costado_derecho['manija'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_derecho['manija'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">CERRADURAS</td>
                    <td class="status-{{ strtolower($reporte->costado_derecho['cerraduras'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_derecho['cerraduras'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">COPAS RUEDAS</td>
                    <td class="status-{{ strtolower($reporte->costado_derecho['copas_ruedas'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_derecho['copas_ruedas'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">TAPÓN GASOLINA</td>
                    <td class="status-{{ strtolower($reporte->costado_derecho['tapon_gasolina'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_derecho['tapon_gasolina'] ?? 'N/A') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[K] COSTADO IZQUIERDO</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">COMPONENTE</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">CONDICIÓN GENERAL</td>
                    <td class="status-{{ strtolower($reporte->costado_izquierda['condicion'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_izquierda['condicion'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">VIDRIOS LATERALES</td>
                    <td class="status-{{ strtolower($reporte->costado_izquierda['vidrios_laterales'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_izquierda['vidrios_laterales'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">MANIJA</td>
                    <td class="status-{{ strtolower($reporte->costado_izquierda['manija'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_izquierda['manija'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">CERRADURAS</td>
                    <td class="status-{{ strtolower($reporte->costado_izquierda['cerraduras'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_izquierda['cerraduras'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">COPAS RUEDAS</td>
                    <td class="status-{{ strtolower($reporte->costado_izquierda['copas_ruedas'] ?? 'buena') }}">
                        {{ strtoupper($reporte->costado_izquierda['copas_ruedas'] ?? 'N/A') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[L] LLAVES Y ACCESOS</h2>
        <div class="form-content">
            <table class="checklist-table">
                <tr>
                    <th style="width: 50%;">ACCESO</th>
                    <th style="width: 50%;">ESTADO</th>
                </tr>
                <tr>
                    <td class="item-name">LLAVES PUERTAS/CAJUELA</td>
                    <td class="status-{{ strtolower($reporte->llaves_accesos['llaves_puertas_cajuela'] ?? 'buena') }}">
                        {{ strtoupper($reporte->llaves_accesos['llaves_puertas_cajuela'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td class="item-name">LLAVE IGNICIÓN</td>
                    <td class="status-{{ strtolower($reporte->llaves_accesos['llave_ignicion'] ?? 'buena') }}">
                        {{ strtoupper($reporte->llaves_accesos['llave_ignicion'] ?? 'N/A') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-section">
        <h2 class="section-title">[M] OBSERVACIONES GENERALES</h2>
        <div class="form-content">
            <table class="field-table">
                <tr>
                    <td class="field-label">OBSERVACIONES</td>
                    <td class="field-value">{{ $reporte->observaciones ?? 'Sin observaciones adicionales' }}</td>
                </tr>
                <tr>
                    <td class="field-label">TARJETA CIRCULACIÓN</td>
                    <td class="field-value">{{ $reporte->datos_vehiculo['tarjeta_circulacion'] ?? 'N/A' }}</td>
                </tr>
            </table>
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
                    Generado: {{ now()->format('d/m/Y H:i:s') }} hrs.
                </td>
            </tr>
        </table>
    </div> --}}
</body>
</html>
