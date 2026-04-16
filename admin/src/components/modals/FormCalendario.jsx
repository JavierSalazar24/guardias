import { formOptions } from '../../forms/formCalendarioOptions'
import { InputField } from '../InputField'

export const FormCalendario = ({
  view,
  formData,
  handleInputChange,
  loadOptionsUsuarios
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {formOptions.generalFields.map(({ type, label, name, required }) => (
        <InputField
          key={name}
          type={type}
          label={label}
          name={name}
          required={required}
          value={formData[name] || ''}
          onChange={handleInputChange}
          loadOptions={loadOptionsUsuarios}
          disabled={view}
          classInput={`${type === 'textarea' ? 'md:col-span-2' : 'md:col-span-1'}`}
        />
      ))}
    </div>
  )
}
