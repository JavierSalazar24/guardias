import { useModal } from '../../hooks/useModal'
import { InputField } from '../InputField'
import { AlertaCard } from '../AlertaCard'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'
import { useRef } from 'react'
import { formOptions } from '../../utils/formBlackListOptions'

import foto_default from '../../assets/imgs/usuarios/default.png'

export const FormBlackList = () => {
  const {
    view,
    add,
    document,
    formData,
    handleInputChange,
    handleFileChange,
    loadOptionsSucursalesEmpresa,
    loadOptionsTodosGuardias
  } = useModal()
  const fileInputRef = useRef(null)

  const handleFileBoxClick = () => {
    fileInputRef.current?.click()
  }

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
              <div
                onClick={handleFileBoxClick}
                className='cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 transition-all hover:border-blue-500 flex flex-col items-center justify-center'
              >
                <input
                  type='file'
                  ref={fileInputRef}
                  onChange={handleFileChange}
                  accept='image/*'
                  className='hidden'
                  name='foto'
                  required={!document}
                  disabled={view}
                />

                <div className='w-full'>
                  <img
                    src={formData.guardia.foto_url || foto_default}
                    alt='Foto de perfil'
                    className='max-h-60 mx-auto rounded-md object-contain'
                  />
                </div>
              </div>
            </div>

            {formOptions.personalFields.map(
              ({ type, label, name, required }) => (
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
              )
            )}

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

            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Documentos' />
            </div>
            {formOptions.documentFields.map(
              ({ type, label, name, accept, required }) => (
                <InputField
                  key={name}
                  type={type}
                  accept={accept}
                  label={label}
                  required={document ? !document : required}
                  name={name}
                  value={formData.guardia[name] || ''}
                  onChange={handleFileChange}
                  document={formData.guardia[`${name}_url`] || null}
                  disabled={true}
                />
              )
            )}

            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Antidoping' />
            </div>

            {formOptions.antodopingFields.map(
              ({ type, label, name, accept, required }) => (
                <InputField
                  key={name}
                  type={type}
                  accept={accept}
                  label={label}
                  required={document ? !document : required}
                  name={name}
                  value={formData.guardia[name] || ''}
                  onChange={
                    type === 'file' ? handleFileChange : handleInputChange
                  }
                  document={formData[`${name}_url`] || null}
                  disabled={true}
                />
              )
            )}

            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Otros datos' />
            </div>
            {formOptions.otrosFields.map(({ type, label, name, required }) => (
              <InputField
                key={name}
                type={type}
                label={label}
                required={required}
                name={name}
                value={formData.guardia[name] || ''}
                onChange={handleInputChange}
                loadOptions={loadOptionsSucursalesEmpresa}
                disabled={true}
              />
            ))}

            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Prestaciones y sueldo' />
            </div>
            {formOptions.prestacionesFields.map(
              ({ type, label, name, required, step }) => (
                <InputField
                  key={name}
                  type={type}
                  label={label}
                  required={required}
                  name={name}
                  step={step}
                  value={formData.guardia[name] || ''}
                  onChange={handleInputChange}
                  disabled={true}
                />
              )
            )}

            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Información de rango' />
            </div>

            <InputField
              type='select'
              label='Nivel del guardia *'
              required={true}
              name='rango'
              value={formData.guardia.rango || ''}
              opcSelect={[
                { label: 'Selecciona una opción', value: '' },
                { label: 'Guardia', value: 'Guardia' },
                { label: 'Supervisor', value: 'Supervisor' },
                { label: 'Jefe de turno', value: 'Jefe de turno' }
              ]}
              onChange={handleInputChange}
              disabled={true}
              classInput='md:col-span-2'
            />

            {document && (
              <InputField
                type='select'
                label='Estatus del guardia *'
                required={true}
                name='estatus'
                value={formData.guardia.estatus || ''}
                opcSelect={[
                  { label: 'Selecciona una opción', value: '' },
                  { label: 'Disponible', value: 'Disponible' },
                  { label: 'Descansado', value: 'Descansado' },
                  { label: 'Dado de baja', value: 'Dado de baja' },
                  { label: 'Asignado', value: 'Asignado' }
                ]}
                onChange={handleInputChange}
                disabled={true}
                classInput='md:col-span-2'
              />
            )}
          </>
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
