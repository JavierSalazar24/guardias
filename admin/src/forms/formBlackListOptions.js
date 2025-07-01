export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'async',
      label: 'Selecciona al guardia *',
      name: 'guardia_id'
    },
    {
      required: true,
      type: 'textarea',
      label: 'Motivo de la baja *',
      name: 'motivo_baja'
    }
  ],
  personalFields: [
    { required: true, type: 'text', label: 'Nombre *', name: 'nombre' },
    {
      required: true,
      type: 'text',
      label: 'Apellido paterno *',
      name: 'apellido_p'
    },
    {
      required: true,
      type: 'text',
      label: 'Apellido materno *',
      name: 'apellido_m'
    },
    { required: true, type: 'number', label: 'Edad *', name: 'edad' },
    { required: true, type: 'number', label: 'Teléfono *', name: 'telefono' },
    { required: true, type: 'email', label: 'Correo *', name: 'correo' },
    {
      required: true,
      type: 'text',
      label: 'Enfermedades *',
      name: 'enfermedades'
    },
    { required: true, type: 'text', label: 'Alergias *', name: 'alergias' }
  ],

  direccionFields: [
    { required: true, type: 'text', label: 'Calle *', name: 'calle' },
    { required: true, type: 'text', label: 'Número *', name: 'numero' },
    { required: true, type: 'text', label: 'Colonia *', name: 'colonia' },
    { required: true, type: 'number', label: 'Código postal *', name: 'cp' },
    { required: true, type: 'text', label: 'Municipio *', name: 'municipio' },
    { required: true, type: 'text', label: 'Estado *', name: 'estado' },
    { required: true, type: 'text', label: 'País *', name: 'pais' }
  ]
}
