import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useLogs } from '../hooks/useLogs'
import { FormLogs } from '../components/modals/FormLogs'

const columns = [
  { key: 'modulo_id', name: 'ID Módulo' },
  { key: 'modulo', name: 'Módulo que cambió' },
  { key: 'accion', name: 'Acción' },
  { key: 'nombre_usuario', name: 'Usuario' },
  { key: 'fecha_cambio', name: 'Fecha de cambio' },
  { key: 'ip', name: 'IP' }
]

export default function LogsPage() {
  const { modalType } = useModal()

  const { data, isLoading, isError, error } = useLogs()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Movimientos del sistema'
        loading={isLoading}
      />

      {modalType === 'view' && <BaseForm Inputs={<FormLogs />} />}
    </div>
  )
}
