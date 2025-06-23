import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormVehiculos } from '../components/modals/FormVehiculos'
import { useModal } from '../hooks/useModal'
import { useVehiculos } from '../hooks/useVehiculos'

const columns = [
  { key: 'tipo_vehiculo', name: 'Vehículo' },
  { key: 'marca', name: 'Marca' },
  { key: 'modelo', name: 'Modelo' },
  { key: 'placas', name: 'Placas' },
  { key: 'aseguradora', name: 'Aseguradora' },
  { key: 'telefono_aseguradora', name: 'Teléfono' },
  { key: 'estado', name: 'Estado' }
]

export default function VehiculosPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useVehiculos()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Vehículos'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormVehiculos />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
