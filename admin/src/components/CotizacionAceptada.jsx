import { AlertaCard } from './AlertaCard'
import { InputField } from './InputField'

export const CotizacionAceptada = ({
  formData,
  handleInputChange,
  view,
  formOptions
}) => {
  return (
    <>
      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Información	de cotización aceptada' />
      </div>

      <InputField
        type='select'
        label='¿Cotización aceptada? *'
        name='aceptada'
        required={true}
        value={formData.aceptada || ''}
        onChange={handleInputChange}
        disabled={formData.aceptada === 'SI' ? true : view}
        opcSelect={formOptions.opcSelect}
        classInput='md:col-span-2'
      />

      {formData.aceptada === 'SI' &&
        formOptions.aceptadaFields.map(
          ({ type, label, name, required, opcSelect, step }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              step={step}
              required={required}
              opcSelect={opcSelect}
              value={formData[name] || ''}
              disabled={view}
              onChange={handleInputChange}
              classInput='md:col-span-1'
            />
          )
        )}
    </>
  )
}
