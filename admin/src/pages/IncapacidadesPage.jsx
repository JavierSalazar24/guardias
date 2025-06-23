import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useIncapacidades } from '../hooks/useIncapacidades'
import { FormIncapacidades } from '../components/modals/FormIncapacidades'

const columns = [
  { key: 'nombre', name: 'Guardia' },
  { key: 'fecha_inicio_format', name: 'Inicio de incapacidad' },
  { key: 'fecha_fin_format', name: 'Fin de incapacidad' },
  { key: 'pago_empresa_format', name: 'Pago por parte de la empresa' },
  { key: 'motivo', name: 'Motivo de incapacidad' }
]

export default function IncapacidadesPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useIncapacidades()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Incapacidades'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm handleSubmit={handleSubmit} Inputs={<FormIncapacidades />} />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
