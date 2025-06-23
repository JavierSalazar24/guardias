import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { FormEquipamiento } from '../components/modals/FormEquipamiento'
import { useEquipamientoHistorial } from '../hooks/useEquipamientoHistorial'

const columns = [
  { key: 'guardia', name: 'Guardia' },
  { key: 'vehiculo', name: 'Vehículo' },
  { key: 'equipo', name: 'Equipo asignado' },
  { key: 'fecha_entrega_format', name: 'Fecha entrega' },
  { key: 'fecha_devuelto_format', name: 'Fecha devuelto' }
]

export default function EquipamientoHistorialPage() {
  const {
    modalType,
    view,
    edit,
    formData,
    handleInputChange,
    articulosDisponibles,
    handleCheckboxChange
  } = useModal()

  const { data, isLoading, isError, error } = useEquipamientoHistorial()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Historial de asignación de equipo al guardia'
        loading={isLoading}
      />

      {modalType === 'view' && (
        <BaseForm
          Inputs={
            <FormEquipamiento
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              articulosDisponibles={articulosDisponibles}
              handleCheckboxChange={handleCheckboxChange}
            />
          }
        />
      )}
    </div>
  )
}
