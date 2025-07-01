@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Cuenta - Banco {{ $data['banco']['nombre'] }}</title>
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

        /* Bank Info Card */
        .bank-info {
            background: white;
            border: 2px solid #1a365d;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(26, 54, 93, 0.1);
        }

        .bank-info-grid {
            display: table;
            width: 100%;
        }

        .bank-info-row {
            display: table-row;
        }

        .bank-info-cell {
            display: table-cell;
            padding: 8px 15px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .bank-info-cell:first-child {
            background-color: #1a365d;
            color: white;
            font-weight: bold;
            width: 25%;
            text-align: center;
        }

        .bank-info-cell:last-child {
            background-color: white;
            color: #2d3748;
        }

        /* Section Styles */
        .section {
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

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
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
            font-size: 8px;
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

        /* Status and Type Badges */
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge.ingreso {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .badge.egreso {
            background-color: #fed7d7;
            color: #742a2a;
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

        .summary-grid {
            display: table;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .summary-row {
            display: table-row;
        }

        .summary-cell {
            display: table-cell;
            padding: 15px;
            text-align: center;
            border: 2px solid #2c5282;
            background: white;
            color: #1a365d;
        }

        .summary-label {
            font-size: 14px;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .summary-amount {
            font-size: 18px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }

        .summary-amount.ingresos {
            color: #38a169;
        }

        .summary-amount.egresos {
            color: #e53e3e;
        }

        .summary-amount.balance {
            color: #1a365d;
            font-size: 22px;
            font-weight: bold;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #718096;
            font-style: italic;
        }

        .empty-state::before {
            content: "📋";
            display: block;
            font-size: 32px;
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

        /* Tabla de movimientos bancarios */
        .movimientos-table th:nth-child(1) { width: 12%; }
        .movimientos-table th:nth-child(2) { width: 12%; }
        .movimientos-table th:nth-child(3) { width: 25%; }
        .movimientos-table th:nth-child(4) { width: 15%; }
        .movimientos-table th:nth-child(5) { width: 12%; }
        .movimientos-table th:nth-child(6) { width: 12%; }
        .movimientos-table th:nth-child(7) { width: 12%; }

        /* Tabla de órdenes de compra */
        .ordenes-table th:nth-child(1) { width: 10%; }
        .ordenes-table th:nth-child(2) { width: 15%; }
        .ordenes-table th:nth-child(3) { width: 10%; }
        .ordenes-table th:nth-child(4) { width: 15%; }
        .ordenes-table th:nth-child(5) { width: 8%; }
        .ordenes-table th:nth-child(6) { width: 10%; }
        .ordenes-table th:nth-child(7) { width: 10%; }
        .ordenes-table th:nth-child(8) { width: 8%; }
        .ordenes-table th:nth-child(9) { width: 8%; }
        .ordenes-table th:nth-child(10) { width: 10%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Estado de Cuenta Bancario</h1>
        <div class="logo-container">
            <img src="{{ public_path('logo/logo2.png') }}" alt="Logo de la empresa" class="logo" />
        </div>
        <div class="subtitle">Reporte Financiero del Banco</div>
    </div>

    <div class="bank-info">
        <div class="bank-info-grid">
            <div class="bank-info-row">
                <div class="bank-info-cell">Banco</div>
                <div class="bank-info-cell">{{ $data['banco']['nombre'] }}</div>
            </div>
            <div class="bank-info-row">
                <div class="bank-info-cell">Cuenta</div>
                <div class="bank-info-cell">{{ $data['banco']['cuenta'] }}</div>
            </div>
            <div class="bank-info-row">
                <div class="bank-info-cell">CLABE</div>
                <div class="bank-info-cell">{{ $data['banco']['clabe'] }}</div>
            </div>
            <div class="bank-info-row">
                <div class="bank-info-cell">Saldo Inicial</div>
                <div class="bank-info-cell amount">${{ number_format($data['banco']['saldo_inicial'], 2) }}</div>
            </div>
            <div class="bank-info-row">
                <div class="bank-info-cell">Saldo Actual</div>
                <div class="bank-info-cell amount">${{ number_format($data['banco']['saldo'], 2) }}</div>
            </div>
            <div class="bank-info-row">
                <div class="bank-info-cell">Período</div>
                <div class="bank-info-cell">{{ Carbon::parse($data['periodo']['inicio'])->format('d/m/Y') }} al {{ Carbon::parse($data['periodo']['fin'])->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">💳 Movimientos Bancarios</h3>
        <div class="section-content">
            @if(count($data['movimientos']) > 0)
                <table class="table movimientos-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Referencia</th>
                            <th>Origen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['movimientos'] as $mov)
                            <tr>
                                <td>{{ Carbon::parse($mov['fecha'])->format('d/m/Y') }}</td>
                                <td><span class="badge {{ strtolower($mov['tipo_movimiento']) }}">{{ $mov['tipo_movimiento'] }}</span></td>
                                <td>{{ $mov['concepto'] }}</td>
                                <td class="amount">${{ number_format($mov['monto'], 2) }}</td>
                                <td>{{ $mov['metodo_pago'] }}</td>
                                <td>{{ $mov['referencia'] ?? '-' }}</td>
                                <td>{{ $mov['modulo'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    No hay movimientos registrados en este periodo.
                </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">🛒 Órdenes de Compra (Pagadas)</h3>
        <div class="section-content">
            @if(count($data['ordenes_compra']) > 0)
                <table class="table ordenes-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>No. OC</th>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Impuesto</th>
                            <th>Descuento</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['ordenes_compra'] as $oc)
                            <tr>
                                <td>{{ Carbon::parse($oc['created_at'])->format('d/m/Y') }}</td>
                                <td>{{ $oc['proveedor']['nombre_empresa'] }}</td>
                                <td class="font-bold">{{ $oc['numero_oc'] }}</td>
                                <td>{{ $oc['articulo']['nombre'] }}</td>
                                <td>{{ $oc['cantidad_articulo'] }}</td>
                                <td class="amount">${{ number_format($oc['precio_articulo'], 2) }}</td>
                                <td class="amount">${{ number_format($oc['subtotal'], 2) }}</td>
                                <td>{{ $oc['impuesto'] }}%</td>
                                <td class="amount">${{ number_format($oc['descuento_monto'], 2) }}</td>
                                <td class="amount font-bold">${{ number_format($oc['total'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    No hay órdenes de compra pagadas en este periodo.
                </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">💰 Gastos</h3>
        <div class="section-content">
            @if(count($data['gastos']) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Subtotal</th>
                            <th>Impuesto</th>
                            <th>Descuento</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['gastos'] as $gasto)
                            <tr>
                                <td>{{ Carbon::parse($gasto['created_at'])->format('d/m/Y') }}</td>
                                <td>{{ $gasto['modulo_concepto']['nombre'] }}</td>
                                <td class="amount">${{ number_format($gasto['subtotal'], 2) }}</td>
                                <td>{{ $gasto['impuesto'] }}%</td>
                                <td class="amount">${{ number_format($gasto['descuento_monto'], 2) }}</td>
                                <td class="amount font-bold">${{ number_format($gasto['total'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    No hay gastos en este periodo.
                </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">📊 Ventas</h3>
        <div class="section-content">
            @if(count($data['ventas']) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Sucursal</th>
                            <th>Factura</th>
                            <th>Nota de crédito</th>
                            <th>Tipo de pago</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['ventas'] as $venta)
                            <tr>
                                <td>{{ Carbon::parse($venta['created_at'])->format('d/m/Y') }}</td>
                                <td>{{ $venta['cotizacion']['sucursal']['nombre_empresa'] ?? $venta['cotizacion']['nombre_empresa'] ?? 'Sin sucursal' }}</td>
                                <td class="font-bold">{{ $venta['numero_factura'] }}</td>
                                <td class="amount">${{ number_format($venta['nota_credito'], 2) }}</td>
                                <td>{{ $venta['tipo_pago'] }}</td>
                                <td class="amount font-bold positive">${{ number_format($venta['total'], 2) }}</td>
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

    <div class="section">
        <h3 class="section-header">👮 Pagos a Guardias</h3>
        <div class="section-content">
            @if(count($data['pagos_empleados']) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Guardia</th>
                            <th>Periodo</th>
                            <th>Sueldo base</th>
                            <th>Días trabajados</th>
                            <th>Total pagado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['pagos_empleados'] as $pago)
                            <tr>
                                <td>{{ Carbon::parse($pago['created_at'])->format('d/m/Y') }}</td>
                                <td>{{ $pago['guardia']['nombre'] ?? 'N/A' }} {{ $pago['guardia']['apellido_p'] ?? '' }}</td>
                                <td>{{ Carbon::parse($pago['periodo_inicio'])->format('d/m/Y') }} - {{ Carbon::parse($pago['periodo_fin'])->format('d/m/Y') }}</td>
                                <td class="amount">${{ number_format($pago['sueldo_base'], 2) }}</td>
                                <td class="text-center">{{ $pago['dias_trabajados'] }}</td>
                                <td class="amount font-bold">${{ number_format($pago['pago_final'], 2) }}</td>
                                <td>{{ $pago['observaciones'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    No hay pagos a guardias en este periodo.
                </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">🏦 Préstamos a Guardias</h3>
        <div class="section-content">
            @if(count($data['prestamos']) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Guardia</th>
                            <th>Concepto</th>
                            <th>Monto Total</th>
                            <th>Monto abonado</th>
                            <th>Saldo Restante</th>
                            <th>No. Pagos</th>
                            <th>Estatus</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['prestamos'] as $prestamo)
                            <tr>
                                <td>{{ Carbon::parse($prestamo['created_at'])->format('d/m/Y') }}</td>
                                <td>{{ $prestamo['guardia']['nombre'] ?? 'N/A' }} {{ $prestamo['guardia']['apellido_p'] ?? '' }}</td>
                                <td>{{ $prestamo['modulo_prestamo']['nombre'] ?? 'N/A' }}</td>
                                <td class="amount">${{ number_format($prestamo['monto_total'], 2) }}</td>
                                <td class="amount positive">${{ number_format(collect($prestamo['abonos'])->sum('monto'), 2) }}</td>
                                <td class="amount negative">${{ number_format($prestamo['saldo_restante'], 2) }}</td>
                                <td class="text-center">{{ count($prestamo['abonos']) }}</td>
                                <td><span class="badge">{{ $prestamo['estatus'] }}</span></td>
                                <td>{{ $pago['observaciones'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    No hay préstamos a guardias en este periodo.
                </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">💵 Abonos de los Préstamos</h3>
        <div class="section-content">
            @if(count($data['abonos']) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Guardia</th>
                            <th>Monto abonado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['abonos'] as $abono)
                            <tr>
                                <td>{{ Carbon::parse($abono['created_at'])->format('d/m/Y') }}</td>
                                <td>{{ $abono['prestamo']['guardia']['nombre'] ?? 'N/A' }} {{ $abono['prestamo']['guardia']['apellido_p'] ?? '' }}</td>
                                <td class="amount positive font-bold">${{ number_format($abono['monto'], 2) }}</td>
                                <td>{{ $abono['observaciones'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    No hay abonos de préstamos en este periodo.
                </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">⛽ Boletas de Gasolina para Vehículos</h3>
        <div class="section-content">
            @if(count($data['boletas']) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Vehículo</th>
                            <th>Kilometraje</th>
                            <th>Litros</th>
                            <th>Costo por litro</th>
                            <th>Costo total</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['boletas'] as $boleta)
                            <tr>
                                <td>{{ Carbon::parse($boleta['created_at'])->format('d/m/Y') }}</td>
                                <td class="font-bold">{{ $boleta['vehiculo']['placas'] ?? 'N/A' }}</td>
                                <td class="text-center">{{ $boleta['kilometraje'] }}</td>
                                <td class="text-center">{{ $boleta['litros'] }}</td>
                                <td class="amount">${{ number_format($boleta['costo_litro'], 2) }}</td>
                                <td class="amount font-bold">${{ number_format($boleta['costo_total'], 2) }}</td>
                                <td>{{ $boleta['observaciones'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    No hay boletas de gasolina en este periodo.
                </div>
            @endif
        </div>
    </div>

    <div class="section resumen">
        <h2>📈 Resumen Financiero</h2>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="summary-label">Ingresos Totales</div>
                    <div class="summary-amount ingresos">${{ number_format($data['resumen']['ingresos'], 2) }} MXN</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Egresos Totales</div>
                    <div class="summary-amount egresos">${{ number_format($data['resumen']['egresos'], 2) }} MXN</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Balance Final</div>
                    <div class="summary-amount balance">${{ number_format($data['resumen']['balance'], 2) }} MXN</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
