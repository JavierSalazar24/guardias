export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona el banco (de donde saldrá el préstamo) *',
      name: 'banco_id'
    },
    {
      required: true,
      type: 'async',
      label: 'Selecciona al guardia *',
      name: 'guardia_id'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Monto del prestamo *',
      name: 'monto_total'
    },
    {
      required: true,
      type: 'number',
      label: 'Número de pagos acordados (para liquidar) *',
      name: 'numero_pagos'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha del prestamo *',
      name: 'fecha_prestamo'
    },
    {
      required: true,
      type: 'async',
      label: 'Selecciona el motivo *',
      name: 'modulo_prestamo_id'
    },
    {
      required: false,
      type: 'textarea',
      label: 'Observaciones',
      name: 'observaciones'
    }
  ],

  metodoFields: [
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
