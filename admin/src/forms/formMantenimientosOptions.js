export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'date',
      label: 'Fecha de ingreso *',
      name: 'fecha_ingreso'
    },
    {
      required: false,
      type: 'date',
      label: 'Fecha de salida (llenar al salir)',
      name: 'fecha_salida'
    },
    {
      required: true,
      type: 'async',
      label: 'Vehículo *',
      name: 'vehiculo_id'
    },
    {
      required: true,
      type: 'async',
      label: 'Taller *',
      name: 'taller_id'
    },
    {
      required: true,
      type: 'text',
      label: 'Motivo *',
      name: 'motivo_ingreso'
    },
    {
      required: false,
      type: 'text',
      label: 'Costo final *',
      name: 'costo_final'
    },
    {
      required: true,
      type: 'select',
      label: 'Estatus *',
      name: 'estatus',
      options: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Reparado', value: 'Reparado' },
        { label: 'No reparado', value: 'No reparado' },
        { label: 'En reparación', value: 'En reparación' }
      ]
    },
    {
      required: false,
      type: 'textarea',
      label: 'Notas',
      name: 'notas'
    }
  ]
}
