import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useReportesSupervisor } from '../hooks/useReportesSupervisor'
import { FormReporteSupervisor } from '../components/modals/FormReporteSupervisor'
import { ModalDelete } from '../components/ModalDelete'

const columns = [
  { key: 'orden', name: 'Orden de servicio' },
  { key: 'nombre', name: 'Supervisor' },
  { key: 'zona', name: 'Zona' },
  { key: 'turno', name: 'Turno' },
  { key: 'tipo', name: 'Tipo de reporte' },
  { key: 'fecha_format', name: 'Fecha' }
]

export default function ReporteSupervisoresPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleDelete } =
    useReportesSupervisor()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Reporte de supervisores'
        loading={isLoading}
      />

      {modalType === 'view' && <BaseForm Inputs={<FormReporteSupervisor />} />}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
