import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useCheckGuardias } from '../hooks/useCheckGuardias'
import { FormCheckGuardias } from '../components/modals/FormCheckGuardias'
import { ModalDelete } from '../components/ModalDelete'
import { useReportes } from '../hooks/useReportes'
import dayjs from 'dayjs'
import { toast } from 'sonner'
import { FormHorasTrabajadasGuardia } from '../components/modals/FormHorasTrabajadasGuardia'
import { AlertaCard } from '../components/AlertaCard'

const columns = [
  { key: 'orden', name: 'Orden servicio' },
  { key: 'tipo_guardia', name: 'Tipo guardia' },
  { key: 'nombre', name: 'Guardia' },
  { key: 'fecha_entrada_format', name: 'Fecha entrada' },
  { key: 'fecha_salida_format', name: 'Fecha salida' },
  { key: 'tiempo_trabajado', name: 'Tiempo trabajado' }
]

export default function CheckGuardiasPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleDelete } = useCheckGuardias()
  const {
    formReport,
    estado,
    generateHorasTrabajadasGuardia,
    handleInputChange,
    loadOptionsGuardias
  } = useReportes()

  if (isError) return <div>{error.message}</div>

  const handleGeneretReport = (e) => {
    e.preventDefault()

    if (dayjs(formReport.fecha_inicio).isAfter(dayjs(formReport.fecha_fin))) {
      toast.warning('La fecha de fin no puede ser antes que la fecha de inicio')
      return
    }

    const newData = {
      ...formReport,
      guardia_id: formReport.guardia_id.value
    }
    generateHorasTrabajadasGuardia(newData)
  }

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Entrada y salida de guardias'
        loading={isLoading}
      />

      {modalType === 'view' && <BaseForm Inputs={<FormCheckGuardias />} />}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}

      <div className='mt-6 bg-white p-4 rounded-xl mx-auto'>
        <AlertaCard text='Total de horas trabajadas' />

        <FormHorasTrabajadasGuardia
          estado={estado}
          handleSubmit={handleGeneretReport}
          handleInputChange={handleInputChange}
          loadOptionsGuardias={loadOptionsGuardias}
          formReport={formReport}
        />
      </div>
    </div>
  )
}
