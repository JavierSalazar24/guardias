import { InputField } from '../InputField'
import { AlertaCard } from '../AlertaCard'
import { formOptions } from '../../forms/formGuradiasOptions'
import { FotoGuardia } from '../FotoGuardia'

export const FormGuardias = ({
  view,
  add,
  edit,
  document,
  formData,
  handleInputChange,
  handleFileChange,
  loadOptionsSucursalesEmpresa,
  opcionesEstados,
  municipios,
  handleCheckBlackList
}) => {
  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        <FotoGuardia
          handleFileChange={handleFileChange}
          view={view}
          formData={formData}
          document={document}
        />

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
              onChange={(e) => {
                handleInputChange(e)
                if (name === 'estado') {
                  handleInputChange({
                    target: { name: 'municipio', value: '' }
                  })
                }
              }}
              disabled={
                name === 'municipio'
                  ? municipios.length === 0
                    ? true
                    : view
                  : view
              }
              opcSelect={
                name === 'estado'
                  ? opcionesEstados
                  : [
                      { value: '', label: 'Selecciona un municipio' },
                      ...municipios
                    ]
              }
            />
          )
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Sucursal' />
        </div>
        {formOptions.datosEmpresaFields.map(
          ({ type, label, name, required }) => (
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
              value={formData[name] || ''}
              onChange={handleFileChange}
              document={edit ? null : formData[`${name}_url`] || null}
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
              document={edit ? null : formData[`${name}_url`] || null}
              disabled={view}
            />
          )
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Datos de emergencia' />
        </div>
        {formOptions.datosEmergenciaFields.map(
          ({ type, label, name, required }) => (
            <InputField
              key={name}
              type={type}
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
          label='Rango del guardia *'
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
          classInput='md:col-span-1'
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
            classInput='md:col-span-1'
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
    </>
  )
}
