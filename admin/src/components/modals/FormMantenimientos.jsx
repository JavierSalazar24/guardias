import { formOptions } from '../../forms/formMantenimientosOptions'
import { InputField } from '../InputField'

export const FormMantenimientos = ({
  view,
  formData,
  handleInputChange,
  loadOptionsTalleres,
  loadOptionsVehiculos
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {formOptions.generalFields.map(
        ({ type, label, name, required, options }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            opcSelect={options}
            required={required}
            value={formData[name] || ''}
            onChange={handleInputChange}
            loadOptions={
              name === 'taller_id' ? loadOptionsTalleres : loadOptionsVehiculos
            }
            disabled={view}
            classInput={`${['select', 'textarea'].includes(type) ? 'md:col-span-2' : 'md:col-span-1'}`}
          />
        )
      )}
    </div>
  )
}
