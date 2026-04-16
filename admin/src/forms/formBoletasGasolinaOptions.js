export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona el banco *',
      name: 'banco_id'
    },
    {
      required: true,
      type: 'async',
      label: 'Selecciona el vehículo *',
      name: 'vehiculo_id'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Kilometraje *',
      name: 'kilometraje'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Litros de gasolina *',
      name: 'litros'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Costo por litro *',
      name: 'costo_litro'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Total *',
      name: 'costo_total'
    },
    {
      required: true,
      type: 'select',
      label: 'Selecciona el método de pago *',
      name: 'metodo_pago',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Transferencia bancaria', value: 'Transferencia bancaria' },
        {
          label: 'Tarjeta de crédito/débito',
          value: 'Tarjeta de crédito/débito'
        },
        { label: 'Efectivo', value: 'Efectivo' },
        { label: 'Cheques', value: 'Cheques' }
      ]
    },
    {
      required: false,
      type: 'text',
      label: 'Referencia',
      name: 'referencia',
      condition: (metodo) =>
        metodo === 'Transferencia bancaria' ||
        metodo === 'Tarjeta de crédito/débito'
    }
  ]
}
