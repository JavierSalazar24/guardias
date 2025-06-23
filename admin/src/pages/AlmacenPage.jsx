import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormAlmacenEntradas } from '../components/modals/FormAlmacenEntradas'
import { useAlmacen } from '../hooks/useAlmacen'
import { useModal } from '../hooks/useModal'

const columns = [
  { key: 'articulo', name: 'Artículo' },
  { key: 'numero_serie', name: 'Número serie' },
  { key: 'fecha_entrada', name: 'Fecha entrada' },
  { key: 'fecha_salida', name: 'Fecha salida' },
  { key: 'estado', name: 'Estado' }
]

export default function AlmacenPage() {
  const { modalType } = useModal()

  const { data, isLoading, isError, error } = useAlmacen()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Almacén'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && <BaseForm Inputs={<FormAlmacenEntradas />} />}
    </div>
  )
}
