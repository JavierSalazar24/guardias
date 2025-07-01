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
      label: 'Licencia de manejo',
      name: 'licencia_manejo'
    },
    {
      required: false,
      type: 'text',
      label: 'Tarjeta de combustible',
      name: 'tarjeta_combustible'
    },
    {
      required: false,
      type: 'text',
      label: 'Recibido por',
      name: 'recibido_por'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Observaciones',
      name: 'observaciones'
    },
    {
      required: false,
      type: 'datetime-local',
      label: 'Fecha y hora del reporte',
      name: 'fecha'
    }
  ]
}
