import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useTiempoExtra } from '../hooks/useTiempoExtra'
import { FormTiempoExtra } from '../components/modals/FormTiempoExtra'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre', name: 'Guardia' },
  { key: 'fecha_inicio_format', name: 'Inicio del periodo' },
  { key: 'fecha_fin_format', name: 'Fin del periodo' },
  { key: 'horas', name: 'Horas extras trabajadas' },
  { key: 'monto_hora_format', name: 'Pagado x hora' },
  { key: 'monto_total_format', name: 'Pagado total' }
]

export default function TiempoExtraPage() {
  const {
    modalType,
    add,
    openModal,
    closeModal,
    view,
    formData,
    currentItem,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useTiempoExtra()

  const { loadOptionsTodosGuardias } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Tiempo extra'
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
            <FormTiempoExtra
              view={view}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsTodosGuardias={loadOptionsTodosGuardias}
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
