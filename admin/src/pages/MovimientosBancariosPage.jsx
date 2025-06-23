import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useMovimientosBancarios } from '../hooks/useMovimientosBancarios'
import { FormMovimientosBancarios } from '../components/modals/FormMovimientosBancarios'

const columns = [
  { key: 'banco', name: 'Banco' },
  { key: 'tipo_movimiento', name: 'Tipo movimiento' },
  { key: 'metodo_pago', name: 'Método pago' },
  { key: 'concepto', name: 'Concepto' },
  { key: 'referencia', name: 'Referencia' },
  { key: 'monto_format', name: 'Monto' },
  { key: 'fecha_format', name: 'Fecha movimiento' },
  { key: 'modulo', name: 'Módulo' }
]

export default function MovimientosBancariosPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useMovimientosBancarios()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Movimientos bancarios'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          Inputs={<FormMovimientosBancarios />}
        />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
