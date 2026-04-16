import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { usePagoEmpleado } from '../hooks/usePagoEmpleado'
import { FormPagosEmpleado } from '../components/modals/FormPagosEmpleado'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre', name: 'Nombre' },
  { key: 'fecha_inicio', name: 'Periodo inicio' },
  { key: 'fecha_fin', name: 'Periodo fin' },
  { key: 'sueldo', name: 'Sueldo base' },
  { key: 'ingresos', name: 'Ingresos' },
  { key: 'egresos', name: 'Egresos' },
  { key: 'retenciones', name: 'Retenciones' },
  { key: 'bruto', name: 'Pago bruto' },
  { key: 'total', name: 'Pago neto' }
]

export default function PagosEmpleadosPage() {
  const {
    modalType,
    closeModal,
    view,
    add,
    edit,
    openModal,
    formData,
    currentItem,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    usePagoEmpleado()

  const { loadOptionsTodosGuardias, loadOptionsBancos } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Pagos de guardias'
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
            <FormPagosEmpleado
              view={view}
              add={add}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsTodosGuardias={loadOptionsTodosGuardias}
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
