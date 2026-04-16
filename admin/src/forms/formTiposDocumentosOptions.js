export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'text',
      label:
        'Tipo de documento (ej. CURP, INE, Comprobante de estudios, etc.) *',
      name: 'nombre'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Descripción',
      name: 'descripcion'
    }
  ]
}
