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

        /* Order Info Card */
        .order-info {
            background: white;
            border: 2px solid #1a365d;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(26, 54, 93, 0.1);
        }

        .order-info-grid {
            display: table;
            width: 100%;
        }

        .order-info-row {
            display: table-row;
        }

        .order-info-cell {
            display: table-cell;
            padding: 8px 15px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            font-size: 13px;
        }

        .order-info-cell:first-child {
            background-color: #1a365d;
            color: white;
            font-weight: bold;
            width: 30%;
            text-align: center;
        }

        .order-info-cell:last-child {
            background-color: white;
            color: #2d3748;
        }

        /* QR Page Styles */
        .qr-page {
            page-break-before: always;
            text-align: center;
            padding: 40px 20px;
        }

        .qr-page:first-child {
            page-break-before: avoid;
        }

        .qr-header {
            background: #1a365d;
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            margin-bottom: 0;
        }

        .qr-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .qr-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 8px;
        }

        .qr-box {
            background: white;
            border: 3px solid #1a365d;
            border-radius: 0 0 12px 12px;
            padding: 40px;
            box-shadow: 0 8px 25px rgba(26, 54, 93, 0.15);
            margin: 0 auto;
            max-width: 500px;
        }

        .qr-point-name {
            font-size: 28px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 3px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .qr-image-container {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .qr-image {
            width: 300px;
            height: 300px;
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
        }

        .qr-footer {
            background: #f0f4f8;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .qr-footer-text {
            color: #4a5568;
            font-size: 12px;
            font-weight: bold;
        }

        .order-code {
            color: #1a365d;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-proceso {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .status-cancelada {
            background-color: #fef5e7;
            color: #744210;
        }

        .status-finalizada {
            background-color: #bee3f8;
            color: #2c5282;
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

            .qr-page {
                page-break-before: always;
            }

            .qr-page:first-child {
                page-break-before: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>QRs de Recorrido</h1>
        <div class="logo-container">
            <img src="{{ public_path('logo/logo2.png') }}" alt="Logo de la empresa" class="logo" />
        </div>
        <div class="subtitle">Códigos QR para puntos de control</div>
    </div>

    <div class="order-info">
        <div class="order-info-grid">
            <div class="order-info-row">
                <div class="order-info-cell">Orden de Servicio</div>
                <div class="order-info-cell"><span class="order-code">{{ $orden->codigo_orden_servicio }}</span></div>
            </div>
            <div class="order-info-row">
                <div class="order-info-cell">Cliente</div>
                <div class="order-info-cell">{{ $cliente }}</div>
            </div>
            @if($existe_empresa)
                <div class="order-info-row">
                    <div class="order-info-cell">Sucursal</div>
                    <div class="order-info-cell">{{ $sucursal }}</div>
                </div>
            @endif
            <div class="order-info-row">
                <div class="order-info-cell">Dirección del Servicio</div>
                <div class="order-info-cell">{{ $orden->domicilio_servicio }}</div>
            </div>
            <div class="order-info-row">
                <div class="order-info-cell">Período de Servicio</div>
                <div class="order-info-cell">{{ Carbon::parse($orden->fecha_inicio)->format('d/m/Y') }} - {{ Carbon::parse($orden->fecha_fin)->format('d/m/Y') }}</div>
            </div>
            <div class="order-info-row">
                <div class="order-info-cell">Responsable del Sitio</div>
                <div class="order-info-cell">{{ $responsable }} | Tel: {{ $telefono_responsable }}</div>
            </div>
            <div class="order-info-row">
                <div class="order-info-cell">Estatus</div>
                <div class="order-info-cell">
                    <span class="status-badge status-{{ strtolower($estatus === 'En proceso' ? 'proceso' : $estatus) }}">{{ $estatus }}</span>
                </div>
            </div>
            <div class="order-info-row">
                <div class="order-info-cell">Número de Factura</div>
                <div class="order-info-cell"><span class="order-code">{{ $numero_factura }}</span></div>
            </div>
            <div class="order-info-row">
                <div class="order-info-cell">Fecha de Impresión</div>
                <div class="order-info-cell">{{ Carbon::now()->format('d/m/Y H:i:s') }}</div>
            </div>
            @if($observaciones !== 'N/A')
                <div class="order-info-row">
                    <div class="order-info-cell">Observaciones</div>
                    <div class="order-info-cell">{{ $observaciones }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- QR Pages -->
    @foreach($puntos as $index => $punto)
        <div class="qr-page">
            <div class="qr-header">
                <div class="qr-title">Punto de Control</div>
                <div class="qr-subtitle">Orden: {{ $orden->codigo_orden_servicio }} | Punto {{ $index + 1 }} de {{ count($puntos) }}</div>
            </div>

            <div class="qr-box">
                <div class="qr-point-name">
                    {{ $punto->nombre_punto }}
                </div>

                <div class="qr-image-container">
                    <img src="data:image/svg+xml;base64,{{ $punto->image_base64 }}" alt="QR" class="qr-image">
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
