import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useRecorridosGuardia } from '../hooks/useRecorridosGuardia'

const columns = [
  { key: 'orden', name: 'Orden de servicio' },
  { key: 'nombre', name: 'Guardia' },
  { key: 'nombre_punto', name: 'Escaneo' },
  { key: 'fecha_format', name: 'Fecha de escaneo' },
  { key: 'observaciones', name: 'Observaciones' }
]

export default function RecorridosGuardiaPage() {
  const { modalType, closeModal, formData, currentItem, openModal } = useModal()

  const { data, isLoading, isError, error, handleDelete } =
    useRecorridosGuardia()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Recorridos guardados de los guardias'
        loading={isLoading}
        openModal={openModal}
      />

      {modalType === 'delete' && currentItem && (
        <ModalDelete
          handleDelete={handleDelete}
          closeModal={closeModal}
          formData={formData}
        />
      )}
    </div>
  )
}
