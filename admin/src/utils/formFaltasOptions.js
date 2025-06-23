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
      type: 'number',
      label: 'Cantidad de faltas *',
      name: 'cantidad_faltas'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Total de descuento *',
      name: 'monto'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de inicio del periodo *',
      name: 'fecha_inicio'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de fin del periodo *',
      name: 'fecha_fin'
    }
  ]
}
