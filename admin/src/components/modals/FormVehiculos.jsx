import { useModal } from '../../hooks/useModal'
import { formOptions } from '../../utils/formVehiculosOptions'
import { InputField } from '../InputField'
import { ButtonsModal } from './ButtonsModal'
import { CancelButtonModal } from './CancelButtonModal'

export const FormVehiculos = () => {
  const {
    view,
    edit,
    document,
    formData,
    handleInputChange,
    handleMultipleFilesChange,
    handleFileChange
  } = useModal()

  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        {formOptions.generalFields.map(
          ({ type, label, name, opcSelect, accept, multiple }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              multiple={multiple}
              required={!document}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              accept={accept}
              onChange={
                type === 'file' ? handleMultipleFilesChange : handleInputChange
              }
              disabled={view}
              document={
                type === 'file' ? formData[`${name}_url`] || null : false
              }
              classInput='md:col-span-1'
            />
          )
        )}

        {formOptions.seguroFields.map(
          ({ type, label, name, opcSelect, accept }) => (
            <InputField
              key={name}
              type={type}
              label={label}
              name={name}
              required={!document}
              value={formData[name] || ''}
              opcSelect={opcSelect}
              accept={accept}
              onChange={type === 'file' ? handleFileChange : handleInputChange}
              disabled={view}
              document={
                type === 'file' ? formData[`${name}_url`] || null : false
              }
              classInput='md:col-span-1'
            />
          )
        )}

        {edit && (
          <InputField
            type='select'
            label='Selecciona el estado del vehículo *'
            name='estado'
            required={true}
            value={formData.estado || ''}
            opcSelect={[
              { label: 'Selecciona una opción', value: '' },
              { label: 'Disponible', value: 'Disponible' },
              { label: 'Asignado', value: 'Asignado' },
              { label: 'En reparación', value: 'En reparación' },
              { label: 'Fuera de servicio', value: 'Fuera de servicio' },
              { label: 'Accidente', value: 'Accidente' },
              { label: 'Robado', value: 'Robado' },
              { label: 'Vendido', value: 'Vendido' }
            ]}
            onChange={handleInputChange}
            disabled={view}
            classInput='md:col-span-1'
          />
        )}
      </div>
      <hr className='text-gray-300' />
      {view ? <CancelButtonModal /> : <ButtonsModal />}
    </>
  )
}
