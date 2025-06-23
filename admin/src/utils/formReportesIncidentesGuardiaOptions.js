export const formOptions = {
  generalFields: [
    {
      required: false,
      type: 'text',
      label: 'Orden de servicio',
      name: 'orden'
    },
    { required: false, type: 'text', label: 'Guardia', name: 'nombre' },
    {
      required: false,
      type: 'text',
      label: 'Punto de vigilancia',
      name: 'punto_vigilancia'
    },
    {
      required: false,
      type: 'text',
      label: 'Turno',
      name: 'turno'
    },
    {
      required: false,
      type: 'text',
      label: 'Persona que reporta',
      name: 'quien_reporta'
    },
    {
      required: false,
      type: 'text',
      label: 'Incidente',
      name: 'incidente'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Causa del incidente',
      name: 'causa'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Descripción del incidente',
      name: 'descripcion'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Ubicación del incidente',
      name: 'ubicacion'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Lugar del incidente',
      name: 'lugar_incidente'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Acciones que se tomaron',
      name: 'acciones'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Recomendaciones',
      name: 'recomendaciones'
    },
    {
      required: false,
      type: 'datetime-local',
      label: 'Fecha y hora del incidente',
      name: 'fecha'
    }
  ]
}
