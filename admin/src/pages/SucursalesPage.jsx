import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormSucursales } from '../components/modals/FormSucursales'
import { useModal } from '../hooks/useModal'
import { useSucursales } from '../hooks/useSucursales'

const columns = [
  { key: 'empresa', name: 'Empresa' },
  { key: 'nombre_empresa', name: 'Sucursal' },
  { key: 'rfc', name: 'RFC' },
  { key: 'razon_social', name: 'Razón social' },
  { key: 'nombre_contacto', name: 'Nombre contacto' },
  { key: 'telefono_contacto', name: 'Teléfono contacto' }
]

export default function SucursalesPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useSucursales()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Sucursales de clientes'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormSucursales />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
