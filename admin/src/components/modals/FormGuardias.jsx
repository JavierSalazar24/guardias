import { InputField } from '../InputField'
import { AlertaCard } from '../AlertaCard'
import { formOptions } from '../../forms/formGuardiasOptions'
import { FotoGuardia } from '../FotoGuardia'
import { calcularEdad } from '../../utils/edad'

export const FormGuardias = ({
  view,
  add,
  edit,
  document,
  formData,
  handleInputChange,
  handleFileChange,
  loadOptionsSucursalesEmpresa,
  loadOptionsSucursales,
  loadOptionsRangos,
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
            label={`${name === 'fecha_nacimiento' && formData.fecha_nacimiento ? `Edad: ${calcularEdad(formData.fecha_nacimiento)} años` : label}`}
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
          <AlertaCard text='Datos bancarios' />
        </div>
        {formOptions.datosBancariosFields.map(
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
              classInput={`${type === 'textarea' ? 'md:col-span-2' : 'md:col-span-1'}`}
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
          <AlertaCard text='Más información' />
        </div>

        <InputField
          type='date'
          label='Fecha de alta *'
          required={true}
          name='fecha_alta'
          value={formData.fecha_alta || ''}
          onChange={handleInputChange}
          disabled={view}
          classInput='md:col-span-1'
        />

        <InputField
          type='async'
          label='Rango del guardia *'
          required={true}
          name='rango_id'
          value={formData.rango_id || ''}
          onChange={handleInputChange}
          loadOptions={loadOptionsRangos}
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
            classInput='md:col-span-2'
          />
        )}

        {formData.estatus === 'Dado de baja' && (
          <>
            <InputField
              type='date'
              label='Fecha de baja *'
              required={true}
              name='fecha_baja'
              value={formData.fecha_baja || ''}
              onChange={handleInputChange}
              disabled={view}
              classInput='md:col-span-2'
            />
            <InputField
              type='textarea'
              label='Motivo de baja *'
              required={true}
              name='motivo_baja'
              value={formData.motivo_baja || ''}
              onChange={handleInputChange}
              disabled={view}
              classInput='md:col-span-2'
            />
          </>
        )}
        {formData.estatus === 'Asignado' && (
          <InputField
            type='async'
            label='Cliente asignado *'
            required={true}
            name='sucursal_id'
            value={formData.sucursal_id || ''}
            onChange={handleInputChange}
            loadOptions={loadOptionsSucursales}
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
    </>
  )
}
