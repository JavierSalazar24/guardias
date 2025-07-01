export const formOptions = {
  clienteFiels: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona al cliente *',
      name: 'cliente_id'
    },
    {
      required: true,
      type: 'select',
      label: 'Selecciona la sucursal *',
      name: 'sucursal_id'
    },
    {
      required: true,
      type: 'text',
      label: 'Días de credito *',
      name: 'credito_dias'
    }
  ],

  serviciosFields: [
    {
      required: true,
      type: 'async-multi',
      label: 'Selecciona los servicios *',
      name: 'tipo_servicio_id'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Precio total por servicios *',
      name: 'precio_total_servicios'
    }
  ],

  requerimientosFields: [
    {
      required: true,
      type: 'number',
      label: 'Cantidad de guardias de día *',
      name: 'guardias_dia'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Precio unitario de guardia por día *',
      name: 'precio_guardias_dia'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Precio total de guardias por día *',
      name: 'precio_guardias_dia_total'
    },
    {
      required: true,
      type: 'number',
      label: 'Cantidad de guardias de noche *',
      name: 'guardias_noche'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Precio unitario de guardia por noche *',
      name: 'precio_guardias_noche'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Precio total de guardias por noche *',
      name: 'precio_guardias_noche_total'
    },
    {
      required: true,
      type: 'number',
      label: 'Guardias totales *',
      name: 'cantidad_guardias'
    },
    {
      required: true,
      type: 'select',
      label: '¿Ocupa jefe de turno? *',
      name: 'jefe_turno',
      opcSelect: [
        { value: '', label: 'Selecciona una opción' },
        { value: 'SI', label: 'Sí' },
        { value: 'NO', label: 'No' }
      ]
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Costo por jefe de turno *',
      name: 'precio_jefe_turno',
      condition: (data) => data.jefe_turno === 'SI'
    },
    {
      required: true,
      type: 'select',
      label: '¿Ocupa supervisor? *',
      name: 'supervisor',
      opcSelect: [
        { value: '', label: 'Selecciona una opción' },
        { value: 'SI', label: 'Sí' },
        { value: 'NO', label: 'No' }
      ]
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Costo por supervisor *',
      name: 'precio_supervisor',
      condition: (data) => data.supervisor === 'SI'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de servicio *',
      name: 'fecha_servicio'
    }
  ],

  otraInformacionFields: [
    {
      required: false,
      type: 'textarea',
      label: 'Requisitos para pago del cliente',
      name: 'requisitos_pago_cliente'
    },
    {
      required: true,
      type: 'select',
      label: 'Soporte documental *',
      name: 'soporte_documental',
      opcSelect: [
        { value: '', label: 'Selecciona una opción' },
        { value: 'SI', label: 'Sí' },
        { value: 'NO', label: 'No' }
      ]
    },
    {
      required: true,
      type: 'textarea',
      label: 'Observaciones *',
      name: 'observaciones_soporte_documental',
      condition: (soporte_documental) => soporte_documental === 'SI'
    }
  ],

  montosFields: [
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Subtotal *',
      name: 'subtotal'
    },
    {
      required: false,
      type: 'number',
      step: '0.01',
      label: 'Descuento (%)',
      name: 'descuento_porcentaje'
    },
    {
      required: false,
      type: 'number',
      step: '0.01',
      label: 'Costo extra (por algún servicio)',
      name: 'costo_extra'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Porcentaje de impuestos (si no aplica introducir 0) *',
      name: 'impuesto'
    },
    {
      required: true,
      type: 'number',
      step: '0.01',
      label: 'Total *',
      name: 'total'
    }
  ],

  opcSelect: [
    { value: 'PENDIENTE', label: 'Pendiente' },
    { value: 'SI', label: 'Sí' },
    { value: 'NO', label: 'No' }
  ],

  aceptadaFields: [
    {
      required: true,
      type: 'date',
      label: 'Fecha de cotización aceptada *',
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
      label: 'Monto de la nota de credito *',
      step: '0.01',
      name: 'nota_credito'
    }
  ]
}
