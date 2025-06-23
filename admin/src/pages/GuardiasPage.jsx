import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useGuardias } from '../hooks/useGuardias'
import { FormGuardias } from '../components/modals/FormGuardias'
import { ModalBlackList } from '../components/ModalBlackList'

const columns = [
  { key: 'nombre_completo', name: 'Nombre' },
  { key: 'nombre_sucursal', name: 'Sucursal dado de alta' },
  { key: 'numero_empleado', name: 'Número de empleado' },
  { key: 'rango', name: 'Rango' },
  { key: 'estatus', name: 'Estatus' }
]

export default function GuardiasPage() {
  const { modalType, currentItem } = useModal()

  const {
    data,
    isLoading,
    isError,
    error,
    handleSubmit,
    handleDelete,
    handleBlackList
  } = useGuardias()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Guardias'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormGuardias />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}

      {modalType === 'blacklist' && currentItem && (
        <ModalBlackList handleBlackList={handleBlackList} />
      )}
    </div>
  )
}
