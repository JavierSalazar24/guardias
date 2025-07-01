@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Cuenta - Cliente {{ $data['cliente']['nombre_empresa'] }}</title>
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

        /* Client Info Card */
        .client-info {
            background: white;
            border: 2px solid #1a365d;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(26, 54, 93, 0.1);
        }

        .client-info-grid {
            display: table;
            width: 100%;
        }

        .client-info-row {
            display: table-row;
        }

        .client-info-cell {
            display: table-cell;
            padding: 8px 15px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .client-info-cell:first-child {
            background-color: #1a365d;
            color: white;
            font-weight: bold;
            width: 25%;
            text-align: center;
        }

        .client-info-cell:last-child {
            background-color: white;
            color: #2d3748;
        }

        /* Section Styles */
        .section {
            background: white;
            margin-bottom: 25px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(26, 54, 93, 0.08);
        }

        .section-break {
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

        /* Sucursal Header */
        .sucursal-header {
            background: #2c5282;
            color: white;
            padding: 12px 20px;
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
        }

        /* Contact Info */
        .contact-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .contact-row {
            margin-bottom: 8px;
        }

        .contact-row:last-child {
            margin-bottom: 0;
        }

        .contact-label {
            font-weight: bold;
            color: #1a365d;
            display: inline-block;
            width: 80px;
        }

        .contact-value {
            color: #2d3748;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
            font-size: 9px;
            table-layout: fixed;
        }

        .table thead {
            background: #2c5282;
            color: white;
        }

        .table th {
            padding: 8px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            border-right: 1px solid #4a90e2;
            word-wrap: break-word;
        }

        .table th:last-child {
            border-right: none;
        }

        .table td {
            padding: 6px 4px;
            text-align: center;
            font-size: 10px;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            word-wrap: break-word;
            overflow: hidden;
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
        }

        .amount.positive {
            color: #38a169;
        }

        .amount.negative {
            color: #e53e3e;
        }

        /* Status Badges */
        .badge {
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge.aceptada {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .badge.pendiente {
            background-color: #fef5e7;
            color: #744210;
        }

        .badge.rechazada {
            background-color: #fed7d7;
            color: #742a2a;
        }

        .badge.pagada {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .badge.vencida {
            background-color: #fed7d7;
            color: #742a2a;
        }

        .badge.cancelada {
            background-color: #e2e8f0;
            color: #4a5568;
        }

        /* Extra Info */
        .extra-info {
            background: #f0f4f8;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 15px;
            margin-top: 15px;
            font-size: 11px;
        }

        .extra-info-row {
            margin-bottom: 6px;
        }

        .extra-info-row:last-child {
            margin-bottom: 0;
        }

        .extra-info-label {
            font-weight: bold;
            color: #1a365d;
        }

        /* Summary Section */
        .resumen {
            background: #1a365d;
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 30px;
        }

        .resumen h2 {
            margin: 0 0 25px 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .summary-section {
            background: white;
            color: #2d3748;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: left;
        }

        .summary-section:last-child {
            margin-bottom: 0;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .summary-list li {
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
            display: table;
            width: 100%;
        }

        .summary-list li:last-child {
            border-bottom: none;
        }

        .summary-label {
            display: table-cell;
            font-weight: bold;
        }

        .summary-value {
            display: table-cell;
            text-align: right;
            font-family: 'Courier New', monospace;
            font-size: 16px;
        }

        .summary-value.success {
            color: #38a169;
        }

        .summary-value.danger {
            color: #e53e3e;
        }

        .summary-value.warning {
            color: #d69e2e;
        }

        .summary-value.highlight {
            background: #1a365d;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 30px 20px;
            color: #718096;
            font-style: italic;
        }

        .empty-state::before {
            content: "📋";
            display: block;
            font-size: 24px;
            margin-bottom: 10px;
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

        /* Table Column Widths */
        .cotizaciones-table th:nth-child(1) { width: 12%; }
        .cotizaciones-table th:nth-child(2) { width: 20%; }
        .cotizaciones-table th:nth-child(3) { width: 10%; }
        .cotizaciones-table th:nth-child(4) { width: 12%; }
        .cotizaciones-table th:nth-child(5) { width: 10%; }
        .cotizaciones-table th:nth-child(6) { width: 12%; }
        .cotizaciones-table th:nth-child(7) { width: 12%; }

        .ventas-table th:nth-child(1) { width: 10%; }
        .ventas-table th:nth-child(2) { width: 10%; }
        .ventas-table th:nth-child(3) { width: 10%; }
        .ventas-table th:nth-child(4) { width: 8%; }
        .ventas-table th:nth-child(5) { width: 10%; }
        .ventas-table th:nth-child(6) { width: 12%; }
        .ventas-table th:nth-child(7) { width: 8%; }
        .ventas-table th:nth-child(8) { width: 10%; }
        .ventas-table th:nth-child(9) { width: 10%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Estado de Cuenta del Cliente</h1>
        <div class="logo-container">
            <img src="{{ public_path('logo/logo.png') }}" alt="Logo de la empresa" class="logo" />
        </div>
        <div class="subtitle">
            <p><b>Cliente: </b>{{ $data['cliente']['nombre_empresa'] }}</p>
            <p><b>Período: </b>{{ Carbon::parse($data['periodo']['inicio'])->format('d/m/Y') }} al {{ Carbon::parse($data['periodo']['fin'])->format('d/m/Y') }}</p>
        </div>
    </div>

    @foreach($data['sucursales'] as $entry)
        <div class="section">
            <h3 class="section-header">🏢 {{ $entry['sucursal']['nombre_empresa'] }}</h3>
            <div class="section-content">
                <div class="contact-info">
                    <div class="contact-row">
                        <span class="contact-label">Dirección:</span>
                        <span class="contact-value">{{ $entry['sucursal']['calle'] }} {{ $entry['sucursal']['numero'] }}, {{ $entry['sucursal']['colonia'] }}, {{ $entry['sucursal']['municipio'] }}, {{ $entry['sucursal']['estado'] }} CP: {{ $entry['sucursal']['cp'] }}, {{ $entry['sucursal']['pais'] }}</span>
                    </div>
                    <div class="contact-row">
                        <span class="contact-label">Teléfono:</span>
                        <span class="contact-value">{{ $entry['sucursal']['telefono_empresa'] }} Ext: {{ $entry['sucursal']['extension_empresa'] }}</span>
                    </div>
                    <div class="contact-row">
                        <span class="contact-label">Contacto:</span>
                        <span class="contact-value">{{ $entry['sucursal']['nombre_contacto'] }}</span>
                    </div>
                </div>

                <div class="section-break">
                    <div class="sucursal-header">📋 Cotizaciones</div>
                    @if(count($entry['cotizaciones']) > 0)
                        <table class="table cotizaciones-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Servicios</th>
                                    <th>Guardias</th>
                                    <th>Subtotal</th>
                                    <th>Impuesto</th>
                                    <th>Total</th>
                                    <th>Aceptada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entry['cotizaciones'] as $cot)
                                    <tr>
                                        <td>{{ Carbon::parse($cot['fecha_servicio'])->format('d/m/Y') }}</td>
                                        <td>{{ $cot['servicios'] }}</td>
                                        <td>{{ $cot['cantidad_guardias'] }}</td>
                                        <td class="amount">${{ number_format($cot['subtotal'], 2) }}</td>
                                        <td>{{ $cot['impuesto'] }}%</td>
                                        <td class="amount">${{ number_format($cot['total'], 2) }}</td>
                                        <td><span class="badge {{ strtolower($cot['aceptada']) }}">{{ $cot['aceptada'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="extra-info">
                            <div class="extra-info-row">
                                <span class="extra-info-label">Jefe de turno:</span> {{ $cot['jefe_turno'] }} @if($cot['jefe_turno'] === 'SI') - ${{ number_format($cot['precio_jefe_turno'], 2) }} @endif
                            </div>
                            <div class="extra-info-row">
                                <span class="extra-info-label">Supervisor:</span> {{ $cot['supervisor'] }} @if($cot['supervisor'] === 'SI') - ${{ number_format($cot['precio_supervisor'], 2) }} @endif
                            </div>
                            <div class="extra-info-row">
                                <span class="extra-info-label">Requisitos de pago:</span> {{ $cot['requisitos_pago_cliente'] ?? 'No especificado' }}
                            </div>
                            <div class="extra-info-row">
                                <span class="extra-info-label">Soporte documental:</span> {{ $cot['soporte_documental'] }} @if(!empty($cot['observaciones_soporte_documental'])) - {{ $cot['observaciones_soporte_documental'] }} @endif
                            </div>
                            <div class="extra-info-row">
                                <span class="extra-info-label">Descuento:</span> {{ $cot['descuento_porcentaje'] ?? '0' }}%
                            </div>
                            <div class="extra-info-row">
                                <span class="extra-info-label">Costo extra:</span> ${{ $cot['costo_extra'] ?? '0' }}
                            </div>
                            <div class="extra-info-row">
                                <span class="extra-info-label">Notas:</span> {{ $cot['notas'] ?? 'Sin notas adicionales' }}
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            No hay cotizaciones en este periodo.
                        </div>
                    @endif
                </div>

                <div class="section-break">
                    <div class="sucursal-header" style="margin-top: 20px;">💰 Ventas</div>
                    @if(count($entry['ventas']) > 0)
                        <table class="table ventas-table">
                            <thead>
                                <tr>
                                    <th>Factura</th>
                                    <th>Emisión</th>
                                    <th>Vencimiento</th>
                                    <th>Días crédito</th>
                                    <th>Nota crédito</th>
                                    <th>Total</th>
                                    <th>Tipo</th>
                                    <th>Método</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entry['ventas'] as $venta)
                                    <tr>
                                        <td class="font-bold">{{ $venta['numero_factura'] ?? 'N/A' }}</td>
                                        <td>{{ Carbon::parse($venta['fecha_emision'])->format('d/m/Y') }}</td>
                                        <td>{{ $venta['fecha_vencimiento'] ? Carbon::parse($venta['fecha_vencimiento'])->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ $venta['tipo_pago'] === 'Crédito' ? ($venta['dias_credito'] ?? '-') : '-' }}</td>
                                        <td class="amount">{{ $venta['nota_credito'] }}</td>
                                        <td class="amount">${{ number_format($venta['total'], 2) }}</td>
                                        <td>{{ $venta['tipo_pago'] }}</td>
                                        <td>{{ $venta['metodo_pago'] }}</td>
                                        <td><span class="badge {{ strtolower($venta['estatus']) }}">{{ $venta['estatus'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            No hay ventas en este periodo.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <div class="section resumen">
        <h2>📊 Resumen General</h2>

        <div class="summary-section section-break">
            <div class="summary-title">Totales de Cotizaciones</div>
            <ul class="summary-list">
                <li>
                    <span class="summary-label">Aceptadas:</span>
                    <span class="summary-value success">{{ $data['resumen']['cotizaciones']['aceptadas'] }}</span>
                </li>
                <li>
                    <span class="summary-label">No aceptadas:</span>
                    <span class="summary-value danger">{{ $data['resumen']['cotizaciones']['no_aceptadas'] }}</span>
                </li>
                <li>
                    <span class="summary-label">Pendientes:</span>
                    <span class="summary-value warning">{{ $data['resumen']['cotizaciones']['pendientes'] }}</span>
                </li>
            </ul>
        </div>

        <div class="summary-section section-break">
            <div class="summary-title">Resumen de Ventas</div>
            <ul class="summary-list">
                <li>
                    <span class="summary-label">Pagadas:</span>
                    <span class="summary-value success">${{ number_format($data['resumen']['ventas']['pagadas'], 2) }}</span>
                </li>
                <li>
                    <span class="summary-label">Pendientes:</span>
                    <span class="summary-value danger">${{ number_format($data['resumen']['ventas']['pendientes'], 2) }}</span>
                </li>
                <li>
                    <span class="summary-label">Vencidas:</span>
                    <span class="summary-value danger">${{ number_format($data['resumen']['ventas']['vencidas'], 2) }}</span>
                </li>
                <li>
                    <span class="summary-label">Canceladas:</span>
                    <span class="summary-value warning">${{ number_format($data['resumen']['ventas']['canceladas'], 2) }}</span>
                </li>
                <li>
                    <span class="summary-label">Total Ventas:</span>
                    <span class="summary-value highlight">${{ number_format($data['resumen']['ventas']['total'], 2) }}</span>
                </li>
            </ul>
        </div>

        <div class="summary-section section-break">
            <div class="summary-title">Balance Financiero</div>
            <ul class="summary-list">
                <li>
                    <span class="summary-label">Total Pendiente por Pagar:</span>
                    <span class="summary-value danger">${{ number_format($data['resumen']['ventas']['pendientes'] + $data['resumen']['ventas']['vencidas'], 2) }}</span>
                </li>
                <li>
                    <span class="summary-label">Total Recibido (Ventas Pagadas):</span>
                    <span class="summary-value success">${{ number_format($data['resumen']['ventas']['pagadas'], 2) }}</span>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
