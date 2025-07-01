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
      label: 'Fecha de entrega al guardia *',
      name: 'fecha_entrega'
    }
  ]
}
