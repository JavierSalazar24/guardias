import { formOptions } from '../../forms/formAlmacenSalidasOptions'
import { InputField } from '../InputField'

export const FormAlmacenSalidas = ({
  view,
  formData,
  handleInputChange,
  loadOptionsArticulos,
  loadOptionsGuardias,
  loadOptionsOrdenServicio
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {formOptions.generalFields.map(
        ({ type, label, name, required, opcSelect }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            required={required}
            value={formData[name] || ''}
            opcSelect={opcSelect}
            loadOptions={loadOptionsArticulos}
            onChange={handleInputChange}
            disabled={name === 'numero_serie' ? true : view}
            classInput='md:col-span-1'
          />
        )
      )}

      {formData.motivo_salida === 'Otro' && (
        <InputField
          type='text'
          label='Otro(s) motivo(s) *'
          name='motivo_salida_otro'
          required={true}
          value={formData.motivo_salida_otro || ''}
          onChange={handleInputChange}
          disabled={view}
          classInput='md:col-span-1'
        />
      )}

      {formData.motivo_salida === 'Asignado a guardia' && (
        <InputField
          type='async'
          label='Selecciona al guardia a quien se le asignó el equipo *'
          name='guardia_id'
          required={true}
          value={formData.guardia_id || ''}
          onChange={handleInputChange}
          loadOptions={loadOptionsGuardias}
          disabled={view}
          classInput='md:col-span-1'
        />
      )}

      {formData.motivo_salida === 'Asignado a servicio' && (
        <InputField
          type='async'
          label='Selecciona la orden de servicio a quien se le asignará el artículo *'
          name='orden_servicio_id'
          required={true}
          value={formData.orden_servicio_id || ''}
          onChange={handleInputChange}
          loadOptions={loadOptionsOrdenServicio}
          disabled={view}
          classInput='md:col-span-1'
        />
      )}
    </div>
  )
}
