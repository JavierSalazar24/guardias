import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formReporteGuardiaOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormReporteGuardia = () => {
  const { view, formData, handleInputChange } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
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
            classInput='md:col-span-3'
          />
        ))}

        {formData?.consignas?.length > 0 && (
          <div className='sm:col-span-6 md:col-span-2'>
            <AlertaCard text='Consignas' />

            {formData?.consignas?.map((consigna, index) => (
              <div
                key={`consignas-${crypto.randomUUID()}`}
                className='md:col-span-3 border border-gray-300 p-4 rounded-lg shadow-sm bg-white mt-3'
              >
                <ul className='list-disc sm:pl-5 text-sm text-gray-800'>
                  <li className='flex flex-col sm:list-item'>
                    <span className='bg-[#3D90D7] text-white rounded-sm px-1.5 py-0.5'>
                      {consigna.hora} hrs.
                    </span>{' '}
                    <strong>Consigna {index + 1}:</strong> {consigna.texto}
                  </li>
                </ul>
              </div>
            ))}
          </div>
        )}

        {formData?.observaciones?.length > 0 && (
          <div className='sm:col-span-6 md:col-span-2'>
            <AlertaCard text='Observaciones' />

            {formData?.observaciones?.map((observacion, index) => (
              <div
                key={`observaciones-${crypto.randomUUID()}`}
                className='md:col-span-3 border border-gray-300 p-4 rounded-lg shadow-sm bg-white mt-3'
              >
                <ul className='list-disc sm:pl-5 text-sm text-gray-800'>
                  <li className='flex flex-col sm:list-item'>
                    <span className='bg-[#3D90D7] text-white rounded-sm px-1.5 py-0.5'>
                      {observacion.hora} hrs.
                    </span>{' '}
                    <strong>Observación {index + 1}:</strong>{' '}
                    {observacion.texto}
                  </li>
                </ul>
              </div>
            ))}
          </div>
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
