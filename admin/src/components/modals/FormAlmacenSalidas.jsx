import { useAlmacenSalidas } from '../../hooks/useAlmacenSalidas'
import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formAlmacenSalidasOptions'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormAlmacenSalidas = () => {
  const { view, formData, handleInputChange } = useModal()
  const { loadOptionsArticulos, loadOptionsGuardias } = useAlmacenSalidas()

  return (
    <>
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

        {formData.motivo_salida === 'Asignado' && (
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
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
