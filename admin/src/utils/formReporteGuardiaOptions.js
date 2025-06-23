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
      label: 'Elemento que entrega el equipo',
      name: 'quien_entrega'
    },
    {
      required: false,
      type: 'text',
      label: 'Elemento que recibe el equipo',
      name: 'quien_recibe'
    },
    {
      required: false,
      type: 'text',
      label: 'Equipo entregado',
      name: 'equipo_entregado'
    },
    {
      required: false,
      type: 'datetime-local',
      label: 'Fecha y hora del reporte',
      name: 'fecha'
    }
  ]
}
