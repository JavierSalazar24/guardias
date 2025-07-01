export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre del servicio *',
      name: 'nombre'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Costo del servicio *',
      name: 'costo'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Descripción',
      name: 'descripcion'
    }
  ]
}
