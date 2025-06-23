export const formOptions = {
  contactoFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre *',
      name: 'nombre_contacto'
    },
    {
      required: true,
      type: 'text',
      label: 'Teléfono *',
      name: 'telefono_contacto'
    },
    {
      required: true,
      type: 'text',
      label: 'WhatsApp *',
      name: 'whatsapp_contacto'
    },
    {
      required: true,
      type: 'email',
      label: 'Correo *',
      name: 'correo_contacto'
    }
  ],

  sucursalFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre de la sucursal *',
      name: 'nombre_sucursal'
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
      label: 'Teléfono sucursal *',
      name: 'telefono_sucursal'
    },
    {
      required: false,
      type: 'text',
      label: 'Extensión',
      name: 'extension_sucursal'
    }
  ]
}
