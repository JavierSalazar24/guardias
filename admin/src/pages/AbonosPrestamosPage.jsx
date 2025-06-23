import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useAbonosPrestamo } from '../hooks/useAbonosPrestamo'
import { FormAbonosPrestamo } from '../components/modals/FormAbonosPrestamo'

const columns = [
  { key: 'prestamo', name: 'Préstamo' },
  { key: 'monto_format', name: 'Monto prestado' },
  { key: 'fecha_format', name: 'Fecha del pago' },
  { key: 'metodo_pago', name: 'Método del pago' }
]

export default function AbonosPrestamosPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useAbonosPrestamo()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Abonos de los préstamos'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormAbonosPrestamo />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
