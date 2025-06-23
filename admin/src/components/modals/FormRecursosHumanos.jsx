import { useModal } from '../../hooks/useModal'
import { InputField } from '../InputField'
import { AlertaCard } from '../AlertaCard'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'
import { formOptions } from '../../utils/formRecursosHumanosOptions'
import { useRecursosHumanos } from '../../hooks/useRecursosHumanos'

export const FormRecursosHumanos = () => {
  const { view, formData, handleInputChange } = useModal()
  const { loadOptions } = useRecursosHumanos()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Guardia' />
        </div>
        <InputField
          type='async'
          label='Selecciona el guardia'
          name='guardia_id'
          required={true}
          value={formData.guardia_id || ''}
          onChange={handleInputChange}
          loadOptions={loadOptions}
          classInput='md:col-span-2'
          disabled={view}
        />

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Sueldos' />
        </div>
        {formOptions.sueldoFields.map(({ type, label, name, required }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            required={required}
            value={formData[name] || ''}
            onChange={handleInputChange}
            disabled={view}
          />
        ))}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Descuentos' />
        </div>
        {formOptions.descuentosFields.map(
          ({ type, label, name, accept, required }) => (
            <InputField
              key={name}
              type={type}
              accept={accept}
              label={label}
              required={required}
              name={name}
              value={formData[name] || ''}
              onChange={handleInputChange}
              disabled={view}
            />
          )
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Otros' />
        </div>
        {formOptions.otrosFields.map(
          ({ type, label, name, accept, required }) => (
            <InputField
              key={name}
              type={type}
              accept={accept}
              label={label}
              required={required}
              name={name}
              value={formData[name] || ''}
              onChange={handleInputChange}
              disabled={view}
            />
          )
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
