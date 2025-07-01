import { formOptions } from '../../forms/formDescuentosOptions'
import { InputField } from '../InputField'

export const FormDescuentos = ({
  view,
  formData,
  handleInputChange,
  loadOptionsTodosGuardias,
  loadOptionsModuloDescuento
}) => {
  return (
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {formOptions.generalFields.map(
          ({ type, label, name, required, step, opcSelect }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              step={step}
              opcSelect={opcSelect}
              onChange={handleInputChange}
              loadOptions={
                name === 'guardia_id'
                  ? loadOptionsTodosGuardias
                  : loadOptionsModuloDescuento
              }
              disabled={view}
              classInput='md:col-span-1'
            />
          )
        )}

        <InputField
          type='textarea'
          label='Observaciones'
          name='observaciones'
          required={false}
          value={formData.observaciones || ''}
          onChange={handleInputChange}
          disabled={view}
          classInput='md:col-span-2'
        />
      </div>
  )
}
