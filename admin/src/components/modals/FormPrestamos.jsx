import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formPrestamosOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormPrestamos = () => {
  const {
    view,
    document,
    formData,
    handleInputChange,
    loadOptionsTodosGuardias,
    loadOptionsModuloPrestamo,
    loadOptionsBancos
  } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {formData.estatus === 'Pagado' && (
          <InputField
            type='date'
            label='Fecha del préstamo liquidado'
            name={name}
            required={true}
            value={formData.fecha_pagado || ''}
            onChange={handleInputChange}
            disabled={true}
            classInput='md:col-span-2'
          />
        )}

        {formOptions.generalFields.map(
          ({ type, label, name, required, step }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              step={step}
              onChange={handleInputChange}
              loadOptions={
                name === 'guardia_id'
                  ? loadOptionsTodosGuardias
                  : name === 'banco_id'
                  ? loadOptionsBancos
                  : loadOptionsModuloPrestamo
              }
              disabled={
                ([
                  'monto_total',
                  'guardia_id',
                  'banco_id',
                  'fecha_prestamo'
                ].includes(name) &&
                  document) ||
                (['numero_pagos', 'modulo_prestamo_id'].includes(name) &&
                  formData.estatus === 'Pagado')
                  ? true
                  : view
              }
              classInput={
                name === 'observaciones' ? 'md:col-span-2' : 'md:col-span-1'
              }
            />
          )
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Método de pago' />
        </div>
        {formOptions.metodoFields.map(
          ({ type, label, name, required, step, condition, opcSelect }) =>
            (!condition || condition(formData.metodo_pago)) && (
              <InputField
                key={name}
                type={type}
                label={label}
                name={name}
                required={required}
                opcSelect={opcSelect}
                value={formData[name] || ''}
                step={step}
                onChange={handleInputChange}
                disabled={view}
                classInput='md:col-span-2'
              />
            )
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
