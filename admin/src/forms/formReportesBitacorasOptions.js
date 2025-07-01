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
      type: 'time',
      label: 'Inicio del recorrido',
      name: 'hora_inicio_recorrido'
    },
    {
      required: false,
      type: 'time',
      label: 'Fin del recorrido',
      name: 'hora_fin_recorrido'
    },
    {
      required: false,
      type: 'date',
      label: 'Fecha del recorrido',
      name: 'fecha'
    },
    {
      required: false,
      type: 'text',
      label: 'Kilometraje',
      name: 'kilometraje'
    },
    {
      required: false,
      type: 'text',
      label: 'Litros de carga',
      name: 'litros_carga'
    },
    {
      required: false,
      type: 'text',
      label: 'Patrulla',
      name: 'patrulla'
    },
    {
      required: false,
      type: 'text',
      label: 'Zona',
      name: 'zona'
    }
  ]
}
