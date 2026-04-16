import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useSupervisiones } from '../hooks/useSupervisiones'
import { FormSupervisiones } from '../components/modals/FormSupervisiones'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'supervisor_nombre', name: 'Supervisor' },
  { key: 'guardia_nombre', name: 'Guardia' },
  { key: 'nombre_sucursal', name: 'Sucursal alta' },
  { key: 'sucursal_cliente', name: 'Cliente Asignado' },
  { key: 'asistencia', name: 'Asistencia' },
  { key: 'uniforme', name: 'Uniforme' },
  { key: 'equipamiento', name: 'Equipamiento' },
  { key: 'lugar_trabajo', name: 'Lugar Trabajo' }
]

export default function SupervisionesPage() {
  const {
    modalType,
    closeModal,
    view,
    add,
    openModal,
    document,
    formData,
    currentItem,
    handleInputChange,
    handleSelectedFile
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useSupervisiones()

  const { loadOptionsGuardias } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Supervisiones'
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
            <FormSupervisiones
              view={view}
              document={document}
              formData={formData}
              handleInputChange={handleInputChange}
              handleSelectedFile={handleSelectedFile}
              loadOptionsGuardias={loadOptionsGuardias}
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
