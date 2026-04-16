export const formOptions = {
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
    {
      required: true,
      type: 'date',
      label: 'Fecha de nacimiento *',
      name: 'fecha_nacimiento'
    },
    { required: true, type: 'number', label: 'Teléfono *', name: 'telefono' },
    { required: true, type: 'email', label: 'Correo *', name: 'correo' },
    {
      required: true,
      type: 'text',
      label: 'Enfermedades *',
      name: 'enfermedades'
    },
    { required: true, type: 'text', label: 'Alergias *', name: 'alergias' },
    { required: true, type: 'text', label: 'CURP *', name: 'curp' },
    {
      required: true,
      type: 'text',
      label: 'Clave de elector *',
      name: 'clave_elector'
    }
  ],

  direccionFields: [
    { required: true, type: 'text', label: 'Calle *', name: 'calle' },
    { required: true, type: 'text', label: 'Número *', name: 'numero' },
    {
      required: true,
      type: 'text',
      label: 'Entre calles *',
      name: 'entre_calles'
    },
    { required: true, type: 'text', label: 'Colonia *', name: 'colonia' },
    { required: true, type: 'text', label: 'Código postal *', name: 'cp' },
    { required: true, type: 'select', label: 'Estado *', name: 'estado' },
    { required: true, type: 'select', label: 'Municipio *', name: 'municipio' },
    { required: true, type: 'text', label: 'País *', name: 'pais' }
  ],

  datosEmergenciaFields: [
    {
      required: true,
      type: 'text',
      label: 'Contacto de emergencia *',
      name: 'contacto_emergencia'
    },
    {
      required: true,
      type: 'number',
      label: 'Teléfono de emergencia *',
      name: 'telefono_emergencia'
    }
  ],

  antodopingFields: [
    {
      required: false,
      type: 'file',
      label: 'Antidoping (PDF)',
      name: 'antidoping',
      accept: 'application/pdf'
    },
    {
      required: false,
      type: 'date',
      label: 'Fecha del último antidoping',
      name: 'fecha_antidoping'
    }
  ],

  datosEmpresaFields: [
    {
      required: true,
      type: 'async',
      label: 'Sucursal a la que pertenece *',
      name: 'sucursal_empresa_id'
    },
    {
      required: true,
      type: 'text',
      label: 'Número de empleado *',
      name: 'numero_empleado'
    },
    { required: true, type: 'text', label: 'Cargo *', name: 'cargo' },
    { required: false, type: 'text', label: 'CUIP', name: 'cuip' }
  ],

  datosBancariosFields: [
    {
      required: true,
      type: 'text',
      label: 'Nombre del banco *',
      name: 'banco'
    },
    {
      required: true,
      type: 'text',
      label: 'Nombre del propietario de la cuenta *',
      name: 'nombre_propietario'
    },
    {
      required: true,
      type: 'text',
      label: 'Número de cuenta *',
      name: 'numero_cuenta'
    },
    { required: true, type: 'text', label: 'CLABE *', name: 'clabe' },
    {
      required: false,
      type: 'textarea',
      label: 'Comentarios generales',
      name: 'comentarios_generales'
    }
  ],

  prestacionesFields: [
    {
      required: true,
      step: '0.01',
      type: 'number',
      label: 'Sueldo base x quincena *',
      name: 'sueldo_base'
    },
    {
      required: true,
      step: '0.01',
      type: 'number',
      label: 'Días laborales x semana *',
      name: 'dias_laborales'
    },
    {
      required: true,
      step: '0.01',
      type: 'number',
      label: 'Aguinaldo *',
      name: 'aguinaldo'
    },
    {
      required: true,
      step: '0.01',
      type: 'number',
      label: 'IMSS *',
      name: 'imss'
    },
    {
      required: true,
      step: '0.01',
      type: 'number',
      label: 'INFONAVIT *',
      name: 'infonavit'
    },
    {
      required: true,
      step: '0.01',
      type: 'number',
      label: 'FONACOT *',
      name: 'fonacot'
    },
    {
      required: true,
      step: '0.01',
      type: 'number',
      label: 'Retención de impuestos *',
      name: 'retencion_isr'
    }
  ]
}
