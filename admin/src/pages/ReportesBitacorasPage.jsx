import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useReportesBitacoras } from '../hooks/useReportesBitacoras'
import { FormReportesBitacoras } from '../components/modals/FormReportesBitacoras'
import { ModalDelete } from '../components/ModalDelete'

const columns = [
  { key: 'orden', name: 'Servicio' },
  { key: 'nombre', name: 'Supervisor' },
  { key: 'hora_inicio_format', name: 'Inicio recorrdio' },
  { key: 'hora_fin_format', name: 'Fin recorrido' },
  { key: 'fecha_format', name: 'Fecha recorrido' },
  { key: 'patrulla', name: 'Patrulla' },
  { key: 'zona', name: 'Zona' }
]

export default function ReportesBitacorasPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleDelete } =
    useReportesBitacoras()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Bitácoras de guardias'
        loading={isLoading}
      />

      {modalType === 'view' && <BaseForm Inputs={<FormReportesBitacoras />} />}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
