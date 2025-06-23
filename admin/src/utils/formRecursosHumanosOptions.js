export const formOptions = {
  descuentosFields: [
    {
      required: true,
      type: 'text',
      label: 'Descuento por faltas',
      name: 'descuento_falta'
    },
    {
      required: true,
      type: 'text',
      label: 'Descuento por préstamo',
      name: 'descuento_prestamo'
    },
    {
      required: true,
      type: 'text',
      label: 'Descuento por uniforme',
      name: 'descuento_uniforme'
    },
    {
      required: true,
      type: 'text',
      label: 'Otros descuentos',
      name: 'otros_descuentos'
    }
  ],

  sueldoFields: [
    { required: true, type: 'text', label: 'Faltas', name: 'faltas' },
    { required: true, type: 'text', label: 'Vacaciones', name: 'vacaciones' },
    { required: true, type: 'text', label: 'Sueldo', name: 'sueldo' },
    { required: true, type: 'text', label: 'Aguinaldo', name: 'aguinaldo' },
    {
      required: true,
      type: 'text',
      label: 'Tiempo extra',
      name: 'tiempo_extra'
    },
    {
      required: true,
      type: 'text',
      label: 'Prestaciones',
      name: 'anticipo_sueldo'
    },
    {
      required: true,
      type: 'text',
      label: 'Días laborales',
      name: 'dias_laborales'
    },
    {
      required: true,
      type: 'text',
      label: 'Incapacidades',
      name: 'incapacidades'
    }
  ],

  otrosFields: [
    { required: true, type: 'text', label: 'Pago IMSS', name: 'pago_imss' },
    { required: true, type: 'text', label: 'INFONAVIT', name: 'infonavit' },
    {
      required: true,
      type: 'text',
      label: 'Retención de impuestos',
      name: 'retencion_impuesto'
    },
    { required: true, type: 'text', label: 'FONACOT', name: 'fonacot' }
  ]
}
