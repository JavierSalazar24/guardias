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
      type: 'select',
      label: 'Asistencia *',
      name: 'asistencia',
      options: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Asistió', value: 'Asistió' },
        { label: 'Faltó', value: 'Faltó' }
      ]
    },
    {
      required: false,
      type: 'textarea',
      label: 'Motivo de la falta o detalles adicionales',
      name: 'falta',
      condition: ({ asistencia }) => asistencia === 'Faltó'
    },
    {
      required: true,
      type: 'select',
      label: 'Uniforme *',
      name: 'uniforme',
      options: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Completo', value: 'Completo' },
        { label: 'Incompleto', value: 'Incompleto' }
      ]
    },
    {
      required: false,
      type: 'textarea',
      label: 'Detalles del uniforme incompleto',
      name: 'uniforme_incompleto',
      condition: ({ uniforme }) => uniforme === 'Incompleto'
    },
    {
      required: true,
      type: 'select',
      label: 'Equipamiento *',
      name: 'equipamiento',
      options: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Completo', value: 'Completo' },
        { label: 'Incompleto', value: 'Incompleto' }
      ]
    },
    {
      required: false,
      type: 'textarea',
      label: 'Detalles del equipamiento incompleto',
      name: 'equipamiento_incompleto',
      condition: ({ equipamiento }) => equipamiento === 'Incompleto'
    },
    {
      required: true,
      type: 'select',
      label: 'Lugar de Trabajo *',
      name: 'lugar_trabajo',
      options: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Activo', value: 'Activo' },
        { label: 'Ausente', value: 'Ausente' }
      ]
    },
    {
      required: false,
      type: 'textarea',
      label: 'Motivo de ausencia',
      name: 'motivo_ausente',
      condition: ({ lugar_trabajo }) => lugar_trabajo === 'Ausente'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Comentarios Adicionales',
      name: 'comentarios_adicionales'
    }
  ]
}
