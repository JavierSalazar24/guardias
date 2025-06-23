@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Cuenta del Guardia {{ $data['guardia']['nombre'] }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            font-size: 13px;
            line-height: 1.5;
        }
        h1, h3 {
            color: #27548A;
        }
        .section {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            page-break-inside: avoid;
        }
        .resumen h3 {
            font-size: 20px;
            margin-bottom: 15px;
            text-align: center;
        }
        .resumen .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
        }
        .highlight {
            background-color: #27548A;
            color: #fff;
            padding: 5px 7px;
            border-radius: 8px;
            font-size: 14px;
        }
        .ingresos {
            background-color: #1f964d;
            color: white;
        }
        .egresos {
            background-color: #e02525;
            color: white;
        }
        .total-line {
            margin: 20px 0 0 0;
            padding: 10px;
            border-top: 1px dashed #ccc;
        }
        .success {
            color: #0d7033;
            font-weight: bold;
        }
        .danger {
            color: #b61818;
            font-weight: bold;
        }
        .nota {
            font-style: italic;
            color: #555;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center">Estado de Cuenta del Guardia</h1>
    <p>
        <span class="label">Nombre:</span> {{ $data['guardia']['nombre'] }}
    </p>
    <p>
        <span class="label">Periodo:</span> {{ Carbon::parse($data['periodo']['inicio'])->format('d/m/Y') }} al {{ Carbon::parse($data['periodo']['fin'])->format('d/m/Y') }}
    </p>

    <div class="section">
        <h3>1. Sueldo y Días laborales</h3>
        <ul>
            <li>Sueldo base semanal: <span class="success">${{ number_format($data['guardia']['sueldo_base_semanal'], 2) }}</span></li>
            <li>Días laborales por semana: {{ $data['guardia']['dias_laborales_por_semana'] }}</li>
            <li>Sueldo diario: <span class="success">${{ number_format($data['guardia']['sueldo_diario'], 2) }}</span></li>
            <li>Días trabajados: {{ $data['guardia']['dias_trabajados'] }}</span></li>
            <li>Pago por días trabajados: <span class="success">${{ number_format($data['ingresos']['pago_dias_trabajados'], 2) }}</span></li>
            <li>Pago si no hubiera faltado: ${{ number_format($data['ingresos']['pago_no_faltado'], 2) }}</li>
        </ul>
    </div>

    <div class="section">
        <h3>2. Faltas</h3>
        @if(count($data['faltas']) > 0)
            <ul>
                @foreach($data['faltas'] as $falta)
                    <li>{{ $falta['cantidad_faltas'] }} falta(s) del {{ Carbon::parse($falta['fecha_inicio'])->format('d/m/Y') }} al {{ Carbon::parse($falta['fecha_fin'])->format('d/m/Y') }} - Descuento: <span class="danger">${{ number_format($falta['monto'], 2) }}</span></li>
                @endforeach
            </ul>
        @else
            <p>No hubo faltas.</p>
        @endif
    </div>

    <div class="section">
        <h3>3. Tiempo Extra</h3>
        @if(count($data['tiempo_extra']) > 0)
            <ul>
                @foreach($data['tiempo_extra'] as $extra)
                    <li>{{ $extra['horas'] }} horas del {{ Carbon::parse($extra['fecha_inicio'])->format('d/m/Y') }} al {{ Carbon::parse($extra['fecha_fin'])->format('d/m/Y') }} a ${{ number_format($extra['monto_por_hora'], 2) }}/h: <span class="success">${{ number_format($extra['monto_total'], 2) }}</span></li>
                @endforeach
            </ul>
        @else
            <p>No tuvo tiempo extra en este periodo.</p>
        @endif
    </div>

    <div class="section">
        <h3>4. Vacaciones</h3>
        @if(count($data['vacaciones']) > 0)
            <ul>
                @foreach($data['vacaciones'] as $vac)
                    <li>Del {{ Carbon::parse($vac['fecha_inicio'])->format('d/m/Y') }} al {{ Carbon::parse($vac['fecha_fin'])->format('d/m/Y') }} ({{ $vac['dias_totales'] }} días) - Prima vacacional: <span class="success">${{ number_format($vac['prima_vacacional'], 2) }}</span> @if($vac['observaciones']) - Obs: {{ $vac['observaciones'] }} @endif</li>
                @endforeach
            </ul>
        @else
            <p>No tomó vacaciones en este periodo.</p>
        @endif
    </div>

    <div class="section">
        <h3>5. Incapacidades</h3>
        @if(count($data['incapacidades']) > 0)
            <ul>
                @foreach($data['incapacidades'] as $incap)
                    <li>
                        {{ $incap['motivo'] ?? 'Motivo no especificado' }}: del {{ Carbon::parse($incap['fecha_inicio'])->format('d/m/Y') }} al {{ Carbon::parse($incap['fecha_fin'])->format('d/m/Y') }}
                        - Pago de la empresa:
                        @if($incap['pago_empresa'] > 0)
                            <span class="success">${{ number_format($incap['pago_empresa'], 2) }}</span>
                        @else
                            <span class="danger">${{ number_format($incap['pago_empresa'], 2) }}</span>
                        @endif
                        @if($incap['observaciones']) - Obs: {{ $incap['observaciones'] }} @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>No estuvo incapacitado en este periodo.</p>
        @endif
    </div>

    <div class="section">
        <h3>6. Descuentos</h3>
        @if(count($data['descuentos']) > 0)
            <ul>
                @foreach($data['descuentos'] as $desc)
                    <li>
                        {{ $desc['modulo_descuento']['nombre'] }}
                        @if($desc['modulo_descuento']['descripcion']) ({{ $desc['modulo_descuento']['descripcion'] }}) @endif
                         - <span class="danger">${{ number_format($desc['monto'], 2) }}</span>
                        @if($desc['observaciones'])</span> - Obs: {{ $desc['motivo'] }} @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>No hay descuentos aplicados.</p>
        @endif
    </div>

    <div class="section">
        <h3>7. Préstamos</h3>
        @if(count($data['prestamos']) > 0)
            @foreach($data['prestamos'] as $prestamo)
                <p style="margin-bottom: 0px">Préstamo de ${{ number_format($prestamo['monto_total'], 2) }} ({{ count($prestamo['abonos']) }}/{{ $prestamo['numero_pagos'] }} pagos) -
                    @if($data['egresos']['prestamos'] > 0)
                        Monto restante: <span class="danger">${{ number_format($data['egresos']['prestamos'], 2) }}</span>
                    @else
                        Estado: <span class="success">{{ $prestamo['estatus'] }}</span>
                    @endif
                </p>
                <p style="margin-top: 0px">
                    Motivo: <u>{{ $prestamo['modulo_prestamo']['nombre'] }}</u>
                </p>
                <ul>
                    @foreach($prestamo['abonos'] as $abono)
                        <li>Abono de ${{ number_format($abono['monto'], 2) }} el {{ Carbon::parse($abono['fecha'])->format('d/m/Y') }} por {{ $abono['metodo_pago'] }} @if($abono['observaciones']) - Obs: {{ $abono['observaciones'] }} @endif</li>
                    @endforeach
                </ul>
            @endforeach
        @else
            <p>No tiene préstamos registrados.</p>
        @endif
    </div>

    @if(isset($data['tiempo_trabajado_total']))
        <div class="section" style="background: #eef9e9; margin-top: 25px;">
            <h3 style="color: #198754; margin-bottom: 12px;">8. Tiempo total trabajado en el período</h3>
            <p style="font-size: 13px;">
                {{ $data['tiempo_trabajado_total']['formato'] ?? '0 segundos' }}
            </p>
            <p class="nota">* Sólo se considera el tiempo de los registros con check-in y check-out completos.</p>
        </div>
    @endif

    <div class="section resumen">
        <h3>Resumen Final</h3>

        <div class="row">
            <span class="label">Total ingresos:</span>
            <span class="highlight ingresos">${{ number_format($data['totales']['total_ingresos'], 2) }} MXN</span>
        </div>

        <div style="margin-left: 20px;">
            <p>- Pago por días trabajados: ${{ number_format($data['ingresos']['pago_dias_trabajados'], 2) }}</p>
            <p>- Tiempo extra: ${{ number_format($data['ingresos']['tiempo_extra'], 2) }}</p>
            <p>- Prima vacacional: ${{ number_format($data['ingresos']['prima_vacacional'], 2) }}</p>
            <p>- Incapacidades pagadas: ${{ number_format($data['ingresos']['incapacidades_pagadas'], 2) }}</p>
        </div>

        <div class="total-line"></div>

        <div class="row">
            <span class="label">Total egresos:</span>
            <span class="highlight egresos">${{ number_format($data['totales']['total_egresos'], 2) }} MXN</span>
        </div>

        <div style="margin-left: 20px;">
            <p>- Faltas: ${{ number_format($data['egresos']['faltas'], 2) }}</p>
            <p>- Descuentos: ${{ number_format($data['egresos']['descuentos'], 2) }}</p>
            <p>- Préstamos (pendientes): ${{ number_format($data['egresos']['prestamos'], 2) }}</p>
            <p>- Incapacidades no pagadas: ${{ number_format($data['egresos']['incapacidades_no_pagadas'], 2) }}</p>
            <p class="nota">Las incapacidades no cubiertas por la empresa se descuentan porque representan días no laborados sin derecho a sueldo.</p>
        </div>

        <div class="total-line"></div>

        <div class="row">
            <span class="label">Prestaciones (retenciones legales):</span>
            <span class="highlight egresos">${{ number_format($data['totales']['total_prestaciones'], 2) }} MXN</span>
        </div>
        <div style="margin-left: 20px;">
            <p>- IMSS: ${{ number_format($data['prestaciones']['imss'], 2) }}</p>
            <p>- INFONAVIT: ${{ number_format($data['prestaciones']['infonavit'], 2) }}</p>
            <p>- FONACOT: ${{ number_format($data['prestaciones']['fonacot'], 2) }}</p>
            <p>- Retención ISR: ${{ number_format($data['prestaciones']['retencion_isr'], 2) }}</p>
            <p>- Aguinaldo: ${{ number_format($data['guardia']['aguinaldo'], 2) }}</p>
            <p class="nota">El aguinaldo no se ha sumado ni al sueldo bruto, ni al sueldo neto.</p>
        </div>

        <div class="total-line"></div>

        <div class="row">
            <span class="label">Pago bruto:</span>
            <span class="highlight ingresos">${{ number_format($data['totales']['pago_bruto'], 2) }} MXN</span>
        </div>
        <div class="row">
            <span class="label">Pago neto:</span>
            <span class="highlight ingresos">${{ number_format($data['totales']['pago_neto'], 2) }} MXN</span>
        </div>
    </div>
</body>
</html>
