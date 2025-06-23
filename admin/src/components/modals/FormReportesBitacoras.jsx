import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formReportesBitacorasOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormReportesBitacoras = () => {
  const { view, formData, handleInputChange } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Datos de la bitácora' />
        </div>

        {formOptions.generalFields.map(({ type, label, name, required }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            required={required}
            value={formData[name] || ''}
            onChange={handleInputChange}
            disabled={view}
            classInput='md:col-span-2'
          />
        ))}

        {formData?.guardias?.length > 0 && (
          <>
            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Información de los guardias' />
            </div>

            {formData?.guardias?.map((guardia, index) => (
              <div
                key={`guardia-${index}`}
                className='md:col-span-3 border border-gray-300 p-4 rounded-lg shadow-sm bg-white'
              >
                <h3 className='text-lg font-semibold text-gray-700 mb-2'>
                  Guardia {index + 1}: {guardia.nombre_guardia} (
                  {guardia.numero_empleado})
                </h3>

                <ul className='list-inside list-disc pl-3 text-sm text-gray-800'>
                  {Object.entries(guardia.items || {}).map(([key, value]) => (
                    <li
                      key={key}
                      className={`px-3 py-1 mb-3 w-fit rounded-md ${
                        value ? 'bg-green-500' : 'bg-red-500'
                      } text-white`}
                    >
                      {key
                        .replace(/([A-Z])/g, ' $1')
                        .replace(/^./, (s) => s.toUpperCase())}
                    </li>
                  ))}
                </ul>
              </div>
            ))}
          </>
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
