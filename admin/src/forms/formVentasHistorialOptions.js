export const formOptions = {
  adminFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre del admin',
      name: 'nombre_admin'
    },
    {
      required: true,
      type: 'text',
      label: 'Rol',
      name: 'nombre_rol'
    }
  ],
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Banco',
      name: 'banco_id'
    },
    {
      required: true,
      type: 'select',
      label: 'Tipo de pago',
      name: 'tipo_pago',
      opcSelect: [
        { value: '', label: 'Selecciona una opción' },
        { value: 'Crédito', label: 'Crédito' },
        { value: 'Contado', label: 'Contado' }
      ]
    },
    {
      required: true,
      type: 'select',
      label: 'Método de pago',
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
      label: 'Número de factura',
      name: 'numero_factura'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de cotización aceptada',
      name: 'fecha_emision'
    },
    {
      required: true,
      type: 'number',
      label: 'Días de crédito',
      name: 'credito_dias'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de vencimiento de crédito',
      name: 'fecha_vencimiento'
    },
    {
      required: true,
      type: 'number',
      label: 'Monto de la nota de credito',
      name: 'nota_credito'
    },
    {
      required: true,
      type: 'number',
      label: 'Total',
      name: 'total'
    }
  ],

  actualFields: [
    {
      required: true,
      type: 'text',
      label: 'Banco',
      name: 'banco_actualizado'
    },
    {
      required: true,
      type: 'select',
      label: 'Tipo de pago',
      name: 'tipo_pago_actualizado',
      opcSelect: [
        { value: '', label: 'Selecciona una opción' },
        { value: 'Crédito', label: 'Crédito' },
        { value: 'Contado', label: 'Contado' }
      ]
    },
    {
      required: true,
      type: 'select',
      label: 'Método de pago',
      name: 'metodo_pago_actualizado',
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
      label: 'Número de factura',
      name: 'numero_factura_actualizado'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de cotización aceptada',
      name: 'fecha_emision_actualizado'
    },
    {
      required: true,
      type: 'number',
      label: 'Días de crédito',
      name: 'credito_dias_actualizado'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de vencimiento de crédito',
      name: 'fecha_vencimiento_actualizado'
    },
    {
      required: true,
      type: 'number',
      label: 'Monto de la nota de credito',
      name: 'nota_credito_actualizado'
    },
    {
      required: true,
      type: 'number',
      label: 'Total',
      name: 'total_actualizado'
    }
  ]
}
