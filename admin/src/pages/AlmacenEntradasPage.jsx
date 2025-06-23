import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { FormAlmacenEntradas } from '../components/modals/FormAlmacenEntradas'
import { useAlmacenEntrada } from '../hooks/useAlmacenEntrada'
import { useModal } from '../hooks/useModal'

const columns = [
  { key: 'articulo', name: 'Artículo' },
  { key: 'numero_serie', name: 'Número de serie' },
  { key: 'fecha_entrada_format', name: 'Fecha de entrada' },
  { key: 'tipo_entrada', name: 'Tipo de entrada' }
]

export default function AlmacenEntradasPage() {
  const { modalType } = useModal()

  const { data, isLoading, isError, error, handleSubmit } = useAlmacenEntrada()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Historial de entradas en almacén'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          Inputs={<FormAlmacenEntradas />}
        />
      )}
    </div>
  )
}
