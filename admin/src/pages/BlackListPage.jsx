import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useBlackList } from '../hooks/useBlackList'
import { FormBlackList } from '../components/modals/FormBlackList'
import { ModalWhiteList } from '../components/ModalWhiteList'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre', name: 'Guardia' },
  { key: 'motivo_baja', name: 'Motivo de baja' },
  { key: 'telefono', name: 'Teléfono' },
  { key: 'correo', name: 'Correo' }
]

export default function BlackListPage() {
  const {
    modalType,
    closeModal,
    openModal,
    formData,
    currentItem,
    view,
    add,
    document,
    handleInputChange,
    handleFileChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useBlackList()

  const { loadOptionsSucursalesEmpresa, loadOptionsTodosGuardias } =
    useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Lista negra de guardias'
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
            <FormBlackList
              view={view}
              add={add}
              document={document}
              formData={formData}
              handleInputChange={handleInputChange}
              handleFileChange={handleFileChange}
              loadOptionsSucursalesEmpresa={loadOptionsSucursalesEmpresa}
              loadOptionsTodosGuardias={loadOptionsTodosGuardias}
            />
          }
        />
      )}

      {modalType === 'whitelist' && currentItem && (
        <ModalWhiteList
          handleDelete={handleDelete}
          closeModal={closeModal}
          formData={formData}
        />
      )}
    </div>
  )
}
