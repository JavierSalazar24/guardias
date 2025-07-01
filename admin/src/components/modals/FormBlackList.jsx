import { InputField } from '../InputField'
import { AlertaCard } from '../AlertaCard'
import { formOptions } from '../../forms/formBlackListOptions'

import foto_default from '../../assets/imgs/usuarios/default.png'

export const FormBlackList = ({
  view,
  add,
  document,
  formData,
  handleInputChange,
  loadOptionsTodosGuardias
}) => {
  return (
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
            loadOptions={loadOptionsTodosGuardias}
            disabled={false}
            classInput='md:col-span-2'
          />
        ))}
      {document && (
        <>
          <div className='sm:col-span-6 md:col-span-2'>
            <AlertaCard text='Motivo de porque está en lista negra' />
          </div>
          <InputField
            type='textarea'
            label='Motivo'
            name='motivo_baja'
            required={true}
            value={formData.motivo_baja || ''}
            onChange={handleInputChange}
            disabled={view}
            classInput='md:col-span-2'
          />
        </>
      )}

      {!add && (
        <>
          <div className='sm:col-span-6 md:col-span-2'>
            <AlertaCard text='Datos del guardia' />
          </div>
          <div className='sm:col-span-6 md:col-span-2 w-96 mx-auto'>
            <div className='cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 transition-all hover:border-blue-500 flex flex-col items-center justify-center'>
              <div className='w-full'>
                <img
                  src={formData.guardia.foto_url || foto_default}
                  alt='Foto de perfil'
                  className='max-h-60 mx-auto rounded-md object-contain'
                />
              </div>
            </div>
          </div>

          {formOptions.personalFields.map(({ type, label, name, required }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData.guardia[name] || ''}
              onChange={handleInputChange}
              disabled={true}
            />
          ))}

          <div className='sm:col-span-6 md:col-span-2'>
            <AlertaCard text='Dirección' />
          </div>
          {formOptions.direccionFields.map(
            ({ type, label, name, accept, required }) => (
              <InputField
                key={name}
                type={type}
                accept={accept}
                label={label}
                required={required}
                name={name}
                value={formData.guardia[name] || ''}
                onChange={handleInputChange}
                disabled={true}
              />
            )
          )}
        </>
      )}
    </div>
  )
}
