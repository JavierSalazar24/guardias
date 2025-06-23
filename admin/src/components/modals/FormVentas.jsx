import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formVentasOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormVentas = () => {
  const {
    view,
    edit,
    formData,
    handleInputChange,
    loadOptionsCotizaciones,
    loadOptionsBancos
  } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {edit && formData.estatus !== 'Cancelada' && (
          <InputField
            type='select'
            label='Estatus de la venta *'
            name='estatus'
            required={true}
            value={formData.estatus || ''}
            opcSelect={[
              { label: 'Selecciona una opción', value: '' },
              { label: 'Pendiente', value: 'Pendiente' },
              { label: 'Pagada', value: 'Pagada' },
              { label: 'Vencida', value: 'Vencida' }
            ]}
            onChange={handleInputChange}
            disabled={['Pagada'].includes(formData.estatus) ? true : view}
            classInput='md:col-span-1'
          />
        )}

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

        {formOptions.generalFields.map(
          ({ type, label, name, required, opcSelect, step }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              step={step}
              loadOptions={loadOptionsCotizaciones}
              onChange={handleInputChange}
              disabled={
                ['Cancelada', 'Pagada', 'Vencida'].includes(formData.estatus) ||
                ['cotizacion_id'].includes(name) ||
                (formData.tipo_pago === 'Contado' &&
                  name === 'fecha_vencimiento')
                  ? true
                  : view
              }
              classInput='md:col-span-1'
            />
          )
        )}

        {formData.estatus === 'Pagada' && (
          <>
            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Información de pago' />
            </div>

            {formOptions.pagadaFields.map(
              ({ type, label, name, required, opcSelect, step, condition }) =>
                (!condition || condition(formData.metodo_pago)) && (
                  <InputField
                    key={name}
                    type={type}
                    label={label}
                    name={name}
                    required={required}
                    value={formData[name] || ''}
                    opcSelect={opcSelect}
                    step={step}
                    loadOptions={loadOptionsBancos}
                    onChange={handleInputChange}
                    disabled={view}
                    classInput='md:col-span-2'
                  />
                )
            )}
          </>
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
