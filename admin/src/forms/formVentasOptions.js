export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona la cotizacion *',
      name: 'cotizacion_id'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de cotización aceptada',
      name: 'fecha_emision'
    },
    {
      required: true,
      type: 'select',
      label: 'Tipo de pago *',
      name: 'tipo_pago',
      opcSelect: [
        { value: '', label: 'Selecciona una opción' },
        { value: 'Crédito', label: 'Crédito' },
        { value: 'Contado', label: 'Contado' }
      ]
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Monto de la nota de credito *',
      name: 'nota_credito'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha límite de pago',
      name: 'fecha_vencimiento'
    }
  ],

  pagadaFields: [
    {
      required: true,
      type: 'text',
      label: 'Número de factura',
      name: 'numero_factura'
    },
    {
      required: true,
      type: 'async',
      label: 'Selecciona el banco *',
      name: 'banco_id'
    },
    {
      required: true,
      type: 'select',
      label: 'Método de pago *',
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
      required: true,
      type: 'text',
      label: 'Referencia *',
      name: 'referencia',
      condition: (metodo) =>
        metodo === 'Transferencia bancaria' ||
        metodo === 'Tarjeta de crédito/débito'
    },
  ]
}
