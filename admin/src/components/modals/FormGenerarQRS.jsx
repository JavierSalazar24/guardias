import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formGenerarQRSOptions'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormGenerarQRS = () => {
  const {
    view,
    add,
    document,
    formData,
    handleInputChange,
    loadOptionsOrdenServicio
  } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {add &&
          formOptions.generalFields.map(({ type, label, name, required }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              onChange={handleInputChange}
              disabled={view}
              loadOptions={loadOptionsOrdenServicio}
              classInput='md:col-span-2'
            />
          ))}

        {document && (
          <InputField
            type='textarea'
            label='Notas'
            name='notas'
            required={false}
            value={formData.notas || ''}
            onChange={handleInputChange}
            disabled={view}
            classInput='md:col-span-2'
          />
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
