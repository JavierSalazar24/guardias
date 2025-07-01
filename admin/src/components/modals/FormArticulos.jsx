import { formOptions } from '../../forms/formArticulosOptions'
import { InputField } from '../InputField'

export const FormArticulos = ({ view, formData, handleInputChange }) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {formOptions.generalFields.map(
        ({ type, label, name, required, opcSelect, step }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            step={step}
            required={required}
            value={formData[name] || ''}
            opcSelect={opcSelect}
            onChange={handleInputChange}
            disabled={view}
            classInput='md:col-span-1'
          />
        )
      )}
    </div>
  )
}
