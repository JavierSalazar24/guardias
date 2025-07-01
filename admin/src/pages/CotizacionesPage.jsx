import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useCotizaciones } from '../hooks/useCotizaciones'
import { FormCotizaciones } from '../components/modals/FormCotizaciones'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'sucursal_cliente', name: 'Sucursal cliente' },
  { key: 'cantidad_guardias', name: 'Guardias totales' },
  { key: 'jefe_turno', name: 'Jefe de turno' },
  { key: 'supervisor', name: 'Supervisor' },
  { key: 'total_servicio', name: 'Total servicio' },
  { key: 'fecha_servicio_format', name: 'Fecha servicio' },
  { key: 'aceptada', name: 'Acpetada' }
]

export default function CotizacionesPage() {
  const {
    modalType,
    add,
    closeModal,
    formData,
    currentItem,
    openModal,
    view,
    edit,
    selectOptions,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useCotizaciones()

  const {
    loadOptionsSucursalesEmpresa,
    loadOptionsClientes,
    loadOptionsTiposServicios
  } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Cotizaciones'
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
            <FormCotizaciones
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsClientes={loadOptionsClientes}
              selectOptions={selectOptions}
              loadOptionsSucursalesEmpresa={loadOptionsSucursalesEmpresa}
              loadOptionsTiposServicios={loadOptionsTiposServicios}
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
