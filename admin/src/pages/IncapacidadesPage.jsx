import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useIncapacidades } from '../hooks/useIncapacidades'
import { FormIncapacidades } from '../components/modals/FormIncapacidades'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre', name: 'Guardia' },
  { key: 'fecha_inicio_format', name: 'Inicio de incapacidad' },
  { key: 'fecha_fin_format', name: 'Fin de incapacidad' },
  { key: 'pago_empresa_format', name: 'Pago por parte de la empresa' },
  { key: 'motivo', name: 'Motivo de incapacidad' }
]

export default function IncapacidadesPage() {
  const {
    modalType,
    add,
    closeModal,
    openModal,
    view,
    formData,
    currentItem,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useIncapacidades()

  const { loadOptionsTodosGuardias } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Incapacidades'
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
            <FormIncapacidades
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
