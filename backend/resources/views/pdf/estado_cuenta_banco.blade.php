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
            font-size: 18px;
            margin-bottom: 30px;
            text-align: center;
        }
        .resumen p{
            margin: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
            font-size: 10px;
        }
        .highlight {
            background-color: #27548A;
            color: white;
            padding: 5px 7px;
            border-radius: 5px;
        }
        .success { color: #0d7033; font-weight: bold; }
        .danger { color: #b61818; font-weight: bold; }
        .warning { color: #d46700; font-weight: bold; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h1 class="center">Estado de Cuenta del Banco</h1>

    <p><strong>Banco:</strong> {{ $data['banco']['nombre'] }}</p>
    <p><strong>Cuenta:</strong> {{ $data['banco']['cuenta'] }} | <strong>CLABE:</strong> {{ $data['banco']['clabe'] }}</p>
    <p><strong>Periodo:</strong> {{ Carbon::parse($data['periodo']['inicio'])->format('d/m/Y') }} al {{ Carbon::parse($data['periodo']['fin'])->format('d/m/Y') }}</p>

    <div class="section">
        <h3>Movimientos Bancarios</h3>
        @if(count($data['movimientos']) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Referencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['movimientos'] as $mov)
                        <tr>
                            <td>{{ Carbon::parse($mov['fecha'])->format('d/m/Y') }}</td>
                            <td>{{ $mov['tipo_movimiento'] }}</td>
                            <td>{{ $mov['concepto'] }}</td>
                            <td>${{ number_format($mov['monto'], 2) }}</td>
                            <td>{{ $mov['metodo_pago'] }}</td>
                            <td>{{ $mov['referencia'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay movimientos registrados en este periodo.</p>
        @endif
    </div>

    <div class="section">
        <h3>Órdenes de Compra (Pagadas)</h3>
        @if(count($data['ordenes_compra']) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>No. OC</th>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Método</th>
                        <th>Subtotal</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['ordenes_compra'] as $oc)
                        <tr>
                            <td>{{ Carbon::parse($oc['created_at'])->format('d/m/Y') }}</td>
                            <td>{{ $oc['numero_oc'] }}</td>
                            <td>{{ $oc['articulo']['nombre'] }}</td>
                            <td>{{ $oc['cantidad_articulo'] }}</td>
                            <td>${{ number_format($oc['precio_articulo'], 2) }}</td>
                            <td>{{ $oc['metodo_pago'] }}</td>
                            <td>${{ number_format($oc['subtotal'], 2) }}</td>
                            <td>{{ $oc['impuesto'] ? 'Sí' : 'No' }}</td>
                            <td>${{ number_format($oc['total'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay órdenes de compra pagadas en este periodo.</p>
        @endif
    </div>

    <div class="section">
        <h3>Gastos</h3>
        @if(count($data['gastos']) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Método</th>
                        <th>Subtotal</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['gastos'] as $gasto)
                        <tr>
                            <td>{{ Carbon::parse($gasto['created_at'])->format('d/m/Y') }}</td>
                            <td>{{ $gasto['modulo_concepto']['nombre'] }}</td>
                            <td>{{ $gasto['metodo_pago'] }}</td>
                            <td>${{ number_format($gasto['subtotal'], 2) }}</td>
                            <td>{{ $gasto['impuesto'] ? 'Sí' : 'No' }}</td>
                            <td>${{ number_format($gasto['total'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay gastos en este periodo.</p>
        @endif
    </div>

    <div class="section">
        <h3>Ventas</h3>
        @if(count($data['ventas']) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Sucursal</th>
                        <th>Factura</th>
                        <th>Nota de crédito</th>
                        <th>Método de pago</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['ventas'] as $venta)
                        <tr>
                            <td>{{ Carbon::parse($venta['created_at'])->format('d/m/Y') }}</td>
                            <td>{{ $venta['cotizacion']['sucursal']['nombre_empresa'] ?? $venta['cotizacion']['nombre_empresa'] ?? 'Sin sucursal' }}</td>
                            <td>{{ $venta['numero_factura'] }}</td>
                            <td>${{ number_format($venta['nota_credito'], 2) }}</td>
                            <td>{{ $venta['metodo_pago'] }}</td>
                            <td>${{ number_format($venta['total'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay ventas en este periodo.</p>
        @endif
    </div>

    <div class="section center resumen">
        <h2>Resumen Financiero</h2>
        <p><strong>Ingresos:</strong> <span class="success">${{ number_format($data['resumen']['ingresos'], 2) }} MXN.</span></p>
        <p><strong>Egresos:</strong> <span class="danger">${{ number_format($data['resumen']['egresos'], 2) }} MXN.</span></p>
        <p class="">
            <strong>Balance Final:</strong> <span class="highlight">${{ number_format($data['resumen']['balance'], 2) }} MXN.</span>
        </p>
    </div>
</body>
</html>
