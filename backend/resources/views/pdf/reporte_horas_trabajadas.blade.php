<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Horas Trabajadas - Agencia de Seguridad</title>
    <style>
        @page {
            margin: 10mm;
            size: A4;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            font-size: 11px;
            color: #2d3748;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            background-color: rgba(255,255,255,0.1);
            text-align: center;
            line-height: 60px;
            font-size: 24px;
            font-weight: bold;
            color: white;
            margin: 0 auto 20px auto;
        }

        .company-logo img {
            width: 90%;
        }

        .container {
            background-color: white;
            padding: 0;
            overflow: hidden;
            padding-bottom: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 0;
            background: #1a365d;
            color: white;
            padding: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .subtitle {
            margin: 8px 0;
            font-size: 14px;
            opacity: 0.9;
            font-weight: normal;
        }

        .header h2 {
            margin: 15px 0 5px 0;
            font-size: 16px;
            background-color: #0047aa;
            color: #fff;
            padding: 8px 15px;
            border-radius: 10px;
            display: inline-block;
        }

        .employee-info {
            background-color: #f8f9fa;
            border: 2px solid #1a365d;
            padding: 15px;
            margin: 20px;
            text-align: center;
            font-weight: bold;
            color: #1a365d;
        }

        .info-section {
            background-color: #f8f9fa;
            padding: 18px;
            margin: 20px;
            border-left: 5px solid #1a365d;
        }

        .info-row {
            margin-bottom: 10px;
            overflow: hidden;
        }

        .info-label {
            font-weight: bold;
            color: #1a365d;
            width: 180px;
            float: left;
            padding: 5px 15px 5px 0;
        }

        .info-value {
            color: #2d3748;
            padding: 5px 0;
            font-weight: 500;
            margin-left: 180px;
        }

        .security-badge {
            color: #fff;
            padding: 4px 12px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: bold;
        }

        .table-container {
            margin: 20px;
            background-color: white;
            border: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        th {
            background-color: #1a365d;
            color: white;
            padding: 14px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #2c5282;
            text-align: center;
        }

        td {
            padding: 12px 8px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            background-color: #002d6d;
            color: white;
            padding: 20px;
            margin: 20px;
            text-align: center;
        }

        .total-section h3 {
            margin: 0 0 10px 0;
            font-size: 25px;
            text-transform: uppercase;
        }

        .total-hours {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
            color: #fff;
        }

        .total-details {
            background-color: #2c5282;
            padding: 15px;
            margin-top: 15px;
            font-size: 12px;
            line-height: 1.6;
        }

        .footer {
            margin: 30px 20px 20px 20px;
            text-align: center;
            color: #718096;
            font-size: 9px;
            border-top: 2px solid #1a365d;
            padding-top: 15px;
        }

        .no-records {
            text-align: center;
            padding: 50px;
            color: #718096;
            font-style: italic;
            background-color: white;
            margin: 20px;
        }

        .orden-servicio {
            font-weight: bold;
            color: #1a365d;
            background-color: #fff3cd;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            border: 1px solid #0047aa;
        }

        .ubicacion {
            color: #2d3748;
            text-align: center;
        }

        .fecha {
            white-space: nowrap;
            color: #2b2f35;
            font-family: 'Courier New', monospace;
            font-size: 11px;
        }

        .horas {
            font-weight: bold;
            color: #fff;
            background-color: #0047aa;
            padding: 6px 10px;
            border-radius: 15px;
            font-family: 'Courier New', monospace;
            font-size: 10px;
        }

        .confidential {
            color: #dc3545;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-logo">
                <img src="{{ public_path('logo/logo.png') }}" alt="Logo de la empresa">
            </div>
            <h1>REPORTE DE HORAS TRABAJADAS</h1>
            <h2>
                <span>{{ $guardia->nombre }} {{ $guardia->apellido_p }} {{ $guardia->apellido_m }}
                <br>
                <span class="security-badge">EMPLEADO: {{ $guardia->numero_empleado }}</span>
            </h2>
        </div>

        <div class="employee-info">
            INFORMACION DE LOS SERVICIOS
        </div>

        <div class="table-container">
            @if(isset($registros) && count($registros) > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 12%;">ORDEN SERVICIO</th>
                            <th style="width: 18%;">UBICACION ENTRADA</th>
                            <th style="width: 18%;">UBICACION SALIDA</th>
                            <th style="width: 17%;">FECHA/HORA ENTRADA</th>
                            <th style="width: 17%;">FECHA/HORA SALIDA</th>
                            <th style="width: 18%;" class="text-center">TIEMPO TRABAJADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registros as $registro)
                            <tr>
                                <td>
                                    <span class="orden-servicio">
                                        {{ $registro->orden_servicio }}
                                    </span>
                                </td>
                                <td class="ubicacion">
                                    {{ $registro->ubicacion }}
                                </td>
                                <td class="ubicacion">
                                    {{ $registro->ubicacion_salida ?? 'No especificada' }}
                                </td>
                                <td class="fecha">
                                    {{ \Carbon\Carbon::parse($registro->fecha_entrada)->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="fecha">
                                    {{ $registro->fecha_salida ? \Carbon\Carbon::parse($registro->fecha_salida)->format('d/m/Y H:i:s') : 'Sin checkout' }}
                                </td>
                                <td class="text-center">
                                    <span class="horas">
                                        {{ $registro->tiempo_trabajado }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-records">
                    <p><strong>No se encontraron registros para el periodo seleccionado.</strong></p>
                    <p>Verifique las fechas y el empleado seleccionado.</p>
                </div>
            @endif
        </div>
    </div>
    @if(isset($registros) && count($registros) > 0)
            <div class="total-section">
                <h3>TIEMPO TRABAJADO</h3>
                <div class="total-hours">
                    {{ $total_detallado }}
                </div>
            </div>
        @endif
</body>
</html>
