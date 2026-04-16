import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useActasAdministrativas } from '../hooks/useActasAdministrativas'
import { FormActasAdministrativas } from '../components/modals/FormActasAdministrativas'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'motivo_nombre', name: 'Motivo' },
  { key: 'fecha_hora_format', name: 'Fecha y hora' },
  { key: 'supervisor_nombre', name: 'Supervisor' },
  { key: 'empleado_nombre', name: 'Empleado' }
]

export default function ActasAdministrativasPage() {
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

  const { loadOptionsGuardiasActas, loadOptionsMotivosActas } =
    useCatalogLoaders()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useActasAdministrativas()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Actas administrativas'
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
            <FormActasAdministrativas
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsGuardiasActas={loadOptionsGuardiasActas}
              loadOptionsMotivosActas={loadOptionsMotivosActas}
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
