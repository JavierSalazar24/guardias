import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormOrdenesServicios } from '../components/modals/FormOrdenesServicios'
import { useModal } from '../hooks/useModal'
import { useOrdenesServicio } from '../hooks/useOrdenesServicio'

const columns = [
  { key: 'codigo_orden_servicio', name: 'Código' },
  { key: 'nombre_empresa', name: 'Sucursal' },
  { key: 'domicilio_servicio', name: 'Domicilio' },
  { key: 'inicio_format', name: 'Fecha inicio' },
  { key: 'asignados', name: 'Guardias' },
  { key: 'estatus', name: 'Estatus' }
]

export default function OrdenesServiciosPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useOrdenesServicio()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Ordenes de servicio'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          Inputs={<FormOrdenesServicios />}
        />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
