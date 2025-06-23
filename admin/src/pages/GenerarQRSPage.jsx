import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useGenerarQRS } from '../hooks/useGenerarQRS'
import { FormGenerarQRS } from '../components/modals/FormGenerarQRS'

const columns = [
  { key: 'orden', name: 'Orden de servicio' },
  { key: 'cantidad', name: 'Cantidad de QRs generados' },
  { key: 'notas_format', name: 'Notas' }
]

export default function GenerarQRSPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useGenerarQRS()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Generar códigos QR'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormGenerarQRS />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
