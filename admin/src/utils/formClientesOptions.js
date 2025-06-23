export const formOptions = {
  contactoAdminFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre *',
      name: 'nombre_contacto_admin'
    },
    {
      required: true,
      type: 'text',
      label: 'Teléfono *',
      name: 'telefono_contacto_admin'
    },
    {
      required: true,
      type: 'text',
      label: 'WhatsApp *',
      name: 'whatsapp_contacto_admin'
    },
    {
      required: true,
      type: 'email',
      label: 'Correo *',
      name: 'correo_contacto_admin'
    }
  ],

  contactoOperaFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre *',
      name: 'nombre_contacto_opera'
    },
    {
      required: true,
      type: 'text',
      label: 'Teléfono *',
      name: 'telefono_contacto_opera'
    },
    {
      required: true,
      type: 'text',
      label: 'WhatsApp *',
      name: 'whatsapp_contacto_opera'
    },
    {
      required: true,
      type: 'email',
      label: 'Correo *',
      name: 'correo_contacto_opera'
    }
  ],

  empresaFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre de la empresa *',
      name: 'nombre_empresa'
    },
    { required: true, type: 'text', label: 'Calle *', name: 'calle' },
    {
      required: true,
      type: 'text',
      label: 'Número *',
      name: 'numero'
    },
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
      required: false,
      type: 'url',
      label: 'Sitio web',
      name: 'pagina_web'
    },
    {
      required: true,
      type: 'number',
      label: 'Días de crédito *',
      name: 'credito_dias'
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
      required: false,
      type: 'url',
      label: 'Plataforma para cargar facturas',
      name: 'plataforma_facturas'
    },
    {
      required: true,
      type: 'select',
      label: '¿Se requiere orden de compra? *',
      name: 'orden_compra',
      opcSelect: [
        { value: '', label: 'Selecciona una opción' },
        { value: 'NO', label: 'NO' },
        { value: 'SI', label: 'SI' }
      ]
    }
  ],

  rfcFields: [
    {
      required: true,
      type: 'text',
      label: 'RFC *',
      name: 'rfc'
    },
    {
      required: true,
      type: 'text',
      label: 'Razón social *',
      name: 'razon_social'
    },
    {
      required: true,
      type: 'text',
      label: 'Uso de CFDI *',
      name: 'uso_cfdi'
    },
    {
      required: true,
      type: 'text',
      label: 'Regimen fiscal *',
      name: 'regimen_fiscal'
    },
    {
      required: true,
      type: 'file',
      label: 'Situación fiscal *',
      name: 'situacion_fiscal'
    }
  ]
}
