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
      label: 'Zona',
      name: 'zona'
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
      label: 'Elemento que entrega el uniforme',
      name: 'quien_entrega'
    },
    {
      required: false,
      type: 'text',
      label: 'Elemento que recibe el uniforme',
      name: 'quien_recibe'
    },
    {
      required: false,
      type: 'text',
      label: 'Tipo',
      name: 'tipo'
    },
    {
      required: false,
      type: 'datetime-local',
      label: 'Fecha y hora del reporte',
      name: 'fecha'
    }
  ]
}
