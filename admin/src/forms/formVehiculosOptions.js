export const formOptions = {
  generalFields: [
    {
      required: true,
      type: 'select',
      label: 'Tipo de vehículo *',
      name: 'tipo_vehiculo',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'Carro', value: 'Carro' },
        { label: 'Motocicleta', value: 'Motocicleta' }
      ]
    },
    { required: true, type: 'text', label: 'Marca *', name: 'marca' },
    { required: true, type: 'text', label: 'Modelo *', name: 'modelo' },
    { required: true, type: 'text', label: 'Color *', name: 'color' },
    { required: true, type: 'text', label: 'Placas *', name: 'placas' },

    {
      required: true,
      type: 'file',
      multiple: true,
      label: 'Fotos del vehículo *',
      name: 'fotos_vehiculo',
      accept: 'image/*'
    },
    {
      required: true,
      type: 'select',
      label: 'Rotulado *',
      name: 'rotulado',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'SI', value: 'SI' },
        { label: 'NO', value: 'NO' }
      ]
    },
    {
      required: true,
      type: 'select',
      label: 'GPS *',
      name: 'gps',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'SI', value: 'SI' },
        { label: 'NO', value: 'NO' }
      ]
    },
    {
      required: true,
      type: 'select',
      label: 'Torreta *',
      name: 'torreta',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'SI', value: 'SI' },
        { label: 'NO', value: 'NO' }
      ]
    },
    {
      required: true,
      type: 'select',
      label: 'Impuestos pagados *',
      name: 'impuestos_pagados',
      opcSelect: [
        { label: 'Selecciona una opción', value: '' },
        { label: 'SI', value: 'SI' },
        { label: 'NO', value: 'NO' }
      ]
    }
  ],

  seguroFields: [
    {
      required: true,
      type: 'text',
      label: 'Aseguradora *',
      name: 'aseguradora'
    },
    {
      required: true,
      type: 'number',
      label: 'Teléfono de la aseguradora *',
      name: 'telefono_aseguradora'
    },
    {
      required: true,
      type: 'file',
      label: 'Póliza de seguro (PDF) *',
      name: 'archivo_seguro',
      accept: 'application/pdf'
    },
    {
      required: true,
      type: 'text',
      label: 'Número de póliza *',
      name: 'numero_poliza'
    },
    {
      required: true,
      type: 'date',
      label: 'Fecha de vencimiento del seguro *',
      name: 'fecha_vencimiento'
    }
  ]
}
