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
            font-size: 12px;
            color: #333;
        }
        h1, h2, h3 {
            color: #27548A;
        }
        .section {
            margin-bottom: 25px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        .resumen h2 {
            font-size: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .sucursal-title {
            margin-top: 5px;
            font-size: 14px;
            font-weight: bold;
            color: #0d497f;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }
        .highlight {
            background-color: #27548A;
            color: white;
            padding: 5px 7px;
            border-radius: 5px;
        }
        .text-right {
            text-align: right;
        }
        .total-line {
            margin-top: 15px;
            border-top: 1px dashed #aaa;
            padding-top: 10px;
        }
        .success {
            color: #0d7033;
            font-weight: bold;
        }
        .danger {
            color: #b61818;
            font-weight: bold;
        }
        .warning{
            color: #d46700;
            font-weight: bold;
        }
        .datos-contacto{
            margin: 5px 0;
        }
        .info-extra {
            font-size: 11px;
            margin-top: 10px;
        }
        .info-extra p{
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center">Estado de Cuenta del Cliente</h1>

    <p><strong>Cliente:</strong> {{ $data['cliente']['nombre_empresa'] }}</p>
    <p><strong>Periodo:</strong> {{ Carbon::parse($data['periodo']['inicio'])->format('d/m/Y') }} al {{ Carbon::parse($data['periodo']['fin'])->format('d/m/Y') }}</p>

    @foreach($data['sucursales'] as $entry)
        <div class="section">
            <p class="sucursal-title">Sucursal: {{ $entry['sucursal']['nombre_empresa'] }}</p>
            <p class="datos-contacto"><strong>Dirección:</strong> {{ $entry['sucursal']['calle'] }} {{ $entry['sucursal']['numero'] }}, {{ $entry['sucursal']['colonia'] }}, {{ $entry['sucursal']['municipio'] }}, {{ $entry['sucursal']['estado'] }} CP: {{ $entry['sucursal']['cp'] }}, {{ $entry['sucursal']['pais'] }}</p>
            <p class="datos-contacto"><strong>Teléfono:</strong> {{ $entry['sucursal']['telefono_empresa'] }} Ext: {{ $entry['sucursal']['extension_empresa'] }}</p>
            <p class="datos-contacto"><strong>Contacto:</strong> {{ $entry['sucursal']['nombre_contacto'] }}</p>

            <h3>Cotizaciones</h3>
            @if(count($entry['cotizaciones']) > 0)
                <table class="table">
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
                                <td>${{ number_format($cot['subtotal'], 2) }}</td>
                                <td>{{ $cot['impuesto'] ? 'Sí' : 'No' }}</td>
                                <td>${{ number_format($cot['total'], 2) }}</td>
                                <td>{{ $cot['aceptada'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="info-extra">
                    <p><strong>Jefe de turno:</strong> {{ $cot['jefe_turno'] }} @if($cot['jefe_turno'] === 'SI') - ${{ number_format($cot['precio_jefe_turno'], 2) }} @endif</p>
                    <p><strong>Supervisor:</strong> {{ $cot['supervisor'] }} @if($cot['supervisor'] === 'SI') - ${{ number_format($cot['precio_supervisor'], 2) }} @endif</p>
                    <p><strong>Requisitos de pago:</strong> {{ $cot['requisitos_pago_cliente'] ?? 'No especificado' }}</p>
                    <p><strong>Soporte documental:</strong> {{ $cot['soporte_documental'] }} @if(!empty($cot['observaciones_soporte_documental'])) - {{ $cot['observaciones_soporte_documental'] }} @endif</p>
                    <p><strong>Descuento:</strong> {{ $cot['descuento_porcentaje'] ?? '0' }}%</p>
                    <p><strong>Costo extra:</strong> ${{ $cot['costo_extra'] ?? '0' }}</p>
                    <p><strong>Notas:</strong> {{ $cot['notas'] ?? 'Sin notas adicionales' }}</p>
                </div>
            @else
                <p>No hay cotizaciones en este periodo.</p>
            @endif

            <h3 style="margin-top: 20px">Ventas</h3>
            @if(count($entry['ventas']) > 0)
                <table class="table">
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
                                <td>{{ $venta['numero_factura'] ?? 'N/A' }}</td>
                                <td>{{ Carbon::parse($venta['fecha_emision'])->format('d/m/Y') }}</td>
                                <td>{{ $venta['fecha_vencimiento'] ? Carbon::parse($venta['fecha_vencimiento'])->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $venta['tipo_pago'] === 'Crédito' ? ($venta['dias_credito'] ?? '-') : '-' }}</td>
                                <td>{{ $venta['nota_credito'] }}</td>
                                <td>${{ number_format($venta['total'], 2) }}</td>
                                <td>{{ $venta['tipo_pago'] }}</td>
                                <td>{{ $venta['metodo_pago'] }}</td>
                                <td>{{ $venta['estatus'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay ventas en este periodo.</p>
            @endif
        </div>
    @endforeach

    <div class="section resumen">
        <h2>Resumen General</h2>

        <div>
            <p>
                <strong>Totales de cotizaciones:</strong>
            </p>
            <ul>
                <li>Aceptadas: {{ $data['resumen']['cotizaciones']['aceptadas'] }}</li>
                <li>No aceptadas: {{ $data['resumen']['cotizaciones']['no_aceptadas'] }}</li>
                <li>Pendientes: {{ $data['resumen']['cotizaciones']['pendientes'] }}</li>
            </ul>
        </div>

        <div class="total-line"></div>

        <div>
            <p>
                <strong>Total ventas:</strong> <span class="highlight">${{ number_format($data['resumen']['ventas']['total'], 2) }}</span>
            </p>
            <ul>
                <li class="success">Pagadas: ${{ number_format($data['resumen']['ventas']['pagadas'], 2) }}</li>
                <li class="danger">Pendientes: ${{ number_format($data['resumen']['ventas']['pendientes'], 2) }}</li>
                <li class="danger">Vencidas: ${{ number_format($data['resumen']['ventas']['vencidas'], 2) }}</li>
                <li class="warning">Canceladas: ${{ number_format($data['resumen']['ventas']['canceladas'], 2) }}</li>
            </ul>
        </div>

        <div class="total-line"></div>

        <div>
            <p>
                <strong>Balance financiero:</strong>
            </p>
            <ul>
                <li class="success">Total recibido (ventas pagadas): ${{ number_format($data['resumen']['ventas']['pagadas'], 2) }}</li>
                <li class="danger">Total pendiente por pagar (pendientes + vencidas): ${{ number_format($data['resumen']['ventas']['pendientes'] + $data['resumen']['ventas']['vencidas'], 2) }}</li>
            </ul>
        </div>
    </div>
</body>
</html>
