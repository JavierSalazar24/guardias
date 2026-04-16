<?php
    use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Cuenta del Guardia <?php echo e($data['guardia']['nombre']); ?></title>
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

        /* Guard Info Card */
        .guard-info {
            background: white;
            border: 2px solid #1a365d;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(26, 54, 93, 0.1);
        }

        .guard-info-grid {
            display: table;
            width: 100%;
        }

        .guard-info-row {
            display: table-row;
        }

        .guard-info-cell {
            display: table-cell;
            padding: 8px 15px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .guard-info-cell:first-child {
            background-color: #1a365d;
            color: white;
            font-weight: bold;
            width: 25%;
            text-align: center;
        }

        .guard-info-cell:last-child {
            background-color: white;
            color: #2d3748;
        }

        /* Section Styles */
        .section {
            background: white;
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

        /* List Styles */
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
            display: table;
            width: 100%;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #1a365d;
            width: 60%;
        }

        .info-value {
            display: table-cell;
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            font-size: 16px;
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

        .amount.neutral {
            color: #1a365d;
        }

        /* Detail Lists */
        .detail-list {
            list-style: none;
            padding: 0;
            margin: 15px 0 0 0;
        }

        .detail-list li {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
        }

        .detail-list li:last-child {
            margin-bottom: 0;
        }

        .detail-date {
            font-weight: bold;
            color: #1a365d;
        }

        .detail-amount {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        .detail-obs {
            font-style: italic;
            color: #718096;
            font-size: 10px;
            margin-top: 5px;
        }

        /* Loan Section */
        .loan-item {
            background: #f0f4f8;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .loan-header {
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 10px;
        }

        .loan-status {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .loan-payments {
            list-style: none;
            padding: 0;
            margin: 10px 0 0 0;
        }

        .loan-payments li {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 5px;
            font-size: 10px;
        }

        /* Time Worked Section */
        .time-worked {
            background: #f0fff4;
            border: 2px solid #68d391;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .time-worked h3 {
            color: #22543d;
            margin: 0 0 15px 0;
        }

        .time-display {
            font-size: 18px;
            font-weight: bold;
            color: #22543d;
            font-family: 'Courier New', monospace;
            margin-bottom: 10px;
        }

        .time-note {
            font-style: italic;
            color: #4a5568;
            font-size: 10px;
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

        .summary-section {
            background: white;
            color: #2d3748;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: left;
        }

        .summary-section:last-child {
            margin-bottom: 0;
        }

        .summary-title {
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: #2c5282;
            padding: 10px 15px;
            margin: -20px -20px 15px -20px;
            text-transform: uppercase;
        }

        .summary-total {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .summary-total-label {
            display: table-cell;
            font-size: 16px;
            font-weight: bold;
            color: #1a365d;
        }

        .summary-total-value {
            display: table-cell;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .summary-total-value.ingresos {
            background: #38a169;
            color: white;
        }

        .summary-total-value.egresos {
            background: #e53e3e;
            color: white;
        }

        .summary-total-value.prestaciones {
            background: #d69e2e;
            color: white;
        }

        .summary-total-value.bruto {
            background: #1a365d;
            color: white;
        }

        .summary-total-value.neto {
            background: #22543d;
            color: white;
        }

        .summary-breakdown {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .summary-breakdown li {
            padding: 6px 0;
            border-bottom: 1px solid #e2e8f0;
            display: table;
            width: 100%;
        }

        .summary-breakdown li:last-child {
            border-bottom: none;
        }

        .breakdown-label {
            display: table-cell;
            color: #4a5568;
        }

        .breakdown-value {
            display: table-cell;
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #2d3748;
        }

        .breakdown-note {
            font-style: italic;
            color: #718096;
            font-size: 10px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 30px 20px;
            color: #718096;
            font-style: italic;
        }

        .empty-state::before {
            content: "✅";
            display: block;
            font-size: 24px;
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

        .section-break {
            page-break-inside: avoid !important;
            break-inside: avoid-page !important;
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Estado de Cuenta del Guardia</h1>
        <div class="logo-container">
            <img src="<?php echo e(public_path('logo/logo2.png')); ?>" alt="Logo de la empresa" class="logo" />
        </div>
        <div class="subtitle">Reporte Financiero del Guardia</div>
    </div>

    <div class="guard-info">
        <div class="guard-info-grid">
            <div class="guard-info-row">
                <div class="guard-info-cell">Nombre</div>
                <div class="guard-info-cell"><?php echo e($data['guardia']['nombre']); ?></div>
            </div>
            <div class="guard-info-row">
                <div class="guard-info-cell">Período</div>
                <div class="guard-info-cell"><?php echo e(Carbon::parse($data['periodo']['inicio'])->format('d/m/Y')); ?> al <?php echo e(Carbon::parse($data['periodo']['fin'])->format('d/m/Y')); ?></div>
            </div>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">Sueldo y Días Laborales</h3>
        <div class="section-content">
            <ul class="info-list">
                <li>
                    <span class="info-label">Sueldo base quincenal:</span>
                    <span class="info-value amount positive">$<?php echo e(number_format($data['guardia']['sueldo_base_quincenal'], 2)); ?></span>
                </li>
                <li>
                    <span class="info-label">Días laborales por semana:</span>
                    <span class="info-value"><?php echo e($data['guardia']['dias_laborales_por_semana']); ?></span>
                </li>
                <li>
                    <span class="info-label">Sueldo diario:</span>
                    <span class="info-value amount positive">$<?php echo e(number_format($data['guardia']['sueldo_diario'], 2)); ?></span>
                </li>
                <li>
                    <span class="info-label">Días trabajados:</span>
                    <span class="info-value"><?php echo e($data['guardia']['dias_trabajados']); ?></span>
                </li>
                <li>
                    <span class="info-label">Pago por días trabajados:</span>
                    <span class="info-value amount positive">$<?php echo e(number_format($data['ingresos']['pago_dias_trabajados'], 2)); ?></span>
                </li>
                <li>
                    <span class="info-label">Pago si no hubiera faltado:</span>
                    <span class="info-value amount neutral">$<?php echo e(number_format($data['ingresos']['pago_no_faltado'], 2)); ?></span>
                </li>
            </ul>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">Faltas</h3>
        <div class="section-content">
            <?php if(count($data['faltas']) > 0): ?>
                <ul class="detail-list">
                    <?php $__currentLoopData = $data['faltas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $falta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="detail-date"><?php echo e($falta['cantidad_faltas']); ?> falta(s)</div>
                            <div>Del <?php echo e(Carbon::parse($falta['fecha_inicio'])->format('d/m/Y')); ?> al <?php echo e(Carbon::parse($falta['fecha_fin'])->format('d/m/Y')); ?></div>
                            <div>Descuento x falta: <span class="detail-amount amount negative">$<?php echo e(number_format($falta['descuento_falta'], 2)); ?></span></div>
                            <div><strong>Descuento:</strong> <span class="detail-amount amount negative">$<?php echo e(number_format($falta['monto'], 2)); ?></span></div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <div class="empty-state">
                    No hubo faltas en este período.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">Tiempo Extra</h3>
        <div class="section-content">
            <?php if(count($data['tiempo_extra']) > 0): ?>
                <ul class="detail-list">
                    <?php $__currentLoopData = $data['tiempo_extra']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="detail-date"><?php echo e($extra['horas']); ?> horas extra</div>
                            <div>Del <?php echo e(Carbon::parse($extra['fecha_inicio'])->format('d/m/Y')); ?> al <?php echo e(Carbon::parse($extra['fecha_fin'])->format('d/m/Y')); ?></div>
                            <div>Tarifa: $<?php echo e(number_format($extra['monto_por_hora'], 2)); ?>/hora</div>
                            <div>Total: <span class="detail-amount amount positive">$<?php echo e(number_format($extra['monto_total'], 2)); ?></span></div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <div class="empty-state">
                    No tuvo tiempo extra en este período.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">Vacaciones</h3>
        <div class="section-content">
            <?php if(count($data['vacaciones']) > 0): ?>
                <ul class="detail-list">
                    <?php $__currentLoopData = $data['vacaciones']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="detail-date">Vacaciones (<?php echo e($vac['dias_totales']); ?> días)</div>
                            <div>Del <?php echo e(Carbon::parse($vac['fecha_inicio'])->format('d/m/Y')); ?> al <?php echo e(Carbon::parse($vac['fecha_fin'])->format('d/m/Y')); ?></div>
                            <div>Prima vacacional: <span class="detail-amount amount positive">$<?php echo e(number_format($vac['prima_vacacional'], 2)); ?></span></div>
                            <?php if($vac['observaciones']): ?>
                                <div class="detail-obs">Observaciones: <?php echo e($vac['observaciones']); ?></div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <div class="empty-state">
                    No tomó vacaciones en este período.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">Incapacidades</h3>
        <div class="section-content">
            <?php if(count($data['incapacidades']) > 0): ?>
                <ul class="detail-list">
                    <?php $__currentLoopData = $data['incapacidades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div><strong>Motivo:</strong> <?php echo e($incap['motivo'] ?? 'Motivo no especificado'); ?></div>
                            <div>Del <?php echo e(Carbon::parse($incap['fecha_inicio'])->format('d/m/Y')); ?> al <?php echo e(Carbon::parse($incap['fecha_fin'])->format('d/m/Y')); ?></div>
                            <div>Pago de la empresa:
                                <?php if($incap['pago_empresa'] > 0): ?>
                                    <span class="detail-amount amount positive">$<?php echo e(number_format($incap['pago_empresa'], 2)); ?></span>
                                <?php else: ?>
                                    <span class="detail-amount amount negative">$<?php echo e(number_format($incap['pago_empresa'], 2)); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if($incap['observaciones']): ?>
                                <div class="detail-obs">Observaciones: <?php echo e($incap['observaciones']); ?></div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <div class="empty-state">
                    No estuvo incapacitado en este período.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">Descuentos</h3>
        <div class="section-content">
            <?php if(count($data['descuentos']) > 0): ?>
                <ul class="detail-list">
                    <?php $__currentLoopData = $data['descuentos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div><strong>Motivo:</strong> <?php echo e($desc['modulo_descuento']['nombre']); ?></div>
                            <div><strong>Monto:</strong> <span class="detail-amount amount negative">$<?php echo e(number_format($desc['monto'], 2)); ?></span></div>
                            <?php if($desc['observaciones']): ?>
                                <div class="detail-obs">Obsvervaciones: <?php echo e($desc['observaciones']); ?></div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <div class="empty-state">
                    No hay descuentos aplicados.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section">
        <h3 class="section-header">Préstamos</h3>
        <div class="section-content">
            <?php if(count($data['prestamos']) > 0): ?>
                <?php $__currentLoopData = $data['prestamos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prestamo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $totalAbonado = collect($prestamo['abonos'])->sum('monto');
                        $totalRestante = $prestamo['monto_total'] - $totalAbonado;
                    ?>
                    <div class="loan-item">
                        <div class="loan-header">
                            Préstamo de $<?php echo e(number_format($prestamo['monto_total'], 2)); ?>

                        </div>
                        <div class="loan-status">
                            Progreso: <?php echo e(count($prestamo['abonos'])); ?>/<?php echo e($prestamo['numero_pagos']); ?> pagos -
                            <?php if($totalRestante > 0): ?>
                                Monto restante: <span class="amount negative">$<?php echo e(number_format($totalRestante, 2)); ?></span>
                            <?php else: ?>
                                Estado: <span class="amount positive"><?php echo e($prestamo['estatus']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div><strong>Motivo:</strong> <?php echo e($prestamo['modulo_prestamo']['nombre']); ?></div>

                        <?php if(count($prestamo['abonos']) > 0): ?>
                            <ul class="loan-payments">
                                <?php $__currentLoopData = $prestamo['abonos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abono): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <strong>$<?php echo e(number_format($abono['monto'], 2)); ?></strong> - <?php echo e(Carbon::parse($abono['fecha'])->format('d/m/Y')); ?> - <?php echo e($abono['metodo_pago']); ?>

                                        <?php if($abono['observaciones']): ?> - <em><?php echo e($abono['observaciones']); ?></em> <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="empty-state">
                    No tiene préstamos registrados.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section resumen">
        <h2>📊 Resumen Final</h2>

        <div class="summary-section">
            <div class="summary-title">Total Ingresos</div>
            <div class="summary-total">
                <div class="summary-total-label">Total Ingresos:</div>
                <div class="summary-total-value ingresos">$<?php echo e(number_format($data['totales']['total_ingresos'], 2)); ?> MXN</div>
            </div>
            <ul class="summary-breakdown">
                <li>
                    <span class="breakdown-label">Pago por días trabajados:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['ingresos']['pago_dias_trabajados'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">Tiempo extra:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['ingresos']['tiempo_extra'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">Prima vacacional:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['ingresos']['prima_vacacional'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">Incapacidades pagadas:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['ingresos']['incapacidades_pagadas'], 2)); ?></span>
                </li>
            </ul>
        </div>

        <div class="summary-section">
            <div class="summary-title">Total Egresos</div>
            <div class="summary-total">
                <div class="summary-total-label">Total Egresos:</div>
                <div class="summary-total-value egresos">$<?php echo e(number_format($data['totales']['total_egresos'], 2)); ?> MXN</div>
            </div>
            <ul class="summary-breakdown">
                <li>
                    <span class="breakdown-label">Faltas:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['egresos']['faltas'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">Descuentos:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['egresos']['descuentos'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">Préstamos (pendientes):</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['egresos']['prestamos'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">Incapacidades no pagadas:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['egresos']['incapacidades_no_pagadas'], 2)); ?></span>
                </li>
            </ul>
            <div class="breakdown-note">
                Las incapacidades no cubiertas por la empresa se descuentan porque representan días no laborados sin derecho a sueldo.
            </div>
        </div>
    </div>

    <div class="section-break"></div>

    <div class="section resumen">

        <div class="summary-section">
            <div class="summary-title">Prestaciones (Retenciones Legales)</div>
            <div class="summary-total">
                <div class="summary-total-label">Total Prestaciones:</div>
                <div class="summary-total-value prestaciones">$<?php echo e(number_format($data['totales']['total_prestaciones'], 2)); ?> MXN</div>
            </div>
            <ul class="summary-breakdown">
                <li>
                    <span class="breakdown-label">IMSS:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['prestaciones']['imss'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">INFONAVIT:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['prestaciones']['infonavit'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">FONACOT:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['prestaciones']['fonacot'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">Retención ISR:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['prestaciones']['retencion_isr'], 2)); ?></span>
                </li>
                <li>
                    <span class="breakdown-label">Aguinaldo:</span>
                    <span class="breakdown-value">$<?php echo e(number_format($data['guardia']['aguinaldo'], 2)); ?></span>
                </li>
            </ul>
            <div class="breakdown-note">
                El aguinaldo no se ha sumado ni al sueldo bruto, ni al sueldo neto.
            </div>
        </div>

        <div class="summary-section">
            <div class="summary-title">Totales Finales</div>
            <div class="summary-total">
                <div class="summary-total-label">Pago Bruto:</div>
                <div class="summary-total-value bruto">$<?php echo e(number_format($data['totales']['pago_bruto'], 2)); ?> MXN</div>
            </div>
            <div class="summary-total">
                <div class="summary-total-label">Pago Neto:</div>
                <div class="summary-total-value neto">$<?php echo e(number_format($data['totales']['pago_neto'], 2)); ?> MXN</div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\javie\OneDrive\Desktop\guardias\backend\resources\views/pdf/estado_cuenta_guardia.blade.php ENDPATH**/ ?>