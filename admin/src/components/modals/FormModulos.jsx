import { AlertCircle } from 'lucide-react'
import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formModulosOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormModulos = () => {
  const { view, formData, handleInputChange } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        <div className='sm:col-span-6 md:col-span-2'>
          <div className='bg-[#3674B5] font-semibold p-3 rounded-md text-white flex gap-1 items-center'>
            <AlertCircle />
            <h3>
              Agrega el nombre de la ruta, es decir, si la ruta es:{' '}
              <i>https://admin.ejemplo.com/recursos-humanos</i>, el nombré de la
              ruta sería: <i>recursos-humanos</i>
            </h3>
          </div>
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
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
