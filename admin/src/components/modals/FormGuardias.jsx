import { useModal } from '../../hooks/useModal'
import { InputField } from '../InputField'
import { AlertaCard } from '../AlertaCard'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'
import { formOptions } from '../../utils/formGuradiasOptions'
import { useRef } from 'react'
import { Upload } from 'lucide-react'
import { useGuardias } from '../../hooks/useGuardias'

export const FormGuardias = () => {
  const { opcionesEstados, municipios, handleCheckBlackList } = useGuardias()
  const {
    view,
    add,
    document,
    formData,
    handleInputChange,
    handleFileChange,
    loadOptionsSucursalesEmpresa
  } = useModal()
  const fileInputRef = useRef(null)

  const handleFileBoxClick = () => {
    fileInputRef.current?.click()
  }

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Foto de perfil' />
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

            {formData.preview || document ? (
              <div className='w-full'>
                <img
                  src={formData.preview || formData.foto_url}
                  alt='Foto de perfil'
                  className='max-h-60 mx-auto rounded-md object-contain'
                />
              </div>
            ) : (
              <div className='py-6 flex flex-col items-center'>
                <Upload className='h-20 w-10 text-gray-400 mb-2' />
                <p className='text-gray-500 text-center'>
                  Click para seleccionar foto
                </p>
              </div>
            )}
          </div>
        </div>

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Información personal' />
        </div>

        {formOptions.personalFields.map(({ type, label, name, required }) => (
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
              value={formData[name] || ''}
              onChange={handleInputChange}
              disabled={view}
            />
          )
        )}

        <InputField
          label='Estado *'
          name='estado'
          type='select'
          value={formData.estado}
          onChange={(e) => {
            handleInputChange(e)
            handleInputChange({ target: { name: 'municipio', value: '' } })
          }}
          required
          disabled={view}
          opcSelect={opcionesEstados}
        />

        <InputField
          label='Municipio *'
          name='municipio'
          type='select'
          value={formData.municipio}
          onChange={handleInputChange}
          required
          disabled={view || municipios.length === 0}
          opcSelect={[
            { value: '', label: 'Selecciona un municipio' },
            ...municipios
          ]}
        />

        <InputField
          label='País *'
          name='pais'
          type='text'
          onChange={handleInputChange}
          required
          disabled={view}
          value={formData.pais || ''}
        />

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
              value={formData[name] || ''}
              onChange={handleFileChange}
              document={formData[`${name}_url`] || null}
              disabled={view}
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
              value={formData[name] || ''}
              onChange={type === 'file' ? handleFileChange : handleInputChange}
              document={formData[`${name}_url`] || null}
              disabled={view}
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
            value={formData[name] || ''}
            onChange={handleInputChange}
            loadOptions={loadOptionsSucursalesEmpresa}
            disabled={view}
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
              value={formData[name] || ''}
              onChange={handleInputChange}
              disabled={view}
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
          value={formData.rango || ''}
          opcSelect={[
            { label: 'Selecciona una opción', value: '' },
            { label: 'Guardia', value: 'Guardia' },
            { label: 'Supervisor', value: 'Supervisor' },
            { label: 'Jefe de turno', value: 'Jefe de turno' }
          ]}
          onChange={handleInputChange}
          disabled={view}
          classInput='md:col-span-2'
        />

        {document && (
          <InputField
            type='select'
            label='Estatus del guardia *'
            required={true}
            name='estatus'
            value={formData.estatus || ''}
            opcSelect={[
              { label: 'Selecciona una opción', value: '' },
              { label: 'Disponible', value: 'Disponible' },
              { label: 'Descansado', value: 'Descansado' },
              { label: 'Dado de baja', value: 'Dado de baja' },
              { label: 'Asignado', value: 'Asignado' }
            ]}
            onChange={handleInputChange}
            disabled={view}
            classInput='md:col-span-2'
          />
        )}
      </div>
      <hr className='text-gray-300' />
      {add && (
        <div className='my-5'>
          <AlertaCard text='Revisa si el guardia está en la lista negra antes de guardar los datos.' />
          <button
            type='button'
            onClick={() => handleCheckBlackList(formData)}
            className='w-full mt-5 rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-500 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:text-sm cursor-pointer transition-all'
          >
            Revisar datos
          </button>
        </div>
      )}
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
