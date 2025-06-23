import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formReporteCarteraVencidaOptions'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormReporteCarteraVencida = () => {
  const { view, formData, handleInputChange, loadOptionsCotizaciones } =
    useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {formOptions.generalFields.map(
          ({ type, label, name, required, opcSelect, step }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              step={step}
              loadOptions={loadOptionsCotizaciones}
              onChange={handleInputChange}
              disabled={true}
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
