import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { FormLimpiezasProgramadas } from '../components/modals/FormLimpiezasProgramadas'
import { useLimpiezasProgramadas } from '../hooks/useLimpiezasProgramadas'

const columns = [
  { key: 'usuario', name: 'Usuario que programó' },
  { key: 'tabla_format', name: 'Tabla' },
  { key: 'periodo_completo', name: 'Eliminar registros que tengan más de...' },
  { key: 'estatus', name: 'Estatus' }
]

export default function LimpiezasProgramadasPage() {
  const {
    modalType,
    add,
    edit,
    closeModal,
    openModal,
    formData,
    currentItem,
    view,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useLimpiezasProgramadas()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Tablas en la que se hará una limpieza programada por el usuario'
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
            <FormLimpiezasProgramadas
              add={add}
              edit={edit}
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
