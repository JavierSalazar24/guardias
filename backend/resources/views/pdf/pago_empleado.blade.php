@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago</title>
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

        /* Employee Info Card */
        .employee-info {
            background: white;
            border: 2px solid #1a365d;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(26, 54, 93, 0.1);
            text-align: center;
        }

        .employee-name {
            font-size: 18px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 8px;
        }

        .employee-number {
            font-size: 14px;
            color: #4a5568;
            margin-bottom: 15px;
        }

        .period-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            display: inline-block;
        }

        .period-label {
            font-weight: bold;
            color: #1a365d;
        }

        .period-dates {
            color: #2d3748;
            font-family: 'Courier New', monospace;
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
            color: white;
            padding: 15px 20px;
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-header.ingresos {
            background: #38a169;
        }

        .section-header.egresos {
            background: #e53e3e;
        }

        .section-header.retenciones {
            background: #d69e2e;
        }

        .section-header.resumen {
            background: #1a365d;
        }

        .section-header.observaciones {
            background: #2c5282;
        }

        .section-content {
            padding: 20px;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background: white;
            font-size: 12px;
        }

        .table th {
            background: #f8fafc;
            color: #1a365d;
            padding: 12px 15px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .table .concept-cell {
            color: #2d3748;
            font-weight: 700;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }

        .table .amount-cell {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #1a365d;
            font-size: 15px;
        }

        .table .total-row {
            background: #f0f4f8;
            border-top: 2px solid #cbd5e0;
        }

        .table .total-row .concept-cell {
            font-weight: 700;
            color: #1a365d;
            text-transform: uppercase;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            letter-spacing: 0.3px;
        }

        .table .total-row .amount-cell {
            font-size: 17px;
            color: #1a365d;
        }

        /* Summary Table Special Styling */
        .summary-table {
            font-size: 14px;
        }

        .summary-table .concept-cell {
            font-family: 'DejaVu Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-table .amount-cell {
            font-size: 14px;
            font-weight: bold;
        }

        .summary-table .final-pay {
            background: #1a365d;
            color: white;
        }

        .summary-table .final-pay .concept-cell {
            color: white;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .summary-table .final-pay .amount-cell {
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        /* Summary Cards */
        .summary-cards {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 15px 0;
        }

        .summary-card {
            display: table-cell;
            text-align: center;
            padding: 25px 15px;
            border-radius: 12px;
            margin: 0 10px;
            box-shadow: 0 4px 12px rgba(26, 54, 93, 0.15);
        }

        .summary-card.bruto {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px solid #cbd5e0;
            width: 50%;
        }

        .summary-card.final {
            background: #1a365d;
            color: white;
            width: 50%;
            position: relative;
        }

        .summary-card.final .summary-card-label {
            color: white;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .summary-card.final .summary-card-amount {
            color: white;
            font-size: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .summary-card.final .summary-card-note {
            color: white;
            opacity: 0.9;
        }

        .summary-card-label {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            opacity: 0.9;
        }

        .summary-card-amount {
            font-family: 'Courier New', monospace;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #1a365d;
        }

        .summary-card-note {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            font-style: italic;
            opacity: 0.8;
            margin-top: 8px;
        }

        .summary-card.bruto .summary-card-amount {
            color: #4a5568;
        }

        .summary-card.bruto .summary-card-label {
            color: #2d3748;
        }

        /* Observations */
        .observations-content {
            background: #f0f4f8;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 20px;
            font-style: italic;
            color: #4a5568;
            line-height: 1.6;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-container {
            display: table;
            width: 100%;
            margin-top: 30px;
        }

        .signature-box {
            display: table-cell;
            width: 45%;
            text-align: center;
            vertical-align: bottom;
        }

        .signature-box:first-child {
            padding-right: 5%;
        }

        .signature-box:last-child {
            padding-left: 5%;
        }

        .signature-line {
            border-bottom: 2px solid #1a365d;
            height: 60px;
            margin-bottom: 10px;
            position: relative;
        }

        .signature-label {
            font-weight: bold;
            color: #1a365d;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .signature-sublabel {
            color: #4a5568;
            font-size: 10px;
            margin-top: 5px;
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

            .signature-section {
                page-break-before: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Comprobante de Pago</h1>
        <div class="logo-container">
            <img src="{{ public_path('logo/logo2.png') }}" alt="Logo de la empresa" class="logo" />
        </div>
        <div class="subtitle">Recibo de Nómina</div>
    </div>

    <div class="employee-info">
        <div class="employee-name">
            {{ $pago->guardia->nombre }} {{ $pago->guardia->apellido_p }} {{ $pago->guardia->apellido_m }}
        </div>
        <div class="employee-number">
            Número de Empleado: {{ $pago->guardia->numero_empleado }}
        </div>
        <div class="period-info">
            <span class="period-label">Período de Pago:</span><br>
            <span class="period-dates">{{ Carbon::parse($pago->periodo_inicio)->format('d/m/Y') }} - {{ Carbon::parse($pago->periodo_fin)->format('d/m/Y') }}</span>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header ingresos">💰 Ingresos</h3>
        <div class="section-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th style="width: 30%; text-align: right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="concept-cell">Días trabajados</td>
                        <td class="amount-cell">${{ number_format($pago->dias_trabajados, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td class="concept-cell">Tiempo extra</td>
                        <td class="amount-cell">${{ number_format($pago->tiempo_extra, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td class="concept-cell">Prima vacacional</td>
                        <td class="amount-cell">${{ number_format($pago->prima_vacacional, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td class="concept-cell">Incapacidades pagadas</td>
                        <td class="amount-cell">${{ number_format($pago->incapacidades_pagadas, 2) }} MXN</td>
                    </tr>
                    <tr class="total-row">
                        <td class="concept-cell">Total Ingresos</td>
                        <td class="amount-cell">${{ number_format($pago->total_ingresos, 2) }} MXN</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header egresos">📉 Egresos</h3>
        <div class="section-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th style="width: 30%; text-align: right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="concept-cell">Descuentos</td>
                        <td class="amount-cell">${{ number_format($pago->descuentos, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td class="concept-cell">Descuentos por faltas</td>
                        <td class="amount-cell">${{ number_format($pago->faltas, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td class="concept-cell">Incapacidades no pagadas</td>
                        <td class="amount-cell">${{ number_format($pago->incapacidades_no_pagadas, 2) }} MXN</td>
                    </tr>
                    <tr class="total-row">
                        <td class="concept-cell">Total Egresos</td>
                        <td class="amount-cell">${{ number_format($pago->total_egresos, 2) }} MXN</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header retenciones">🏛️ Retenciones Legales</h3>
        <div class="section-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th style="width: 30%; text-align: right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="concept-cell">IMSS</td>
                        <td class="amount-cell">${{ number_format($pago->imss, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td class="concept-cell">INFONAVIT</td>
                        <td class="amount-cell">${{ number_format($pago->infonavit, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td class="concept-cell">FONACOT</td>
                        <td class="amount-cell">${{ number_format($pago->fonacot, 2) }} MXN</td>
                    </tr>
                    <tr>
                        <td class="concept-cell">Retención ISR</td>
                        <td class="amount-cell">${{ number_format($pago->retencion_isr, 2) }} MXN</td>
                    </tr>
                    <tr class="total-row">
                        <td class="concept-cell">Total Retenciones</td>
                        <td class="amount-cell">${{ number_format($pago->total_retenciones, 2) }} MXN</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header resumen">📊 Resumen Final</h3>
        <div class="section-content">
            <div class="summary-cards">
                <div class="summary-card bruto">
                    <div class="summary-card-label">Pago Bruto</div>
                    <div class="summary-card-amount">${{ number_format($pago->pago_bruto, 2) }} MXN</div>
                    <div class="summary-card-note">Cantidad sin impuestos</div>
                </div>
                <div class="summary-card final">
                    <div class="summary-card-label">PAGO FINAL</div>
                    <div class="summary-card-amount">${{ number_format($pago->pago_final, 2) }} MXN</div>
                    <div class="summary-card-note">Cantidad a recibir</div>
                </div>
            </div>
        </div>
    </div>

    @if ($pago->observaciones)
        <div class="section">
            <h3 class="section-header observaciones">📝 Observaciones</h3>
            <div class="section-content">
                <div class="observations-content">
                    {{ $pago->observaciones }}
                </div>
            </div>
        </div>
    @endif

    <div class="signature-section">
        <div class="signature-container">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Firma del Empleado</div>
                <div class="signature-sublabel">{{ $pago->guardia->nombre }} {{ $pago->guardia->apellido_p }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Recursos Humanos</div>
                <div class="signature-sublabel">Autorización y Entrega</div>
            </div>
        </div>
    </div>
</body>
</html>
