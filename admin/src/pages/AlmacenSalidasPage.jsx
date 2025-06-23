import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { FormAlmacenSalidas } from '../components/modals/FormAlmacenSalidas'
import { useAlmacenSalidas } from '../hooks/useAlmacenSalidas'
import { useModal } from '../hooks/useModal'

const columns = [
  { key: 'articulo', name: 'Artículo' },
  { key: 'numero_serie', name: 'Número de serie' },
  { key: 'fecha_salida_format', name: 'Fecha de salida' },
  { key: 'motivo_salida', name: 'Mótivo de salida' }
]

export default function AlmacenSalidasPage() {
  const { modalType } = useModal()

  const { data, isLoading, isError, error, handleSubmit } = useAlmacenSalidas()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Historial de salidas en almacén'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormAlmacenSalidas />} />
      )}
    </div>
  )
}
