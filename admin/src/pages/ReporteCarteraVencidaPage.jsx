import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { FormReporteCarteraVencida } from '../components/modals/FormReporteCarteraVencida'
import { useModal } from '../hooks/useModal'
import { useReporteCarteraVencida } from '../hooks/useReporteCarteraVencida'

const columns = [
  { key: 'cliente', name: 'Cliente' },
  { key: 'sucursal', name: 'Sucursal' },
  { key: 'numero_factura', name: 'Número Factura' },
  { key: 'fecha_vencimiento_format', name: 'Fecha vencimiento' },
  { key: 'total_format', name: 'Total' },
  { key: 'atraso', name: 'Días de atraso' },
  { key: 'estatus', name: 'Estatus' }
]

export default function ReporteCarteraVencidaPage() {
  const { modalType } = useModal()

  const { data, isLoading, isError, error } = useReporteCarteraVencida()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Reporte de cartera vencida (de 1 a 3 meses)'
        loading={isLoading}
      />

      {modalType === 'view' && (
        <BaseForm Inputs={<FormReporteCarteraVencida />} />
      )}
    </div>
  )
}
