import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useRecursosHumanos } from '../hooks/useRecursosHumanos'
import { FormRecursosHumanos } from '../components/modals/FormRecursosHumanos'

const columns = [
  { key: 'nombre_guardia', name: 'Nombre del guardia' },
  { key: 'sueldo_format', name: 'Sueldo' },
  { key: 'dias_laborales', name: 'Dias que labora' }
]

export default function RecursosHumanosPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useRecursosHumanos()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Recursos Humanos'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          Inputs={<FormRecursosHumanos />}
        />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
