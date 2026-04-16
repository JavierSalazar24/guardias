import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useBoletasGasolina } from '../hooks/useBoletasGasolina'
import { FormBoletasGasolina } from '../components/modals/FormBoletasGasolina'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'banco', name: 'Banco' },
  { key: 'vehiculo_tipo', name: 'Vehículo' },
  { key: 'kilometraje', name: 'Kilometraje' },
  { key: 'litros', name: 'Litros gasolina' },
  { key: 'costo_litro_format', name: 'Costo x litro' },
  { key: 'costo_total_format', name: 'Total' },
  { key: 'fecha', name: 'Fecha' }
]

export default function BoletasGasolinaPage() {
  const {
    modalType,
    add,
    closeModal,
    formData,
    currentItem,
    openModal,
    view,
    edit,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useBoletasGasolina()

  const { loadOptionsVehiculos, loadOptionsBancos } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Boletas de gasolina'
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
            <FormBoletasGasolina
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsVehiculos={loadOptionsVehiculos}
              loadOptionsBancos={loadOptionsBancos}
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
