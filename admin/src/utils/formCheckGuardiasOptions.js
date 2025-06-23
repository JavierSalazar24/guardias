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
      type: 'datetime-local',
      label: 'Fecha de entrada',
      name: 'fecha_entrada'
    },
    {
      required: false,
      type: 'datetime-local',
      label: 'Fecha de salida',
      name: 'fecha_salida'
    },
    {
      required: false,
      type: 'text',
      label: 'Tipo de guardia',
      name: 'tipo_guardia'
    }
  ],
  ubicacionInFields: [
    {
      required: false,
      type: 'textarea',
      label: 'Ubicación',
      name: 'ubicacion'
    },
    {
      required: false,
      type: 'text',
      label: 'Latitud y longitud',
      name: 'latitud_longitud'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Comentarios',
      name: 'comentarios'
    }
  ],
  ubicacionOutFields: [
    {
      required: false,
      type: 'textarea',
      label: 'Ubicación',
      name: 'ubicacion_salida'
    },
    {
      required: false,
      type: 'text',
      label: 'Latitud y longitud',
      name: 'latitud_longitud_salida'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Comentarios',
      name: 'comentarios_salida'
    }
  ]
}
