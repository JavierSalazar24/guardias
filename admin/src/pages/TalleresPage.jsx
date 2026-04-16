import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useTalleres } from '../hooks/useTalleres'
import { FormTalleres } from '../components/modals/FormTalleres'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre', name: 'Nombre' },
  { key: 'direccion', name: 'Dirección' }
]

export default function TalleresPage() {
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

  const { loadOptionsGuardias, loadOptionsUsuarios } = useCatalogLoaders()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useTalleres()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Talleres'
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
            <FormTalleres
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsGuardias={loadOptionsGuardias}
              loadOptionsUsuarios={loadOptionsUsuarios}
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
