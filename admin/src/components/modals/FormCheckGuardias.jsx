import { formOptions } from '../../forms/formCheckGuardiasOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'

export const FormCheckGuardias = ({ view, formData, handleInputChange }) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Imagen del check' />
      </div>

      <div className='sm:col-span-6 md:col-span-1 w-66 mx-auto'>
        <div className='border-2 rounded-lg p-4 transition-all border-blue-500 flex flex-col items-center justify-center'>
          {formData.foto_check_in_url ? (
            <img
              src={formData.foto_check_in_url}
              alt='Foto del check-in'
              className='max-h-60 mx-auto rounded-md object-contain'
            />
          ) : (
            <p>Sin foto de entrada</p>
          )}
        </div>
      </div>

      <div className='sm:col-span-6 md:col-span-1 w-66 mx-auto'>
        <div className='border-2 rounded-lg p-4 transition-all border-blue-500 flex flex-col items-center justify-center'>
          {formData.foto_check_out_url ? (
            <img
              src={formData.foto_check_out_url}
              alt='Foto del check-out'
              className='max-h-60 mx-auto rounded-md object-contain'
            />
          ) : (
            <p>Sin foto de salida</p>
          )}
        </div>
      </div>

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Datos del Check-In/Check-Out' />
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

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Datos de la ubicación del Check-In' />
      </div>
      {formOptions.ubicacionInFields.map(({ type, label, name, required }) => (
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

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Datos de la ubicación del Check-Out' />
      </div>
      {formOptions.ubicacionOutFields.map(({ type, label, name, required }) => (
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
  )
}
