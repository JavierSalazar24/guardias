export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona la empresa (cotización aceptada) *',
      name: 'venta_id'
    },
    {
      required: true,
      type: 'textarea',
      label: 'Domicilio del servicio *',
      name: 'domicilio_servicio'
    },
    {
      required: true,
      type: 'text',
      label: 'Código de la orden de servicio *',
      name: 'codigo_orden_servicio'
    },
    {
      required: true,
      type: 'datetime-local',
      label: 'Fecha de inicio del servicio *',
      name: 'fecha_inicio'
    },
    {
      required: true,
      type: 'datetime-local',
      label: 'Fecha del fin del servicio *',
      name: 'fecha_fin'
    },
    {
      required: true,
      type: 'text',
      label: 'Nombre del contacto *',
      name: 'nombre_responsable_sitio'
    },
    {
      required: true,
      type: 'number',
      label: 'Teléfono del contacto *',
      name: 'telefono_responsable_sitio'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Observaciones',
      name: 'observaciones'
    }
  ]
}
