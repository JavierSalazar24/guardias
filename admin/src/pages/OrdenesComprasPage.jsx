import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormOrdenesCompra } from '../components/modals/FormOrdenesCompra'
import { useModal } from '../hooks/useModal'
import { useOrdenesCompra } from '../hooks/useOrdenesCompra'

const columns = [
  { key: 'banco', name: 'Banco' },
  { key: 'proveedor', name: 'Proveedor' },
  { key: 'numero_oc', name: '# OC' },
  { key: 'articulo', name: 'Artículo' },
  { key: 'total_format', name: 'Total' },
  { key: 'fecha', name: 'Fecha' },
  { key: 'estatus', name: 'Estatus' }
]

export default function OrdenesComprasPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useOrdenesCompra()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Ordenes de compra'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormOrdenesCompra />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
