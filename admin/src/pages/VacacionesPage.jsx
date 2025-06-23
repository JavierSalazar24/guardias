import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useVacaciones } from '../hooks/useVacaciones'
import { FormVacaciones } from '../components/modals/FormVacaciones'

const columns = [
  { key: 'nombre', name: 'Guardia' },
  { key: 'fecha_inicio_format', name: 'Inicio de vacaciones' },
  { key: 'fecha_fin_format', name: 'Fin de vacaciones' },
  { key: 'dias_totales', name: 'Días totales de vacaciones' },
  { key: 'prima_vacacional_format', name: 'Prima vacacional' }
]

export default function VacacionesPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useVacaciones()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Vacaciones'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormVacaciones />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
