import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useDocumentos } from '../hooks/useDocumentos'
import { FormDocumentos } from '../components/modals/FormDocumentos'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre_guardia', name: 'Guardia' },
  { key: 'nombre_documento', name: 'Tipo de documento' }
]

export default function DocumentosPage() {
  const {
    modalType,
    add,
    edit,
    closeModal,
    formData,
    currentItem,
    openModal,
    view,
    document,
    handleInputChange,
    handleFileChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useDocumentos()

  const { loadOptionsGuardias, loadOptionsTiposDocumentos } =
    useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Documentos del guardia'
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
            <FormDocumentos
              view={view}
              edit={edit}
              document={document}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsGuardias={loadOptionsGuardias}
              loadOptionsTiposDocumentos={loadOptionsTiposDocumentos}
              handleFileChange={handleFileChange}
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
