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
      type: 'async',
      label: 'Tipo de descuento *',
      name: 'modulo_descuento_id'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Monto del descuento *',
      name: 'monto'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha del descuento *',
      name: 'fecha'
    }
  ]
}
