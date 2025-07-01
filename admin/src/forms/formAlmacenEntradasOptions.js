export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona el artículo *',
      name: 'articulo_id'
    },
    {
      required: true,
      type: 'text',
      label: 'Número de serie *',
      name: 'numero_serie'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de entrada *',
      name: 'fecha_entrada'
    },
    {
      required: true,
      type: 'select',
      label: 'Tipo de entrada *',
      name: 'tipo_entrada',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Compra', value: 'Compra' },
        { label: 'Devolución de guardia', value: 'Devolución de guardia' },
        { label: 'Cambio de equipo', value: 'Cambio de equipo' },
        { label: 'Reparación terminada', value: 'Reparación terminada' },
        { label: 'Otro', value: 'Otro' }
      ]
    }
  ]
}
