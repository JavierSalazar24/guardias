export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: '¿Para quién es el evento? *',
      name: 'invitado_id'
    },
    { required: true, type: 'text', label: 'Título *', name: 'titulo' },
    {
      required: true,
      type: 'text',
      label: 'Descripción *',
      name: 'descripcion'
    },
    {
      required: true,
      type: 'datetime-local',
      label: 'Fecha y Hora *',
      name: 'fecha_hora'
    },
    { required: false, type: 'textarea', label: 'Notas', name: 'notas' }
  ]
}
