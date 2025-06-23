@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Cuenta - Proveedor {{ $data['proveedor']['nombre_empresa'] }}</title>
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
        .title-orden{
            margin-top: 0;
            margin-bottom: 20px;
        }
        .text-provee{
            margin: 7px 0;
        }
        .resumen h3 {
            font-size: 20px;
            margin-bottom: 15px;
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 0.5px solid #ccc;
            padding: 5px;
            text-align: center;
            font-size: 9px;
        }
        .highlight {
            background-color: #27548A;
            color: white;
            padding: 5px 7px;
            border-radius: 5px;
            display: inline-block;
            font-size: 15px;
        }
        .success {
            color: #0d7033;
            font-weight: bold;
        }
        .danger {
            color: #b61818;
            font-weight: bold;
        }
        .warning {
            color: #d46700;
            font-weight: bold;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center">Estado de Cuenta del Proveedor</h1>

    <p><strong>Proveedor:</strong> {{ $data['proveedor']['nombre_empresa'] }}</p>
    <p><strong>Periodo:</strong> {{ Carbon::parse($data['periodo']['inicio'])->format('d/m/Y') }} al {{ Carbon::parse($data['periodo']['fin'])->format('d/m/Y') }}</p>

    <div class="section">
        <h3 class="title-orden">Datos del Proveedor</h3>
        <p class="text-provee"><strong>RFC:</strong> {{ $data['proveedor']['rfc'] }}</p>
        <p class="text-provee"><strong>Razón Social:</strong> {{ $data['proveedor']['razon_social'] }}</p>
        <p class="text-provee"><strong>Dirección:</strong> {{ $data['proveedor']['calle'] }} {{ $data['proveedor']['numero'] }}, {{ $data['proveedor']['colonia'] }}, {{ $data['proveedor']['municipio'] }}, {{ $data['proveedor']['estado'] }}, CP: {{ $data['proveedor']['cp'] }}, {{ $data['proveedor']['pais'] }}</p>
        <p class="text-provee"><strong>Teléfono Empresa:</strong> {{ $data['proveedor']['telefono_empresa'] }} Ext: {{ $data['proveedor']['extension_empresa'] }}</p>
        <p class="text-provee"><strong>Contacto:</strong> {{ $data['proveedor']['nombre_contacto'] }} | {{ $data['proveedor']['telefono_contacto'] }} | WhatsApp: {{ $data['proveedor']['whatsapp_contacto'] }}</p>
        <p class="text-provee"><strong>Correo:</strong> {{ $data['proveedor']['correo'] }}</p>
        <p class="text-provee"><strong>Días de Crédito:</strong> {{ $data['proveedor']['credito_dias'] ?? 'No definido' }}</p>
    </div>

    <div class="section">
        <h3 class="title-orden">Órdenes de Compra</h3>
        @if(count($data['ordenes']) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th># OC</th>
                        <th>Fecha</th>
                        <th>Art.</th>
                        <th>Cant.</th>
                        <th>Precio U.</th>
                        <th>Subt.</th>
                        <th>Total</th>
                        <th>IVA</th>
                        <th>Pago</th>
                        <th>Banco</th>
                        <th>Estatus</th>
                        <th>Vencim.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['ordenes'] as $orden)
                        <tr>
                            <td>{{ $orden['numero_oc'] }}</td>
                            <td>{{ $orden['fecha'] }}</td>
                            <td>{{ $orden['articulo'] }}</td>
                            <td>{{ $orden['cantidad'] }}</td>
                            <td>${{ number_format($orden['precio'], 2) }}</td>
                            <td>${{ number_format($orden['subtotal'], 2) }}</td>
                            <td>${{ number_format($orden['total'], 2) }}</td>
                            <td>{{ $orden['impuesto'] }}</td>
                            <td>
                                @if($orden['metodo_pago'] === 'Transferencia bancaria')
                                    Transferencia
                                @elseif($orden['metodo_pago'] === 'Tarjeta de crédito/débito')
                                    Tarjeta
                                @else
                                    {{ $orden['metodo_pago'] }}
                                @endif
                            </td>
                            <td>{{ $orden['banco'] }}</td>
                            <td>{{ $orden['estatus'] }}</td>
                            <td>{{ $orden['fecha_vencimiento'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay órdenes de compra en este periodo.</p>
        @endif
    </div>

    <div class="section resumen">
        <h3 class="title-orden">Resumen General</h3>
        <ul>
            <li class="success">Pagadas: ${{ number_format($data['resumen']['pagadas'], 2) }} MXN.</li>
            <li class="danger">Pendientes: ${{ number_format($data['resumen']['pendientes'], 2) }} MXN.</li>
            <li class="danger">Vencidas: ${{ number_format($data['resumen']['vencidas'], 2) }} MXN.</li>
            <li class="warning">Canceladas: ${{ number_format($data['resumen']['canceladas'], 2) }} MXN.</li>
            <li><strong>Total de órdenes:</strong> ${{ number_format($data['resumen']['total'], 2) }} MXN.</li>
        </ul>
        <p class="center">
            <span class="highlight">Total por pagar (pendientes + vencidas): ${{ number_format($data['resumen']['por_pagar'], 2) }} MXN.</span>
        </p>
    </div>
</body>
</html>
