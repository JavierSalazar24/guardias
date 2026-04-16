import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormOrdenesServicios } from '../components/modals/FormOrdenesServicios'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'
import { useEquipamiento } from '../hooks/useEquipamiento'
import { useModal } from '../hooks/useModal'
import { useOrdenesServicio } from '../hooks/useOrdenesServicio'

const columns = [
  { key: 'codigo_orden_servicio', name: 'Código' },
  { key: 'nombre_empresa', name: 'Sucursal' },
  { key: 'domicilio_servicio', name: 'Domicilio' },
  { key: 'inicio_format', name: 'Fecha inicio' },
  { key: 'fin_format', name: 'Fecha fin' },
  { key: 'asignados', name: 'Guardias' },
  { key: 'estatus', name: 'Estatus' }
]

export default function OrdenesServiciosPage() {
  const {
    modalType,
    add,
    closeModal,
    view,
    openModal,
    edit,
    formData,
    reloadGuardias,
    currentItem,
    articulosDisponibles,
    handleInputChange,
    handleCheckboxChange,
    loadOptionsGuardiasBySucursal
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useOrdenesServicio()

  const { loadArtiServ, errorArtiServ, articulosServicios } = useEquipamiento()

  const { loadOptionsVentas } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Ordenes de servicio'
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
            <FormOrdenesServicios
              view={view}
              edit={edit}
              dataEequipamiento={{
                loadArtiServ,
                errorArtiServ,
                articulosServicios
              }}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsVentas={loadOptionsVentas}
              handleCheckboxChange={handleCheckboxChange}
              loadOptionsGuardiasBySucursal={loadOptionsGuardiasBySucursal}
              reloadGuardias={reloadGuardias}
              articulosDisponibles={articulosDisponibles}
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
