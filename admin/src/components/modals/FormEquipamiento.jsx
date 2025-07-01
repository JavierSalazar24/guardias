import { useEquipamiento } from '../../hooks/useEquipamiento'
import { formOptions } from '../../forms/formEquipamientoOptions'
import { AlertaCard } from '../AlertaCard'
import { InputField } from '../InputField'
import { SignatureInput } from '../SignatureInput'
import { RendersArticulos } from '../RendersArticulos'

export const FormEquipamiento = ({
  view,
  edit,
  formData,
  handleInputChange,
  articulosDisponibles,
  handleCheckboxChange,
  loadOptionsGuardias,
  loadOptionsVehiculos
}) => {
  const { articulos, loadArti, errorArti } = useEquipamiento()

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
            loadOptions={loadOptionsGuardias}
            disabled={formData.devuelto === 'SI' ? true : view}
          />
        )
      )}

      <AlertaCard text='Asigna el equipo a prestar' />

      <InputField
        type='async'
        label='Selecciona el vehiculo'
        name='vehiculo_id'
        required={false}
        value={formData.vehiculo_id || ''}
        onChange={handleInputChange}
        loadOptions={loadOptionsVehiculos}
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
  )
}
