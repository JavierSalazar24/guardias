import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formCotizacionOptions'
import { AlertaCard } from '../AlertaCard'
import { CotizacionNormal } from '../CotizacionNormal'
import { InputField } from '../InputField'
import { SwitchInput } from '../SwitchInput'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormCotizaciones = () => {
  const {
    view,
    edit,
    formData,
    handleInputChange,
    handleFileChange,
    opcionesEstados,
    municipios,
    loadOptionsClientes,
    selectOptions,
    loadOptionsSucursalesEmpresa
  } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {edit && (
          <>
            <div className='sm:col-span-6 md:col-span-2'>
              <AlertaCard text='Información	de cotización aceptada' />
            </div>

            <InputField
              type='select'
              label='¿Cotización aceptada? *'
              name='aceptada'
              required={true}
              value={formData.aceptada || ''}
              onChange={handleInputChange}
              disabled={view}
              opcSelect={formOptions.opcSelect}
              classInput='md:col-span-2'
            />

            {formData.aceptada === 'SI' &&
              formOptions.aceptadaFields.map(
                ({ type, label, name, required, opcSelect, step }) => (
                  <InputField
                    key={name}
                    type={type}
                    label={label}
                    name={name}
                    step={step}
                    required={required}
                    opcSelect={opcSelect}
                    value={formData[name] || ''}
                    disabled={view}
                    onChange={handleInputChange}
                    classInput='md:col-span-1'
                  />
                )
              )}
          </>
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Sucursal de la empresa donde se hará la cotización' />
        </div>
        <InputField
          type='async'
          label='Selecciona la sucursal *'
          name='sucursal_empresa_id'
          required={true}
          value={formData.sucursal_empresa_id || ''}
          onChange={handleInputChange}
          disabled={formData.aceptada === 'SI' ? true : view}
          loadOptions={loadOptionsSucursalesEmpresa}
          classInput='md:col-span-2'
        />

        <SwitchInput
          card='Cotización para...'
          value='cliente_existente'
          text='¿La cotización es para un cliente?'
        />

        {formData.cliente_existente ? (
          <>
            <InputField
              type='async'
              label='Selecciona al cliente *'
              name='cliente_id'
              required={true}
              value={formData.cliente_id || ''}
              onChange={handleInputChange}
              loadOptions={loadOptionsClientes}
              disabled={formData.aceptada === 'SI' ? true : view}
              classInput='md:col-span-2'
            />

            <InputField
              type='select'
              label='Selecciona la sucursal *'
              name='sucursal_id'
              required={true}
              value={formData.sucursal_id || ''}
              onChange={handleInputChange}
              opcSelect={selectOptions}
              disabled={
                selectOptions.length === 0 || formData.aceptada === 'SI'
                  ? true
                  : view
              }
              classInput='md:col-span-1'
            />

            <InputField
              type='text'
              label='Días de credito *'
              name='credito_dias'
              required={true}
              value={formData.credito_dias || ''}
              onChange={handleInputChange}
              disabled={formData.aceptada === 'SI' ? true : view}
              classInput='md:col-span-1'
            />
          </>
        ) : (
          <CotizacionNormal
            opcionesEstados={opcionesEstados}
            municipios={municipios}
            loadOptionsClientes={loadOptionsClientes}
            formOptions={formOptions}
            formData={formData}
            handleInputChange={handleInputChange}
            handleFileChange={handleFileChange}
            view={view}
          />
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Información	general de servicios' />
        </div>

        <InputField
          type='textarea'
          label='Servicios *'
          name='servicios'
          required={true}
          value={formData.servicios || ''}
          onChange={handleInputChange}
          disabled={formData.aceptada === 'SI' ? true : view}
          classInput='md:col-span-2'
        />

        {formOptions.serviciosFields.map(
          ({ type, label, name, required, step, opcSelect }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              step={step}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              onChange={handleInputChange}
              disabled={
                [
                  'cantidad_guardias',
                  'precio_guardias_dia_total',
                  'precio_guardias_noche_total'
                ].includes(name) || formData.aceptada === 'SI'
                  ? true
                  : view
              }
              classInput='md:col-span-1'
            />
          )
        )}

        {formData.jefe_turno === 'SI' && (
          <InputField
            type='number'
            label='Costo por jefe de turno *'
            name='precio_jefe_turno'
            required={true}
            step='0.01'
            value={formData.precio_jefe_turno || ''}
            onChange={handleInputChange}
            disabled={formData.aceptada === 'SI' ? true : view}
            classInput='md:col-span-1'
          />
        )}

        {formData.supervisor === 'SI' && (
          <InputField
            type='number'
            label='Costo por supervisor *'
            name='precio_supervisor'
            required={true}
            step='0.01'
            value={formData.precio_supervisor || ''}
            onChange={handleInputChange}
            disabled={formData.aceptada === 'SI' ? true : view}
            classInput='md:col-span-1'
          />
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Otra información' />
        </div>

        <InputField
          type='textarea'
          label='Requisitos para pago del cliente'
          name='requisitos_pago_cliente'
          required={false}
          value={formData.requisitos_pago_cliente || ''}
          onChange={handleInputChange}
          disabled={formData.aceptada === 'SI' ? true : view}
          classInput='md:col-span-2'
        />

        <InputField
          type='select'
          label='Soporte documental *'
          name='soporte_documental'
          required={true}
          opcSelect={[
            { value: '', label: 'Selecciona una opción' },
            { value: 'SI', label: 'SI' },
            { value: 'NO', label: 'NO' }
          ]}
          value={formData.soporte_documental || ''}
          onChange={handleInputChange}
          disabled={formData.aceptada === 'SI' ? true : view}
          classInput='md:col-span-2'
        />

        {formData.soporte_documental === 'SI' && (
          <InputField
            type='textarea'
            label='Observaciones *'
            name='observaciones_soporte_documental'
            required={false}
            value={formData.observaciones_soporte_documental || ''}
            onChange={handleInputChange}
            disabled={formData.aceptada === 'SI' ? true : view}
            classInput='md:col-span-2'
          />
        )}

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Total' />
        </div>

        <InputField
          type='number'
          step='0.01'
          label='Porcentaje de impuestos (si no aplica introducir 0) *'
          name='impuesto'
          required={true}
          value={formData.impuesto || ''}
          onChange={handleInputChange}
          disabled={formData.aceptada === 'SI' ? true : view}
          classInput='md:col-span-2'
        />

        {formOptions.montosFields.map(
          ({ type, label, name, required, step }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              step={step}
              value={formData[name] || ''}
              disabled={
                ['total'].includes(name) || formData.aceptada === 'SI'
                  ? true
                  : view
              }
              onChange={handleInputChange}
              classInput='md:col-span-1'
            />
          )
        )}

        <InputField
          type='textarea'
          label='Notas extras'
          name='notas'
          required={false}
          value={formData.notas || ''}
          onChange={handleInputChange}
          disabled={formData.aceptada === 'SI' ? true : view}
          classInput='md:col-span-2'
        />
      </div>

      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
