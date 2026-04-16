import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormMotivosActas } from '../components/modals/FormMotivosActas'
import { useMotivosActas } from '../hooks/useMotivosActas'
import { useModal } from '../hooks/useModal'

const columns = [
  { key: 'motivo', name: 'Motivo' },
  { key: 'descripcion', name: 'Descripción' }
]

export default function MotivosActasPage() {
  const {
    modalType,
    currentItem,
    view,
    add,
    openModal,
    closeModal,
    formData,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useMotivosActas()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Motivos de Actas Administrativas'
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
            <FormMotivosActas
              view={view}
              formData={formData}
              handleInputChange={handleInputChange}
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
