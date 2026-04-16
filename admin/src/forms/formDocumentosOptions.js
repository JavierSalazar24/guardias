export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Tipo de documento *',
      name: 'tipo_documento_id'
    },
    {
      required: true,
      type: 'async',
      label: 'Guardia *',
      name: 'guardia_id'
    },
    {
      required: false,
      type: 'file',
      label: 'Documento (PDF o imagen)',
      name: 'documento',
      accept: 'application/pdf, image/*'
    }
  ]
}
