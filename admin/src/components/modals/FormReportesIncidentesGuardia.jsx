import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formReportesIncidentesGuardiaOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormReportesIncidentesGuardia = () => {
  const { view, edit, formData, handleInputChange } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {edit && (
          <>
            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Estatus' />
            </div>

            <InputField
              type='select'
              label='Estado del incidente *'
              name='estado'
              required={true}
              value={formData.estado || ''}
              onChange={handleInputChange}
              disabled={view}
              opcSelect={[
                { label: 'Selecciona una opción', value: '' },
                { label: 'Pendiente', value: 'Pendiente' },
                { label: 'Atendido', value: 'Atendido' }
              ]}
              classInput='md:col-span-2'
            />
          </>
        )}

        {formData?.foto && (
          <>
            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Foto del incidente' />
            </div>

            <div className='sm:col-span-6 md:col-span-2 w-96 mx-auto'>
              <div className='border-2 rounded-lg p-4 transition-all border-blue-500 flex flex-col items-center justify-center'>
                <div className='w-full'>
                  <img
                    src={formData?.foto}
                    alt='Foto del incidente'
                    className='max-h-60 mx-auto rounded-md object-contain'
                  />
                </div>
              </div>
            </div>
          </>
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Datos del incidente' />
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
            disabled={true}
            classInput='md:col-span-1'
          />
        ))}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
