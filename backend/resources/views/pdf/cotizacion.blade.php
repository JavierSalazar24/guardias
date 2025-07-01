@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización de {{ $cotizacion->nombre_empresa ?? $cotizacion->sucursal->nombre_empresa }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a202c;
            line-height: 1.4;
            margin: 0;
            padding: 10px;
            background-color: white;
        }

        /* Header Styles */
        .header {
            background: #1a365d;
            color: white;
            padding: 25px;
            margin: -20px -20px 30px -20px;
            text-align: center;
            border-bottom: 4px solid #2c5282;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .subtitle {
            margin-top: 8px;
            font-size: 14px;
            opacity: 0.9;
        }

        .logo-container {
            margin: 15px 0 10px 0;
            text-align: center;
        }

        .logo {
            max-height: 60px;
            max-width: 200px;
            height: auto;
            width: auto;
            border: 2px solid white;
            border-radius: 8px;
            background: white;
            padding: 5px;
        }

        /* Section Styles */
        .section {
            background: white;
            margin-bottom: 25px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(26, 54, 93, 0.08);
            page-break-inside: avoid;
        }

        .section-header {
            background: #1a365d;
            color: white;
            padding: 15px 20px;
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-content {
            padding: 20px;
        }

        /* Info Box Styles */
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin: 0;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #1a365d;
            width: 25%;
            padding-right: 15px;
            vertical-align: top;
        }

        .info-value {
            display: table-cell;
            color: #2d3748;
            vertical-align: top;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 0 0;
            background: white;
            font-size: 10px;
        }

        .table thead {
            background: #2c5282;
            color: white;
        }

        .table th {
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .table th:last-child {
            border-right: none;
        }

        .table td {
            padding: 10px 8px;
            text-align: center;
            font-size: 10px;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
        }

        .table td:last-child {
            border-right: none;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .table tbody tr:hover {
            background-color: #edf2f7;
        }

        /* Amount Styling */
        .amount {
            font-weight: bold;
            font-family: 'Courier New', monospace;
            color: #1a365d;
        }

        /* Total Table Styles */
        .total-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 0 0;
            background: white;
            font-size: 12px;
        }

        .total-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .total-table .total-label {
            background: #1a365d;
            color: white;
            font-weight: bold;
            text-align: right;
            width: 40%;
        }

        .total-table .total-value {
            background: #f8fafc;
            color: #2d3748;
            font-weight: bold;
        }

        .total-table .final-total .total-value {
            background: #173c70;
            color: white;
            font-size: 14px;
        }

        /* Service Details */
        .service-details {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .service-item {
            margin-bottom: 8px;
        }

        .service-item:last-child {
            margin-bottom: 0;
        }

        .service-label {
            font-weight: bold;
            color: #1a365d;
        }

        /* Notes Section */
        .notes-box {
            background: #f1f5fb;
            border: 1px solid #cdd5e0;
            border-left: 4px solid #3c6eb4;
            border-radius: 6px;
            padding: 20px;
            margin: 0;
            font-style: italic;
            color: #2d3748;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* Print Optimizations */
        @media print {
            body {
                background-color: white;
                padding: 10px;
            }

            .section {
                box-shadow: none;
                border: 1px solid #1a365d;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Cotización de Servicios</h1>
        <div class="logo-container">
            <img src="{{ public_path('logo/logo2.png') }}" alt="Logo de la empresa" class="logo" />
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">👤 Datos del Cliente</h3>
        <div class="section-content">
            <div class="info-box">
                @if($cotizacion->sucursal)
                    <div class="info-row">
                        <div class="info-label">Cliente:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->cliente->nombre_empresa }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Sucursal:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->nombre_empresa }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Contacto:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->nombre_contacto }} | {{ $cotizacion->sucursal->telefono_contacto }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Correo:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->correo_contacto }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Dirección:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->calle }} #{{ $cotizacion->sucursal->numero }}, {{ $cotizacion->sucursal->colonia }}, CP: {{ $cotizacion->sucursal->cp }}, {{ $cotizacion->sucursal->municipio }}, {{ $cotizacion->sucursal->estado }}, {{ $cotizacion->sucursal->pais}}.</div>
                    </div>
                @else
                    <div class="info-row">
                        <div class="info-label">Empresa:</div>
                        <div class="info-value">{{ $cotizacion->nombre_empresa }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Contacto:</div>
                        <div class="info-value">{{ $cotizacion->nombre_contacto }} | {{ $cotizacion->telefono_contacto }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Correo:</div>
                        <div class="info-value">{{ $cotizacion->correo_contacto }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Dirección:</div>
                        <div class="info-value">{{ $cotizacion->calle }} #{{ $cotizacion->numero }}, {{ $cotizacion->colonia }}, CP: {{ $cotizacion->cp }}, {{ $cotizacion->municipio }}, {{ $cotizacion->estado }}. {{ $cotizacion->pais }}.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">📋 Condiciones Comerciales</h3>
        <div class="section-content">
            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Días de Crédito:</div>
                    <div class="info-value">{{ $cotizacion->credito_dias }}</div>
                </div>
                @if($cotizacion->sucursal)
                    <div class="info-row">
                        <div class="info-label">Uso CFDI:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->uso_cfdi }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Régimen Fiscal:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->regimen_fiscal }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Razón Social:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->razon_social }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">RFC:</div>
                        <div class="info-value">{{ $cotizacion->sucursal->rfc }}</div>
                    </div>
                @else
                    <div class="info-row">
                        <div class="info-label">Uso CFDI:</div>
                        <div class="info-value">{{ $cotizacion->uso_cfdi }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Régimen Fiscal:</div>
                        <div class="info-value">{{ $cotizacion->regimen_fiscal }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Razón Social:</div>
                        <div class="info-value">{{ $cotizacion->razon_social }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">RFC:</div>
                        <div class="info-value">{{ $cotizacion->rfc }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">🛡️ Servicio Cotizado</h3>
        <div class="section-content">
            <div class="service-details">
                <div class="service-item">
                    <span class="service-label">Fecha del servicio:</span> {{ Carbon::parse($cotizacion->fecha_servicio)->format('d/m/Y') }}
                </div>
                <div class="service-item">
                    <span class="service-label">Servicios:</span> {{ $cotizacion->servicios }}
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo de Servicio</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Guardias de día</td>
                        <td>{{ $cotizacion->guardias_dia }}</td>
                        <td class="amount">${{ number_format($cotizacion->precio_guardias_dia, 2) }} MXN</td>
                        <td class="amount">${{ number_format($cotizacion->precio_guardias_dia_total, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td>Guardias de noche</td>
                        <td>{{ $cotizacion->guardias_noche }}</td>
                        <td class="amount">${{ number_format($cotizacion->precio_guardias_noche, 2) }} MXN</td>
                        <td class="amount">${{ number_format($cotizacion->precio_guardias_noche_total, 2) }} MXN</td>
                    </tr>
                    @if($cotizacion->jefe_turno === 'SI')
                        <tr>
                            <td>Jefe de turno</td>
                            <td>1</td>
                            <td class="amount">${{ number_format($cotizacion->precio_jefe_turno, 2) }} MXN</td>
                            <td class="amount">${{ number_format($cotizacion->precio_jefe_turno, 2) }} MXN</td>
                        </tr>
                    @endif
                    @if($cotizacion->supervisor === 'SI')
                        <tr>
                            <td>Supervisor</td>
                            <td>1</td>
                            <td class="amount">${{ number_format($cotizacion->precio_supervisor, 2) }} MXN</td>
                            <td class="amount">${{ number_format($cotizacion->precio_supervisor, 2) }} MXN</td>
                        </tr>
                    @endif
                    @if($cotizacion->costo_extra)
                        <tr>
                            <td>Otros Costos</td>
                            <td>1</td>
                            <td colspan="2" class="amount">${{ number_format($cotizacion->costo_extra, 2) }} MXN</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">💰 Resumen Financiero</h3>
        <div class="section-content">
            <table class="total-table">
                <tr>
                    <td class="total-label">Subtotal</td>
                    <td class="total-value amount">${{ number_format($cotizacion->subtotal, 2) }} MXN</td>
                </tr>
                <tr>
                    <td class="total-label">Costo Extra</td>
                    <td class="total-value amount">${{ number_format($cotizacion->costo_extra, 2) }} MXN</td>
                </tr>
                @if($cotizacion->costo_extra)
                    <tr>
                        <td class="total-label">Subtotal Ajustado</td>
                        <td class="total-value amount">${{ number_format($cotizacion->subtotal + $cotizacion->costo_extra, 2) }} MXN</td>
                    </tr>
                @endif
                <tr>
                    <td class="total-label">Descuento</td>
                    <td class="total-value">
                        @if($cotizacion->descuento_porcentaje)
                            {{ $cotizacion->descuento_porcentaje }}%
                        @else
                            0%
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="total-label">Impuesto (IVA)</td>
                    <td class="total-value">{{ $cotizacion->impuesto }}%</td>
                </tr>
                <tr class="final-total">
                    <td class="total-label">TOTAL FINAL</td>
                    <td class="total-value amount">${{ number_format($cotizacion->total, 2) }} MXN</td>
                </tr>
            </table>
        </div>
    </div>

    @if($cotizacion->notas)
        <div class="section">
            <h3 class="section-header">📝 Notas Adicionales</h3>
            <div class="section-content">
                <div class="notes-box">
                    {{ $cotizacion->notas }}
                </div>
            </div>
        </div>
    @endif
</body>
</html>
