import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useReportesPatrullas } from '../hooks/useReportesPatrullas'
import { FormReportesPatrullas } from '../components/modals/FormReportesPatrullas'
import { ModalDelete } from '../components/ModalDelete'

const columns = [
  { key: 'orden', name: 'Servicio' },
  { key: 'nombre', name: 'Supervisor' },
  { key: 'licencia_manejo', name: 'Licencia manejo' },
  { key: 'tarjeta_combustible', name: 'Tarjeta combustible' },
  { key: 'fecha_format', name: 'Fecha reporte' }
]

export default function ReportesPatrullasPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleDelete } =
    useReportesPatrullas()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Reportes de patrullas'
        loading={isLoading}
      />

      {modalType === 'view' && <BaseForm Inputs={<FormReportesPatrullas />} />}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
