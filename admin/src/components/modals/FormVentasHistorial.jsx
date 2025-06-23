import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formVentasHistorialOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormVentasHistorial = () => {
  const {
    view,
    formData,
    handleInputChange,
    loadOptionsCotizaciones,
    loadOptionsBancos
  } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Administrador que modificó la venta' />
        </div>
        {formOptions.adminFields.map(({ type, label, name, required }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            required={required}
            value={formData[name] || ''}
            onChange={handleInputChange}
            disabled={true}
          />
        ))}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Cotización de la venta' />
        </div>
        <InputField
          type='async'
          label='Cotización'
          name='cotizacion_id'
          required={true}
          value={formData.cotizacion_id || ''}
          loadOptions={loadOptionsCotizaciones}
          onChange={handleInputChange}
          disabled={true}
          classInput='md:col-span-2'
        />

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Registro originalmente guardado (antes de cualquier cambio)' />
        </div>
        {formOptions.generalFields.map(
          ({ type, label, name, required, opcSelect }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              loadOptions={
                name === 'cotizacion_id'
                  ? loadOptionsCotizaciones
                  : loadOptionsBancos
              }
              onChange={handleInputChange}
              disabled={true}
            />
          )
        )}

        <InputField
          type='select'
          label='Estatus de la venta'
          name='estatus'
          required={true}
          value={formData.estatus || ''}
          opcSelect={[
            { label: 'Selecciona una opción', value: '' },
            { label: 'Vencida', value: 'Vencida' },
            { label: 'Cancelada', value: 'Cancelada' },
            { label: 'Pendiente', value: 'Pendiente' },
            { label: 'Pagada', value: 'Pagada' }
          ]}
          onChange={handleInputChange}
          disabled={true}
        />

        {formData.estatus === 'Cancelada' && (
          <InputField
            type='textarea'
            label='Mótivo de cancelación'
            name='motivo_cancelada'
            required={false}
            value={formData.motivo_cancelada || ''}
            onChange={handleInputChange}
            disabled={true}
            classInput='md:col-span-2'
          />
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Registro de venta actual (después de algún posible cambio)' />
        </div>

        {formOptions.actualFields.map(
          ({ type, label, name, required, opcSelect }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              onChange={handleInputChange}
              disabled={true}
            />
          )
        )}

        <InputField
          type='select'
          label='Estatus de la venta'
          name='estatus_actualizado'
          required={true}
          value={formData.estatus_actualizado || ''}
          opcSelect={[
            { label: 'Selecciona una opción', value: '' },
            { label: 'Vencida', value: 'Vencida' },
            { label: 'Cancelada', value: 'Cancelada' },
            { label: 'Pendiente', value: 'Pendiente' },
            { label: 'Pagada', value: 'Pagada' }
          ]}
          onChange={handleInputChange}
          disabled={true}
        />

        {formData.estatus_actualizado === 'Cancelada' && (
          <InputField
            type='textarea'
            label='Mótivo de cancelación'
            name='motivo_cancelada_actualizado'
            required={false}
            value={formData.motivo_cancelada_actualizado || ''}
            onChange={handleInputChange}
            disabled={true}
            classInput='md:col-span-2'
          />
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
