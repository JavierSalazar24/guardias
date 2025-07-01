import { formOptions } from '../../forms/formBoletasGasolinaOptions'
import { InputField } from '../InputField'

export const FormBoletasGasolina = ({
  view,
  edit,
  formData,
  handleInputChange,
  loadOptionsVehiculos,
  loadOptionsBancos
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {formOptions.generalFields.map(
        ({ type, label, name, required, step, condition, opcSelect }) =>
          (!condition || condition(formData.metodo_pago)) && (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              step={step}
              opcSelect={opcSelect}
              value={formData[name] || ''}
              onChange={handleInputChange}
              loadOptions={
                name === 'banco_id' ? loadOptionsBancos : loadOptionsVehiculos
              }
              disabled={
                name === 'costo_total' ||
                (edit &&
                  ['vehiculo_id', 'banco_id', 'litros', 'costo_litro'].includes(
                    name
                  ))
                  ? true
                  : view
              }
              classInput='md:col-span-2'
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
        loadOptions={loadOptionsVehiculos}
        disabled={view}
        classInput='md:col-span-2'
      />
    </div>
  )
}
