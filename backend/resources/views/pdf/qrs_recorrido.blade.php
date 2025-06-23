@php
    use Carbon\Carbon;
    $cliente = $orden->venta->cotizacion->sucursal->cliente->nombre_empresa ?? $orden->venta->cotizacion->nombre_empresa ?? 'N/A';
    $sucursal = $orden->venta->cotizacion->sucursal->nombre_empresa ?? 'N/A';
    $existe_empresa = $orden->venta->cotizacion->sucursal->cliente->nombre_empresa ?? false;
    $responsable = $orden->nombre_responsable_sitio ?? 'N/A';
    $telefono_responsable = $orden->telefono_responsable_sitio ?? 'N/A';
    $estatus = $orden->estatus ?? 'N/A';
    $observaciones = $orden->observaciones ?? 'N/A';
    $venta = $orden->venta;
    $numero_factura = $venta->numero_factura ?? 'N/A';
    $total_venta = $venta->total ?? 0;
    $metodo_pago = $venta->metodo_pago ?? 'N/A';
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>QRs Recorrido - Orden {{ $orden->codigo_orden_servicio }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        h1 {
            text-align: center;
            font-size: 22px;
            color: #1c3d6e;
            margin-bottom: 30px;
        }

        .info {
            background-color: #eef1f6;
            border-left: 5px solid #1c3d6e;
            padding: 10px 15px;
            margin-bottom: 25px;
            border-radius: 8px;
        }

        .info p {
            margin: 5px 0;
            font-size: 13px;
        }

        /* Para el QR */
        .qr-page {
            page-break-before: always; /* Para que cada QR esté en una nueva página */
            text-align: center;
            height: 100%;
        }

        .qr-box {
            width: 90%;
            height: 75%;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 0 auto;
        }

        .qr-box img {
            width: 90%; /* Ajusta el tamaño del QR según lo necesites */
            height: auto;
        }

        .qr-desc {
            font-size: 30px;
            font-weight: bold;
            color: #1c3d6e;
            margin-top: 20px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

    <h1>QRs de Recorrido</h1>

     <div class="info">
        <p><strong>Orden de Servicio:</strong> {{ $orden->codigo_orden_servicio }}</p>
        <p><strong>Cliente:</strong> {{ $cliente }}.</p>
        @if($existe_empresa)
            <p><strong>Sucursal:</strong> {{ $sucursal }}.</p>
        @endif
        <p><strong>Dirección del Servicio:</strong> {{ $orden->domicilio_servicio }}</p>
        <p><strong>Fecha de inicio del servicio:</strong> {{ Carbon::parse($orden->fecha_inicio)->format('d/m/Y') }}</p>
        <p><strong>Fecha de fin del servicio:</strong> {{ Carbon::parse($orden->fecha_fin)->format('d/m/Y') }}</p>
        <p><strong>Responsable del sitio:</strong> {{ $responsable }}</p>
        <p><strong>Teléfono del responsable del sitio:</strong> {{ $telefono_responsable }}</p>
        <p><strong>Estatus:</strong> {{ $estatus }}</p>
        <p><strong>Observaciones:</strong> {{ $observaciones }}</p>
        <p><strong>Número de Factura:</strong> {{ $numero_factura }}</p>
        <p><strong>Fecha de Impresión:</strong> {{ Carbon::now()->format('d/m/Y') }}</p>
    </div>

    <!-- Separador de página para los QR -->
    @foreach($puntos as $punto)
        <div class="qr-page">
            <div class="qr-box">
                <div class="qr-desc">
                    {{ $punto->nombre_punto }}
                </div>
                <img src="data:image/svg+xml;base64,{{ $punto->image_base64 }}" alt="QR">
            </div>
        </div>
    @endforeach
</body>
</html>
