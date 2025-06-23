import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useEquipamiento } from '../hooks/useEquipamiento'
import { FormEquipamiento } from '../components/modals/FormEquipamiento'

const columns = [
  { key: 'guardia', name: 'Guardia' },
  { key: 'vehiculo', name: 'Vehículo' },
  { key: 'equipo', name: 'Equipo asignado' },
  { key: 'fecha_entrega_format', name: 'Fecha entrega' },
  { key: 'fecha_devuelto_format', name: 'Fecha devuelto' }
]

export default function EquipamientoPage() {
  const {
    modalType,
    currentItem,
    view,
    edit,
    formData,
    handleInputChange,
    articulosDisponibles,
    handleCheckboxChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useEquipamiento()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Asignación de equipo al guardia'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
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

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
