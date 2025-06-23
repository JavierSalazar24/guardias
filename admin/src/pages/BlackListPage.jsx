import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useBlackList } from '../hooks/useBlackList'
import { FormBlackList } from '../components/modals/FormBlackList'
import { ModalWhiteList } from '../components/ModalWhiteList'

const columns = [
  { key: 'nombre', name: 'Guardia' },
  { key: 'motivo_baja', name: 'Motivo de baja' }
]

export default function BlackListPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useBlackList()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Lista negra de guardias'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormBlackList />} />
      )}

      {modalType === 'whitelist' && currentItem && (
        <ModalWhiteList handleDelete={handleDelete} />
      )}
    </div>
  )
}
