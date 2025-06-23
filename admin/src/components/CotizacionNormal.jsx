import { AlertaCard } from './AlertaCard'
import { InputField } from './InputField'

export const CotizacionNormal = ({
  opcionesEstados,
  formOptions,
  formData,
  loadOptionsClientes,
  handleInputChange,
  handleFileChange,
  municipios,
  view
}) => {
  return (
    <>
      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Información de la empresa' />
      </div>

      {formOptions.generalFields.map(
        ({ type, label, name, required, step }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            step={step}
            required={required}
            value={formData[name] || ''}
            loadOptions={loadOptionsClientes}
            onChange={(e) => {
              handleInputChange(e)
              if (name === 'estado') {
                handleInputChange({
                  target: { name: 'municipio', value: '' }
                })
              }
            }}
            disabled={
              name === 'municipio'
                ? municipios.length === 0 || formData.aceptada === 'SI'
                  ? true
                  : view
                : formData.aceptada === 'SI'
                ? true
                : view
            }
            classInput='md:col-span-1'
            opcSelect={
              name === 'estado'
                ? opcionesEstados
                : [
                    { value: '', label: 'Selecciona un municipio' },
                    ...municipios
                  ]
            }
          />
        )
      )}

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Datos fiscales' />
      </div>

      {formOptions.rfcFields.map(({ type, label, name, required }) => (
        <InputField
          key={name}
          type={type}
          label={label}
          name={name}
          required={type === 'file' ? false : required}
          value={formData[name] || ''}
          onChange={type === 'file' ? handleFileChange : handleInputChange}
          disabled={formData.aceptada === 'SI' ? true : view}
          classInput='md:col-span-1'
          document={formData[`${name}_url`] || null}
        />
      ))}
    </>
  )
}
