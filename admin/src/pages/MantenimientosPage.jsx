import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useMantenimientos } from '../hooks/useMantenimientos'
import { FormMantenimientos } from '../components/modals/FormMantenimientos'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'fecha_ingreso_format', name: 'Fecha Ingreso' },
  { key: 'motivo_ingreso', name: 'Motivo' },
  { key: 'estatus', name: 'Estatus' },
  { key: 'taller_nombre', name: 'Taller' },
  { key: 'vehiculo_nombre', name: 'Vehículo' },
  { key: 'costo_format', name: 'Costo' },
  { key: 'fecha_salida_format', name: 'Fecha Salida' }
]

export default function MantenimientosPage() {
  const {
    modalType,
    add,
    closeModal,
    openModal,
    formData,
    currentItem,
    view,
    edit,
    handleInputChange
  } = useModal()

  const { loadOptionsTalleres, loadOptionsVehiculos } = useCatalogLoaders()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useMantenimientos()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Mantenimientos de vehículos'
        loading={isLoading}
        openModal={openModal}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          view={view}
          add={add}
          closeModal={closeModal}
          Inputs={
            <FormMantenimientos
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsTalleres={loadOptionsTalleres}
              loadOptionsVehiculos={loadOptionsVehiculos}
            />
          }
        />
      )}

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
