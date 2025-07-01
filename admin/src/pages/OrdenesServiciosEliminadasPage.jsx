import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormOrdenesServicios } from '../components/modals/FormOrdenesServicios'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'
import { useModal } from '../hooks/useModal'
import { useOrdenesServicioEliminadas } from '../hooks/useOrdenesServicioEliminadas'

const columns = [
  { key: 'codigo_orden_servicio', name: 'Código' },
  { key: 'nombre_empresa', name: 'Sucursal' },
  { key: 'domicilio_servicio', name: 'Domicilio' },
  { key: 'inicio_format', name: 'Fecha inicio' },
  { key: 'asignados', name: 'Guardias' },
  { key: 'estatus', name: 'Estatus' }
]

export default function OrdenesServiciosEliminadasPage() {
  const {
    modalType,
    closeModal,
    view,
    openModal,
    formData,
    selectSupervisorBySucursal,
    selectJefeBySucursal,
    reloadGuardias,
    handleInputChange,
    handleCheckboxChange,
    loadOptionsGuardiasBySucursal
  } = useModal()

  const { data, isLoading, isError, error } = useOrdenesServicioEliminadas()

  const { loadOptionsVentas } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Historial de las ordenes de servicio eliminidas'
        loading={isLoading}
        openModal={openModal}
      />

      {modalType === 'view' && (
        <BaseForm
          view={view}
          closeModal={closeModal}
          Inputs={
            <FormOrdenesServicios
              view={view}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsVentas={loadOptionsVentas}
              handleCheckboxChange={handleCheckboxChange}
              loadOptionsGuardiasBySucursal={loadOptionsGuardiasBySucursal}
              selectSupervisorBySucursal={selectSupervisorBySucursal}
              selectJefeBySucursal={selectJefeBySucursal}
              reloadGuardias={reloadGuardias}
            />
          }
        />
      )}
    </div>
  )
}
