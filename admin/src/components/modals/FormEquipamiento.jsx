import { useEquipamiento } from '../../hooks/useEquipamiento'
import { formOptions } from '../../utils/formEquipamientoOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { SignatureInput } from '../SignatureInput'
import { SwitchInputEquipamiento } from '../SwitchInputEquipamiento'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormEquipamiento = ({
  view,
  edit,
  formData,
  handleInputChange,
  articulosDisponibles,
  handleCheckboxChange
}) => {
  const {
    articulos,
    loadArti,
    errorArti,
    loadOptionsGuardia,
    loadOptionsVehiculo
  } = useEquipamiento()

  const renderArticulo = (articulo) => {
    const key = `articulo-${articulo.nombre}-${articulo.id}`
    const inputKey = `serie-select-${articulo.id}`
    const articuloDisponible = articulosDisponibles[key] || []

    const isChecked = formData[key] || false

    return (
      <div key={articulo.id} className='w-full sm:w-[90%] mx-auto'>
        <SwitchInputEquipamiento
          name={key}
          value={`${articulo.nombre}-${articulo.id}`}
          formData={isChecked}
          handleCheckboxChange={handleCheckboxChange}
          view={formData.devuelto === 'SI' ? true : view}
          text={articulo.nombre}
        />

        {isChecked && (
          <div className='my-1'>
            <InputField
              key={inputKey}
              type='select'
              label='Selecciona número de serie'
              name={`seleccionado-numero_serie-${articulo.id}`}
              required={true}
              value={formData[`seleccionado-numero_serie-${articulo.id}`] || ''}
              onChange={handleInputChange}
              disabled={formData.devuelto === 'SI' ? true : view}
              opcSelect={[
                { label: 'Selecciona una opción', value: '' },
                ...articuloDisponible.map((item) => ({
                  label: item.numero_serie,
                  value: item.numero_serie
                }))
              ]}
            />
          </div>
        )}
      </div>
    )
  }

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-1 md:grid-cols-1 mb-7'>
        {edit && (
          <>
            <AlertaCard text='Devolución de equipo' />
            <InputField
              type='select'
              label='¿Equipo devuelto? *'
              name='devuelto'
              required={true}
              value={formData.devuelto || ''}
              onChange={handleInputChange}
              disabled={formData.devuelto === 'SI' ? true : view}
              opcSelect={[
                { label: 'Selecciona una opción', value: '' },
                { label: 'SI', value: 'SI' },
                { label: 'NO', value: 'NO' }
              ]}
            />
          </>
        )}

        {formData.devuelto === 'SI' && (
          <InputField
            type='date'
            label='Fecha de equipo devuelto *'
            name='fecha_devuelto'
            required={true}
            value={formData.fecha_devuelto || ''}
            onChange={handleInputChange}
            disabled={view}
          />
        )}

        <AlertaCard text='Información de equipo a prestar' />
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
              onChange={handleInputChange}
              loadOptions={loadOptionsGuardia}
              disabled={formData.devuelto === 'SI' ? true : view}
            />
          )
        )}

        <AlertaCard text='Asigna el equipo a prestar' />

        <InputField
          type='async'
          label='Selecciona el vehiculo *'
          name='vehiculo_id'
          required={true}
          value={formData.vehiculo_id || ''}
          onChange={handleInputChange}
          loadOptions={loadOptionsVehiculo}
          disabled={formData.devuelto === 'SI' ? true : view}
        />

        {!loadArti && !errorArti && articulos.map(renderArticulo)}

        <InputField
          type='textarea'
          label='Otro(s) equipo(s) no listado(s) (no es obligatorio rellenar)'
          name='otro'
          required={false}
          value={formData.otro || ''}
          onChange={handleInputChange}
          disabled={formData.devuelto === 'SI' ? true : view}
        />

        <AlertaCard text='Firma del guardia' />
        <SignatureInput view={view} formData={formData} />
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
