import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormClientes } from '../components/modals/FormClientes'
import { useClientes } from '../hooks/useClientes'
import { useModal } from '../hooks/useModal'

const columns = [
  { key: 'nombre_empresa', name: 'Nombre empresa' },
  { key: 'rfc', name: 'RFC' },
  { key: 'razon_social', name: 'Razón social' },
  { key: 'nombre_contacto_admin', name: 'Nombre admin' },
  { key: 'telefono_contacto_admin', name: 'Teléfono admin' }
]

export default function ClientesPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useClientes()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Clientes'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormClientes />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
