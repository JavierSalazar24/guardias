import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useCotizaciones } from '../hooks/useCotizaciones'
import { FormCotizaciones } from '../components/modals/FormCotizaciones'

const columns = [
  { key: 'nombre_empresa', name: 'Nombre empresa' },
  { key: 'cantidad_guardias', name: 'Guardias totales' },
  { key: 'jefe_turno', name: 'Jefe de turno' },
  { key: 'supervisor', name: 'Supervisor' },
  { key: 'total_servicio', name: 'Total servicio' },
  { key: 'fecha_servicio_format', name: 'Fecha servicio' },
  { key: 'aceptada', name: 'Acpetada' }
]

export default function CotizacionesPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useCotizaciones()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Cotizaciones'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormCotizaciones />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
