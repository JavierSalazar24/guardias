@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comprobante de Pago</title>
  <style>
    * {
        font-family: 'Arial', sans-serif;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 2rem;
        background: #fff;
        color: #333;
        font-size: 14px;
    }

    h1, h2 {
        text-align: center;
        color: #1c3d5a;
    }

    .section {
        margin-bottom: 2rem;
        page-break-inside: avoid;
    }

    .label {
        font-weight: bold;
        color: #1c3d5a;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f0f4f8;
        color: #1c3d5a;
    }

    .total {
        font-weight: bold;
        background-color: #f9fafb;
    }
  </style>
</head>
<body>
  <h1>Comprobante de Pago</h1>
  <h2>{{ $pago->guardia->nombre }} {{ $pago->guardia->apellido_p }} {{ $pago->guardia->apellido_m }} (Número de empleado: {{ $pago->guardia->numero_empleado }})</h2>

  <div class="section">
    <span class="label">Período:</span>
    {{ Carbon::parse($pago->periodo_inicio)->format('d/m/Y') }} - {{ Carbon::parse($pago->periodo_fin)->format('d/m/Y') }}
  </div>

  <div class="section">
    <h3>Ingresos</h3>
    <table>
      <tr><th>Concepto</th><th>Monto</th></tr>
      <tr><td>Días trabajados</td><td>${{ number_format($pago->dias_trabajados, 2) }} MXN.</td></tr>
      <tr><td>Tiempo extra</td><td>${{ number_format($pago->tiempo_extra, 2) }} MXN.</td></tr>
      <tr><td>Prima vacacional</td><td>${{ number_format($pago->prima_vacacional, 2) }} MXN.</td></tr>
      <tr><td>Incapacidades pagadas</td><td>${{ number_format($pago->incapacidades_pagadas, 2) }} MXN.</td></tr>
      <tr class="total"><td>Total ingresos</td><td>${{ number_format($pago->total_ingresos, 2) }} MXN.</td></tr>
    </table>
  </div>

  <div class="section">
    <h3>Egresos</h3>
    <table>
      <tr><th>Concepto</th><th>Monto</th></tr>
      <tr><td>Descuentos</td><td>${{ number_format($pago->descuentos, 2) }} MXN.</td></tr>
      <tr><td>Descuentos por faltas</td><td>${{ number_format($pago->faltas, 2) }} MXN.</td></tr>
      <tr><td>Incapacidades no pagadas</td><td>${{ number_format($pago->incapacidades_no_pagadas, 2) }} MXN.</td></tr>
      <tr class="total"><td>Total egresos</td><td>${{ number_format($pago->total_egresos, 2) }} MXN.</td></tr>
    </table>
  </div>

  <div class="section">
    <h3>Retenciones legales</h3>
    <table>
      <tr><th>Concepto</th><th>Monto</th></tr>
      <tr><td>IMSS</td><td>${{ number_format($pago->imss, 2) }} MXN.</td></tr>
      <tr><td>Infonavit</td><td>${{ number_format($pago->infonavit, 2) }} MXN.</td></tr>
      <tr><td>Fonacot</td><td>${{ number_format($pago->fonacot, 2) }} MXN.</td></tr>
      <tr><td>Retención ISR</td><td>${{ number_format($pago->retencion_isr, 2) }} MXN.</td></tr>
      <tr class="total"><td>Total retenciones</td><td>${{ number_format($pago->total_retenciones, 2) }} MXN.</td></tr>
    </table>
  </div>

  <div class="section">
    <h3>Resumen</h3>
    <table>
      <tr><td class="label">Pago bruto</td><td>${{ number_format($pago->pago_bruto, 2) }} MXN.</td></tr>
      <tr><td class="label">Pago final</td><td><strong>${{ number_format($pago->pago_final, 2) }} MXN.</strong></td></tr>
    </table>
  </div>

  @if ($pago->observaciones)
    <div class="section">
      <h3>Observaciones</h3>
      <p>{{ $pago->observaciones }}</p>
    </div>
  @endif
</body>
</html>
