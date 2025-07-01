import { formOptions } from '../../forms/formLimpiezasProgramadasOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'

export const FormLimpiezasProgramadas = ({
  add,
  edit,
  view,
  formData,
  handleInputChange
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Datos para eliminar' />
      </div>
      {(view || add) &&
        formOptions.addTableFields.map(
          ({ type, label, name, required, opcSelect }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              onChange={handleInputChange}
              disabled={view}
              classInput='md:col-span-2'
            />
          )
        )}

      {(view || edit) &&
        formOptions.activoFields.map(
          ({ type, label, name, required, opcSelect }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              onChange={handleInputChange}
              disabled={view}
              classInput='md:col-span-2'
            />
          )
        )}

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Eliminar registros que tengan más del tiempo que selecciones' />
      </div>
      {formOptions.generalFields.map(
        ({ type, label, name, required, opcSelect, step, placeholder }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            required={required}
            step={step}
            placeholder={placeholder}
            value={formData[name] || ''}
            opcSelect={opcSelect}
            onChange={handleInputChange}
            disabled={view}
            classInput='md:col-span-2'
          />
        )
      )}
    </div>
  )
}
