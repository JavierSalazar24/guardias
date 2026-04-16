export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona la orden de servicio *',
      name: 'orden_servicio_id'
    },
    {
      required: true,
      type: 'number',
      label: 'Cantidad de QRs a generar *',
      name: 'cantidad'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Notas',
      name: 'notas'
    }
  ]
}
