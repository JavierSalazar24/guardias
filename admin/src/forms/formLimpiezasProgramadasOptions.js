export const formOptions = {
  addTableFields: [
    {
      required: true,
      type: 'select',
      label: 'Tabla *',
      name: 'tabla',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Lista negra', value: 'guardias' },
        { label: 'Equipo asignado ya devuelto', value: 'equipamiento' },
        { label: 'Incapacidades (RRHH)', value: 'incapacidades' },
        { label: 'Tiempo Extra (RRHH)', value: 'tiempo_extra' },
        { label: 'Faltas (RRHH)', value: 'faltas' },
        { label: 'Descuentos (RRHH)', value: 'descuentos' },
        { label: 'Vacaciones (RRHH)', value: 'vacaciones' },
        { label: 'Préstamos pagados (RRHH)', value: 'prestamos' },
        { label: 'Pagos a guardias (RRHH)', value: 'pagos_empleados' },
        // {
        //   label: 'Check-in/out (Reportes de servicios)',
        //   value: 'check_guardia'
        // },
        // {
        //   label: 'Reporte de bitácoras (Reportes de servicios)',
        //   value: 'reporte_bitacoras'
        // },
        // {
        //   label: 'Reporte de incidentes (Reportes de servicios)',
        //   value: 'reportes_incidentes_guardia'
        // },
        // {
        //   label: 'Reporte de guardias (Reportes de servicios)',
        //   value: 'reportes_guardia'
        // },
        // {
        //   label: 'Reporte de supervisores (Reportes de servicios)',
        //   value: 'reportes_supervisor'
        // },
        // {
        //   label: 'Reporte de patrullas (Reportes de servicios)',
        //   value: 'reportes_patrulla'
        // },
        // {
        //   label: 'Recorridos (Reportes de servicios)',
        //   value: 'qr_recorridos_guardia'
        // },
        { label: 'Cotizaciones aceptadas', value: 'cotizaciones' },
        { label: 'Ventas pagadas o canceladas', value: 'ventas' },
        {
          label: 'Ordenes de servicio finalizadas o canceladas',
          value: 'ordenes_servicios'
        },
        { label: 'Boletas de gasolina', value: 'boletas_gasolina' },
        {
          label: 'Ordenes de compra pagadas (Compras)',
          value: 'ordenes_compra'
        },
        { label: 'Gastos', value: 'gastos' }
      ]
    }
  ],

  generalFields: [
    {
      required: true,
      type: 'number',
      step: '1',
      label: '¿Después de...? *',
      placeholder: '1,2,3,7,10...',
      name: 'periodo_cantidad'
    },
    {
      required: true,
      type: 'select',
      label: '¿...días, semanas, meses o años? *',
      name: 'periodo_tipo',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Día(s)', value: 'dias' },
        { label: 'Semana(s)', value: 'semanas' },
        { label: 'Mes(es)', value: 'meses' },
        { label: 'Año(s)', value: 'anios' }
      ]
    }
  ],

  activoFields: [
    {
      required: true,
      type: 'select',
      label: 'Selecciona el estatus de la limpieza *',
      name: 'activa',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Activada', value: 'true' },
        { label: 'Desactivada', value: 'false' }
      ]
    }
  ]
}
