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
      label: 'Horas extras trabajadas *',
      name: 'horas'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Monto x hora *',
      name: 'monto_por_hora'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Monto total *',
      name: 'monto_total'
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
