import { formOptions } from '../../forms/formIncapacidadesOptions'
import { InputField } from '../InputField'

export const FormIncapacidades = ({
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
            disabled={view}
            classInput='md:col-span-2'
          />
        )
      )}
    </div>
  )
}
