import { formOptions } from '../../forms/formOrdenesServicios'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { RendersArticulos } from '../RendersArticulos'

export const FormOrdenesServicios = ({
  view,
  edit,
  formData,
  dataEequipamiento,
  handleInputChange,
  loadOptionsVentas,
  handleCheckboxChange,
  loadOptionsGuardiasBySucursal,
  reloadGuardias,
  articulosDisponibles
}) => {
  const renderArticulo = (articulo) => {
    return (
      <RendersArticulos
        key={articulo.id}
        articulo={articulo}
        articulosDisponibles={articulosDisponibles}
        formData={formData}
        handleCheckboxChange={handleCheckboxChange}
        view={view}
        handleInputChange={handleInputChange}
      />
    )
  }

  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {edit && (
        <>
          <div className='sm:col-span-6 md:col-span-2'>
            <AlertaCard text='Estado de la orden de servicio' />
          </div>

          <InputField
            type='select'
            label='Selecciona el estado de la orden de servicio *'
            name='estatus'
            required={true}
            value={formData.estatus || ''}
            opcSelect={[
              { label: 'Selecciona una opción', value: '' },
              { label: 'En proceso', value: 'En proceso' },
              { label: 'Finalizada', value: 'Finalizada' },
              { label: 'Cancelada', value: 'Cancelada' }
            ]}
            onChange={handleInputChange}
            disabled={view}
            classInput='md:col-span-2'
          />
        </>
      )}

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Información de la orden de servicio' />
      </div>

      <div className='sm:col-span-6 md:col-span-2'>
        <label className='inline-flex items-center cursor-pointer'>
          <input
            type='checkbox'
            name='cambiar_direccion'
            onChange={handleCheckboxChange}
            className='sr-only peer outline-0'
            disabled={
              ['Finalizada', 'Cancelada'].includes(formData.estatus)
                ? true
                : view
            }
          />
          <div className="relative w-9 h-5 bg-gray-500 cursor-pointer peer-disabled:bg-gray-300 peer-disabled:cursor-auto peer-focus:outline-0 outline-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600" />
          <span className='ms-3 text-sm font-medium text-gray-900'>
            ¿Quiéres cambiar los datos del servicio?
          </span>
        </label>
      </div>

      {formOptions.generalFields.map(({ type, label, name, required }) => (
        <InputField
          key={name}
          type={type}
          label={label}
          name={name}
          required={required}
          value={formData[name] || ''}
          loadOptions={loadOptionsVentas}
          onChange={handleInputChange}
          disabled={
            ['Finalizada', 'Cancelada'].includes(formData.estatus)
              ? true
              : [
                    'domicilio_servicio',
                    'nombre_responsable_sitio',
                    'telefono_responsable_sitio'
                  ].includes(name)
                ? !formData.cambiar_direccion
                : edit && name === 'codigo_orden_servicio'
                  ? true
                  : view
          }
          classInput={type === 'textarea' ? 'md:col-span-2' : 'md:col-span-1'}
        />
      ))}

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Asignación de equipamiento para la orden de servicio (solo si aplica)' />
      </div>

      {dataEequipamiento.loadArtiServ ? (
        <div className='w-full sm:w-[90%] mx-auto'>
          Cargando artículos disponibles...
        </div>
      ) : (
        !dataEequipamiento.errorArtiServ &&
        dataEequipamiento.articulosServicios.map(renderArticulo)
      )}

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Asignación de guardias' />
      </div>

      <InputField
        key={reloadGuardias}
        type='async-multi'
        label='Guardias a asignar *'
        name='guardias_id'
        required={true}
        value={formData.guardias_id || ''}
        onChange={handleInputChange}
        loadOptions={loadOptionsGuardiasBySucursal}
        disabled={
          ['Finalizada', 'Cancelada'].includes(formData.estatus) ? true : view
        }
        classInput='md:col-span-2'
      />
    </div>
  )
}
