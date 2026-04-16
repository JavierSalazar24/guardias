import { formOptions } from '../../forms/formFaltasOptions'
import { InputField } from '../InputField'

export const FormFaltas = ({
  view,
  formData,
  handleInputChange,
  loadOptionsTodosGuardias
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {formOptions.generalFields.map(
        ({ type, label, name, required, step }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            required={required}
            value={formData[name] || ''}
            step={step}
            onChange={handleInputChange}
            loadOptions={loadOptionsTodosGuardias}
            disabled={name === 'monto' ? true : view}
            classInput='md:col-span-1'
          />
        )
      )}
    </div>
  )
}
