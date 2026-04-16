const options = [
  { label: 'Lista negra', value: 'guardias' },
  { label: 'Equipo asignado ya devuelto', value: 'equipamiento' },
  { label: 'Incapacidades (RRHH)', value: 'incapacidades' },
  { label: 'Tiempo Extra (RRHH)', value: 'tiempo_extra' },
  { label: 'Faltas (RRHH)', value: 'faltas' },
  { label: 'Descuentos (RRHH)', value: 'descuentos' },
  { label: 'Vacaciones (RRHH)', value: 'vacaciones' },
  { label: 'Préstamos pagados (RRHH)', value: 'prestamos' },
  { label: 'Pagos a guardias (RRHH)', value: 'pagos_empleados' },
  { label: 'Check-in/out (Reportes de servicios)', value: 'check_guardia' },
  {
    label: 'Reporte de bitácoras (Reportes de servicios)',
    value: 'reporte_bitacoras'
  },
  {
    label: 'Reporte de incidentes (Reportes de servicios)',
    value: 'reportes_incidentes_guardia'
  },
  {
    label: 'Reporte de guardias (Reportes de servicios)',
    value: 'reportes_guardia'
  },
  {
    label: 'Reporte de supervisores (Reportes de servicios)',
    value: 'reportes_supervisor'
  },
  {
    label: 'Reporte de patrullas (Reportes de servicios)',
    value: 'reportes_patrulla'
  },
  {
    label: 'Recorridos (Reportes de servicios)',
    value: 'qr_recorridos_guardia'
  },
  { label: 'Cotizaciones aceptadas', value: 'cotizaciones' },
  { label: 'Ventas pagadas o canceladas', value: 'ventas' },
  {
    label: 'Ordenes de servicio finalizadas o canceladas',
    value: 'ordenes_servicios'
  },
  { label: 'Boletas de gasolina', value: 'boletas_gasolina' },
  { label: 'Ordenes de compra pagadas (Compras)', value: 'ordenes_compra' },
  { label: 'Gastos', value: 'gastos' }
]

const valueToLabelMap = new Map(options.map((opt) => [opt.value, opt.label]))

export function getLabelByValue(value) {
  return valueToLabelMap.get(value) || null
}
