import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { FormVentasHistorial } from '../components/modals/FormVentasHistorial'
import { useModal } from '../hooks/useModal'
import { useVentasHistorial } from '../hooks/useVentasHistorial'

const columns = [
  { key: 'nombre', name: 'Admin que modifico' },
  { key: 'venta_id', name: 'ID venta' },
  { key: 'cotizacion', name: 'ID cotización' },
  { key: 'numero_factura', name: 'Número factura' },
  { key: 'total_format', name: 'Total' },
  { key: 'fecha_modificacion', name: 'Fecha modificación' },
  { key: 'accion', name: 'Acción' }
]

export default function VentasHistorialPage() {
  const { modalType } = useModal()

  const { data, isLoading, isError, error } = useVentasHistorial()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Historial de ventas'
        loading={isLoading}
      />

      {modalType === 'view' && <BaseForm Inputs={<FormVentasHistorial />} />}
    </div>
  )
}
