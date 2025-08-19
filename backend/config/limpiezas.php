<?php

return [
    'guardias' => [
        'label' => 'Guardias',
        'model' => \App\Models\Guardia::class,
        'archivos' => [
            ['campo' => 'foto', 'carpeta' => 'fotos_guardias'],
            ['campo' => 'curp', 'carpeta' => 'documentos_guardias'],
            ['campo' => 'ine', 'carpeta' => 'documentos_guardias'],
            ['campo' => 'acta_nacimiento', 'carpeta' => 'documentos_guardias'],
            ['campo' => 'comprobante_domicilio', 'carpeta' => 'documentos_guardias'],
            ['campo' => 'constancia_situacion_fiscal', 'carpeta' => 'documentos_guardias'],
            ['campo' => 'comprobante_estudios', 'carpeta' => 'documentos_guardias'],
            ['campo' => 'carta_recomendacion', 'carpeta' => 'documentos_guardias'],
            ['campo' => 'antecedentes_no_penales', 'carpeta' => 'documentos_guardias'],
            ['campo' => 'antidoping', 'carpeta' => 'documentos_guardias'],
        ],
        'condicion' => [
            'campo' => 'eliminado',
            'operador' => '=', // puede ser '=', '!=', '<>', '!= null', 'LIKE', etc.
            'valor' => true,
        ],
        'campo_fecha' => 'updated_at',
    ],
    'equipamiento' => [
        'label' => 'Equipamiento',
        'model' => \App\Models\Equipamiento::class,
        'condicion' => [
            'campo' => 'fecha_devuelto',
            'operador' => '!=', // "no sea null"
            'valor' => null,
        ],
    ],
    'incapacidades' => [
        'label' => 'Incapacidades',
        'model' => \App\Models\Incapacidad::class,
    ],
    'tiempo_extra' => [
        'label' => 'Tiempo extra',
        'model' => \App\Models\TiempoExtra::class,
    ],
    'faltas' => [
        'label' => 'Faltas',
        'model' => \App\Models\Falta::class,
    ],
    'descuentos' => [
        'label' => 'Descuentos',
        'model' => \App\Models\Descuento::class,
    ],
    'vacaciones' => [
        'label' => 'Vacaciones',
        'model' => \App\Models\Vacacion::class,
    ],
    'prestamos' => [
        'label' => 'Préstamos',
        'model' => \App\Models\Prestamo::class,
        'condicion' => [
            'campo' => 'saldo_restante',
            'operador' => '=',
            'valor' => 0,
        ],
    ],
    'pagos_empleados' => [
        'label' => 'Pagos empleados',
        'model' => \App\Models\PagoEmpleado::class,
    ],
    'check_guardia' => [
        'label' => 'Check guardia',
        'model' => \App\Models\CheckGuardia::class,
        'archivos' => [
            ['campo' => 'foto', 'carpeta' => 'check_guardia'],
            ['campo' => 'foto_salida', 'carpeta' => 'check_guardia'],
        ],
        'condicion' => [
            'campo' => 'fecha_salida',
            'operador' => '!=',
            'valor' => null,
        ],
    ],
    'reporte_bitacoras' => [
        'label' => 'Bitácoras',
        'model' => \App\Models\ReporteBitacora::class,
    ],
    'reportes_incidentes_guardia' => [
        'label' => 'Incidentes guardia',
        'model' => \App\Models\ReporteIncidenteGuardia::class,
        'archivos' => [
            ['campo' => 'foto', 'carpeta' => 'incidentes_guardia'],
        ],
    ],
    'reportes_guardia' => [
        'label' => 'Reportes guardia',
        'model' => \App\Models\ReporteGuardia::class,
    ],
    'reportes_supervisor' => [
        'label' => 'Reportes supervisor',
        'model' => \App\Models\ReporteSupervisor::class,
    ],
    'reportes_patrulla' => [
        'label' => 'Reportes patrulla',
        'model' => \App\Models\ReportePatrulla::class,
    ],
    'qr_recorridos_guardia' => [
        'label' => 'QR recorridos',
        'model' => \App\Models\QrRecorridoGuardia::class,
        'archivos' => [
            ['campo' => 'foto', 'carpeta' => 'recorridos_guardias'],
        ],
    ],
    'cotizaciones' => [
        'label' => 'Cotizaciones',
        'model' => \App\Models\Cotizacion::class,
        'condicion' => [
            'campo' => 'aceptada',
            'operador' => 'LIKE',
            'valor' => '%SI%',
        ],
    ],
    'ventas' => [
        'label' => 'Ventas',
        'model' => \App\Models\Venta::class,
        'condiciones' => [
            [
                'campo' => 'estatus',
                'operador' => '=',
                'valor' => 'Pagada'
            ],
            [
                'campo' => 'estatus',
                'operador' => '=',
                'valor' => 'Cancelada'
            ],
            [
                'campo' => 'eliminado',
                'operador' => '=',
                'valor' => true
            ]
        ],
        'condiciones_tipo' => 'OR',
        'campo_fecha' => 'updated_at',
    ],
    'ordenes_servicios' => [
        'label' => 'Órdenes de servicio',
        'model' => \App\Models\OrdenServicio::class,
        'condiciones' => [
            [
                'campo' => 'estatus',
                'operador' => '=',
                'valor' => 'Finalizada'
            ],
            [
                'campo' => 'estatus',
                'operador' => '=',
                'valor' => 'Cancelada'
            ],
            [
                'campo' => 'eliminado',
                'operador' => '=',
                'valor' => true
            ]
        ],
        'condiciones_tipo' => 'OR',
        'campo_fecha' => 'updated_at',
    ],
    'boletas_gasolina' => [
        'label' => 'Boletas gasolina',
        'model' => \App\Models\BoletaGasolina::class,
    ],
    'ordenes_compra' => [
        'label' => 'Órdenes de compra',
        'model' => \App\Models\OrdenCompra::class,
        'condiciones' => [
            [
                'campo' => 'estatus',
                'operador' => '=',
                'valor' => 'Pagada'
            ],
            [
                'campo' => 'estatus',
                'operador' => '=',
                'valor' => 'Cancelada'
            ],
        ],
        'condiciones_tipo' => 'OR',
        'campo_fecha' => 'updated_at',
    ],
    'gastos' => [
        'label' => 'Gastos',
        'model' => \App\Models\Gasto::class,
    ],
];
