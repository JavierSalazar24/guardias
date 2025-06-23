import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formOrdenesServicios'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormOrdenesServicios = () => {
  const {
    view,
    edit,
    formData,
    handleInputChange,
    loadOptionsVentas,
    handleCheckboxChange,
    loadOptionsGuardiasBySucursal,
    selectSupervisorBySucursal,
    selectJefeBySucursal,
    reloadGuardias
  } = useModal()

  return (
    <>
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
            ¿Quiéres cambiar la dirección del servicio?
          </span>
        </label>

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
                : name === 'domicilio_servicio'
                ? !formData.cambiar_direccion
                : edit && name === 'codigo_orden_servicio'
                ? true
                : view
            }
            classInput='md:col-span-2'
          />
        ))}

        {formData.jefe_turno === 'SI' && (
          <>
            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Asignación de jefe de turno' />
            </div>

            <InputField
              type='select'
              label='Jefe de turno a asignar *'
              name='jefe_turno_id'
              required={true}
              value={formData.jefe_turno_id || ''}
              onChange={handleInputChange}
              opcSelect={selectJefeBySucursal}
              disabled={
                ['Finalizada', 'Cancelada'].includes(formData.estatus)
                  ? true
                  : view
              }
              classInput='md:col-span-2'
            />
          </>
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

        {formData.supervisor === 'SI' && (
          <>
            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Asignación de supervisores' />
            </div>

            <InputField
              type='select'
              label='Supervisor a asignar *'
              name='supervisor_id'
              required={true}
              value={formData.supervisor_id || ''}
              onChange={handleInputChange}
              opcSelect={selectSupervisorBySucursal}
              disabled={
                ['Finalizada', 'Cancelada'].includes(formData.estatus)
                  ? true
                  : view
              }
              classInput='md:col-span-2'
            />
          </>
        )}

        {(view || edit) && (
          <>
            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Datos fiscales informativos de la sucursal' />
            </div>
            {formOptions.rfcFields.map(({ type, label, name, required }) => (
              <InputField
                key={name}
                type={type}
                label={label}
                name={name}
                required={required}
                value={formData[name] || ''}
                onChange={handleInputChange}
                disabled={true}
                classInput='md:col-span-1'
                document={formData[`${name}_url`] || null}
              />
            ))}
          </>
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
