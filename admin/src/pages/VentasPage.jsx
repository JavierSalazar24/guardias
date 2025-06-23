import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalCancel } from '../components/ModalCancel'
import { ModalDelete } from '../components/ModalDelete'
import { FormVentas } from '../components/modals/FormVentas'
import { useModal } from '../hooks/useModal'
import { useVentas } from '../hooks/useVentas'

const columns = [
  { key: 'sucursal', name: 'Sucursal' },
  { key: 'numero_factura', name: 'Número factura' },
  { key: 'credito_dias', name: 'Días de crédito' },
  { key: 'fecha_vencimiento_format', name: 'Limite de pago' },
  { key: 'tipo_pago', name: 'Tipo pago' },
  { key: 'total', name: 'Total' },
  { key: 'estatus', name: 'Estatus' }
]

export default function VentasPage() {
  const { modalType, currentItem } = useModal()

  const {
    data,
    isLoading,
    isError,
    error,
    handleSubmit,
    handleDelete,
    handleCancel
  } = useVentas()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Ventas'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormVentas />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}

      {modalType === 'cancelar' && currentItem && (
        <ModalCancel handleCancel={handleCancel} />
      )}
    </div>
  )
}
