import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formAbonosPrestamoOptions'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormAbonosPrestamo = () => {
  const {
    view,
    document,
    formData,
    handleInputChange,
    loadOptionsPrestamos,
    loadOptionsBancos
  } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {formOptions.generalFields.map(
          ({ type, label, name, required, step, opcSelect, condition }) =>
            (!condition || condition(formData.metodo_pago)) && (
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
                  name === 'banco_id' ? loadOptionsBancos : loadOptionsPrestamos
                }
                disabled={
                  ['banco_id', 'prestamo_id', 'monto', 'fecha'].includes(
                    name
                  ) && document
                    ? true
                    : view
                }
                classInput={
                  ['banco_id', 'referencia'].includes(name)
                    ? 'md:col-span-2'
                    : 'md:col-span-1'
                }
              />
            )
        )}

        <InputField
          type='textarea'
          label='Obervaciones'
          name='observaciones'
          required={false}
          value={formData.observaciones || ''}
          onChange={handleInputChange}
          disabled={view}
          classInput='md:col-span-2'
        />
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
