export const formOptions = {
  generalFields: [
    { required: true, type: 'async', label: 'Motivo *', name: 'motivo_id' },
    {
      required: true,
      type: 'datetime-local',
      label: 'Fecha y hora *',
      name: 'fecha_hora'
    },
    { required: true, type: 'async', label: 'Empleado *', name: 'empleado_id' },
    {
      required: true,
      type: 'async',
      label: 'Supervisor *',
      name: 'supervisor_id'
    },
    {
      required: true,
      type: 'async',
      label: 'Primer testigo *',
      name: 'testigo1_id'
    },
    {
      required: true,
      type: 'async',
      label: 'Segundo testigo *',
      name: 'testigo2_id'
    },
    {
      required: true,
      type: 'textarea',
      label: 'Lo que dice el supervisor *',
      name: 'dice_supervisor'
    },
    {
      required: true,
      type: 'textarea',
      label: 'Lo que dice el empleado *',
      name: 'dice_empleado'
    }
  ]
}
