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
            color: #333;
            padding: 40px;
            line-height: 1.5;
        }
        h2, h3 {
            color: #1a3e72;
            text-align: center;
        }
        h2 {
            font-size: 22px;
        }
        h1 {
            margin: 0;
            margin-bottom: 20px;
            text-align: center;
        }
        .header, .section {
            margin-bottom: 30px;
        }
        .section{
            page-break-inside: avoid;
        }
        .info-box {
            background: #f1f5fb;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #444;
        }
        .value {
            margin-bottom: 8px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }
        .table th, .table td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }
        .highlight {
            background: #1a3e72;
            color: white;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>Resumen de Cotización</h1>

    <div class="section">
        <h2>Datos del Cliente</h2>
        <div class="info-box">
            @if($cotizacion->sucursal)
                <div class="value"><span class="label">Cliente:</span> {{ $cotizacion->sucursal->cliente->nombre_empresa }}</div>
                <div class="value"><span class="label">Sucursal:</span> {{ $cotizacion->sucursal->nombre_empresa }}</div>
                <div class="value"><span class="label">Contacto:</span> {{ $cotizacion->sucursal->nombre_contacto }} | {{ $cotizacion->sucursal->telefono_contacto }}</div>
                <div class="value"><span class="label">Correo:</span> {{ $cotizacion->sucursal->correo_contacto }}</div>
                <div class="value"><span class="label">Dirección:</span> {{ $cotizacion->sucursal->calle }} #{{ $cotizacion->sucursal->numero }}, {{ $cotizacion->sucursal->colonia }}, CP: {{ $cotizacion->sucursal->cp }}, {{ $cotizacion->sucursal->municipio }}, {{ $cotizacion->sucursal->estado }}, {{ $cotizacion->sucursal->pais}}.</div>
            @else
                <div class="value"><span class="label">Empresa:</span> {{ $cotizacion->nombre_empresa }}</div>
                <div class="value"><span class="label">Contacto:</span> {{ $cotizacion->nombre_contacto }} | {{ $cotizacion->telefono_contacto }}</div>
                <div class="value"><span class="label">Correo:</span> {{ $cotizacion->correo_contacto }}</div>
                <div class="value"><span class="label">Dirección:</span> {{ $cotizacion->calle }} #{{ $cotizacion->numero }}, {{ $cotizacion->colonia }}, CP: {{ $cotizacion->cp }}, {{ $cotizacion->municipio }}, {{ $cotizacion->estado }}. {{ $cotizacion->pais }}.</div>
            @endif
        </div>
    </div>

    <div class="section">
        <h2>Condiciones Comerciales</h2>
        <div class="info-box">
            <div class="value"><span class="label">Días de Crédito:</span> {{ $cotizacion->credito_dias }}</div>
            @if($cotizacion->sucursal)
                <div class="value"><span class="label">Uso CFDI:</span> {{ $cotizacion->sucursal->uso_cfdi }}</div>
                <div class="value"><span class="label">Régimen Fiscal:</span> {{ $cotizacion->sucursal->regimen_fiscal }}</div>
                <div class="value"><span class="label">Razón social:</span> {{ $cotizacion->sucursal->razon_social }}</div>
                <div class="value"><span class="label">RFC:</span> {{ $cotizacion->sucursal->rfc }}</div>
            @else
                <div class="value"><span class="label">Uso CFDI:</span> {{ $cotizacion->uso_cfdi }}</div>
                <div class="value"><span class="label">Régimen Fiscal:</span> {{ $cotizacion->regimen_fiscal }}</div>
                <div class="value"><span class="label">Razón social:</span> {{ $cotizacion->razon_social }}</div>
                <div class="value"><span class="label">RFC:</span> {{ $cotizacion->rfc }}</div>
            @endif

        </div>
    </div>

    <div class="section">
        <h2>Servicio Cotizado</h2>
        <div class="info-box">
            <div class="value"><span class="label">Fecha del servicio:</span> {{ Carbon::parse($cotizacion->fecha_servicio)->format('d/m/Y') }}</div>
            <div class="value"><span class="label">Servicios:</span> {{ $cotizacion->servicios }}</div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Guardias de día</td>
                    <td>{{ $cotizacion->guardias_dia }}</td>
                    <td>${{ number_format($cotizacion->precio_guardias_dia, 2) }} MXN.</td>
                    <td>${{ number_format($cotizacion->precio_guardias_dia_total, 2) }} MXN.</td>
                </tr>
                <tr>
                    <td>Guardias de noche</td>
                    <td>{{ $cotizacion->guardias_noche }}</td>
                    <td>${{ number_format($cotizacion->precio_guardias_noche, 2) }} MXN.</td>
                    <td>${{ number_format($cotizacion->precio_guardias_noche_total, 2) }} MXN.</td>
                </tr>
                @if($cotizacion->jefe_turno === 'SI')
                    <tr>
                        <td>Jefe de turno</td>
                        <td>1</td>
                        <td>${{ number_format($cotizacion->precio_jefe_turno, 2) }} MXN.</td>
                        <td>${{ number_format($cotizacion->precio_jefe_turno, 2) }} MXN.</td>
                    </tr>
                @endif
                @if($cotizacion->supervisor === 'SI')
                    <tr>
                        <td>Supervisor</td>
                        <td>1</td>
                        <td>${{ number_format($cotizacion->precio_supervisor, 2) }} MXN.</td>
                        <td>${{ number_format($cotizacion->precio_supervisor, 2) }} MXN.</td>
                    </tr>
                @endif
                @if($cotizacion->costo_extra)
                    <tr>
                        <td>Otros Costos</td>
                        <td>1</td>
                        <td colspan="2">${{ number_format($cotizacion->costo_extra, 2) }} MXN.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Total</h2>
        <table class="table">
            <tr>
                <td class="highlight">Subtotal</td>
                <td>
                    ${{ number_format($cotizacion->subtotal, 2) }} MXN.
                </td>
            </tr>
            <tr>
                <td class="highlight">Costo extra</td>
                <td>
                    ${{ number_format($cotizacion->costo_extra, 2) }} MXN.
                </td>
            </tr>
            @if($cotizacion->costo_extra)
                <tr>
                    <td class="highlight">Subtotal ajustado</td>
                    <td>
                        ${{ number_format($cotizacion->subtotal + $cotizacion->costo_extra, 2) }} MXN.
                    </td>
                </tr>
            @endif
            <tr>
                <td class="highlight">Descuento</td>
                <td>
                    @if($cotizacion->descuento_porcentaje)
                        {{ $cotizacion->descuento_porcentaje }}%
                    @else
                        0%
                    @endif
                </td>
            </tr>
            <tr>
                <td class="highlight">Impuesto (IVA)</td>
                <td>{{ $cotizacion->impuesto }}%</td>
            </tr>
            <tr>
                <td class="highlight">Total</td>
                <td><strong>${{ number_format($cotizacion->total, 2) }} MXN.</strong></td>
            </tr>
        </table>
    </div>

    @if($cotizacion->notas)
    <div class="section">
        <h3>Notas Adicionales</h3>
        <div class="info-box">
            {{ $cotizacion->notas }}
        </div>
    </div>
    @endif
</body>
</html>
