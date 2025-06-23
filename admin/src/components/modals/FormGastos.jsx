import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formGastosOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormGastos = () => {
  const {
    view,
    add,
    formData,
    handleInputChange,
    loadOptionsBancos,
    loadOptionsModuloConcepto
  } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Datos de gastos' />
        </div>

        {formOptions.generalFields.map(
          ({ type, label, name, required, step, opcSelect, condition }) =>
            (!condition || condition(formData.metodo_pago)) && (
              <InputField
                key={name}
                type={type}
                label={label}
                name={name}
                step={step}
                required={required}
                value={formData[name] || ''}
                opcSelect={opcSelect}
                loadOptions={
                  name === 'banco_id'
                    ? loadOptionsBancos
                    : loadOptionsModuloConcepto
                }
                onChange={handleInputChange}
                disabled={name === 'banco_id' && !add ? true : view}
                classInput='md:col-span-1'
              />
            )
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
