export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre del contacto *',
      name: 'nombre_contacto'
    },
    {
      required: true,
      type: 'email',
      label: 'Correo de contacto *',
      name: 'correo_contacto'
    },
    {
      required: true,
      type: 'text',
      label: 'Teléfono contacto *',
      name: 'telefono_contacto'
    },
    {
      required: true,
      type: 'text',
      label: 'WhatsApp contacto *',
      name: 'whatsapp_contacto'
    },
    {
      required: true,
      type: 'text',
      label: 'Empresa *',
      name: 'nombre_empresa'
    },
    { required: true, type: 'text', label: 'Calle *', name: 'calle' },
    { required: true, type: 'text', label: 'Número *', name: 'numero' },
    { required: true, type: 'text', label: 'Colonia *', name: 'colonia' },
    { required: true, type: 'select', label: 'Estado *', name: 'estado' },
    { required: true, type: 'select', label: 'Municipio *', name: 'municipio' },
    {
      required: true,
      type: 'number',
      label: 'Código postal *',
      name: 'cp'
    },
    { required: true, type: 'text', label: 'País *', name: 'pais' },
    {
      required: true,
      type: 'text',
      label: 'Teléfono empresa *',
      name: 'telefono_empresa'
    },
    {
      required: false,
      type: 'text',
      label: 'Extensión',
      name: 'extension_empresa'
    },
    {
      required: true,
      type: 'number',
      label: 'Días de crédito *',
      name: 'credito_dias'
    }
  ],

  rfcFields: [
    {
      required: false,
      type: 'text',
      label: 'RFC',
      name: 'rfc'
    },
    {
      required: false,
      type: 'text',
      label: 'Razón social',
      name: 'razon_social'
    },
    {
      required: false,
      type: 'text',
      label: 'Uso de CFDI',
      name: 'uso_cfdi'
    },
    {
      required: false,
      type: 'text',
      label: 'Regimen fiscal',
      name: 'regimen_fiscal'
    },
    {
      required: false,
      type: 'file',
      label: 'Situación fiscal',
      name: 'situacion_fiscal'
    }
  ],

  serviciosFields: [
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
      type: 'date',
      label: 'Fecha de servicio *',
      name: 'fecha_servicio'
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
