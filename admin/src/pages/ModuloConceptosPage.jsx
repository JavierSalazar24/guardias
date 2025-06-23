import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { FormModuloConceptos } from '../components/modals/FormModuloConceptos'
import { useModuloConcepto } from '../hooks/useModuloConcepto'

const columns = [
  { key: 'nombre', name: 'Nombre' },
  { key: 'descripcion', name: 'Descripción' }
]

export default function ModuloConceptosPage() {
  const { modalType, currentItem } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useModuloConcepto()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Módulo para agregar tipos de conceptos'
        loading={isLoading}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          Inputs={<FormModuloConceptos />}
        />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete handleDelete={handleDelete} />
      )}
    </div>
  )
}
