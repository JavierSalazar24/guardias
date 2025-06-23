import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormSucursalesEmpresa } from '../components/modals/FormSucursalesEmpresa'
import { useModal } from '../hooks/useModal'
import { useSucursalesEmpresa } from '../hooks/useSucursalesEmpresa'

const columns = [
  { key: 'nombre_sucursal', name: 'Sucursal' },
  { key: 'direccion', name: 'Dirección' },
  { key: 'telefono_sucursal', name: 'Teléfono' },
  { key: 'nombre_contacto', name: 'Nombre contacto' }
]

export default function SucursalesEmpresaPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useSucursalesEmpresa()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Sucursales PROEJE'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          Inputs={<FormSucursalesEmpresa />}
        />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
