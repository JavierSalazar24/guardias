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
      required: false,
      type: 'number',
      step: '0.01',
      label: 'Pago por parte de la empresa',
      name: 'pago_empresa'
    },
    { required: false, type: 'textarea', label: 'Motivo', name: 'motivo' },
    {
      required: false,
      type: 'textarea',
      label: 'Observaciones',
      name: 'observaciones'
    }
  ]
}
