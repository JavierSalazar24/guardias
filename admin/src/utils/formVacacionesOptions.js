export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona al guardia *',
      name: 'guardia_id'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de inicio *',
      name: 'fecha_inicio'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de fin *',
      name: 'fecha_fin'
    },
    {
      required: true,
      type: 'number',
      label: 'Días totales de vacaciones *',
      name: 'dias_totales'
    },
    {
      required: false,
      type: 'number',
      step: '0.01',
      label: 'Prima vacacional ($)',
      name: 'prima_vacacional'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Observaciones',
      name: 'observaciones'
    }
  ]
}
