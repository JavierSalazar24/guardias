import { formOptions } from '../../forms/formCotizacionOptions'
import { AlertaCard } from '../AlertaCard'
import { CotizacionAceptada } from '../CotizacionAceptada'
import { InputField } from '../InputField'

export const FormCotizaciones = ({
  view,
  edit,
  formData,
  handleInputChange,
  loadOptionsClientes,
  selectOptions,
  loadOptionsSucursalesEmpresa,
  loadOptionsTiposServicios
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {edit && (
        <CotizacionAceptada
          formData={formData}
          handleInputChange={handleInputChange}
          view={view}
          formOptions={formOptions}
        />
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

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Datos del cliente' />
      </div>
      {formOptions.clienteFiels.map(({ type, label, name, required }) => (
        <InputField
          key={name}
          type={type}
          label={label}
          name={name}
          required={required}
          opcSelect={selectOptions}
          loadOptions={loadOptionsClientes}
          value={formData[name] || ''}
          onChange={handleInputChange}
          disabled={formData.aceptada === 'SI' ? true : view}
          classInput='md:col-span-2'
        />
      ))}

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Servicios' />
      </div>
      {formOptions.serviciosFields.map(
        ({ type, label, name, required, step }) => (
          <InputField
            key={name}
            type={type}
            label={label}
            name={name}
            required={required}
            step={step}
            value={formData[name] || ''}
            onChange={handleInputChange}
            loadOptions={loadOptionsTiposServicios}
            disabled={
              name === 'precio_total_servicios' || formData.aceptada === 'SI'
                ? true
                : view
            }
            classInput='md:col-span-2'
          />
        )
      )}

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Información	general del servicio' />
      </div>
      {formOptions.requerimientosFields.map(
        ({ type, label, name, required, step, opcSelect, condition }) =>
          (!condition || condition(formData)) && (
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

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Otra información' />
      </div>
      {formOptions.otraInformacionFields.map(
        ({ type, label, name, required, opcSelect, condition }) =>
          (!condition || condition(formData.soporte_documental)) && (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={required}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              onChange={handleInputChange}
              disabled={formData.aceptada === 'SI' ? true : view}
              classInput='md:col-span-2'
            />
          )
      )}

      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Total' />
      </div>
      {formOptions.montosFields.map(({ type, label, name, required, step }) => (
        <InputField
          key={name}
          type={type}
          label={label}
          name={name}
          required={required}
          step={step}
          value={formData[name] || ''}
          disabled={
            ['subtotal', 'total'].includes(name) || formData.aceptada === 'SI'
              ? true
              : view
          }
          onChange={handleInputChange}
          classInput={name === 'total' ? 'md:col-span-2' : 'md:col-span-1'}
        />
      ))}

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
  )
}
