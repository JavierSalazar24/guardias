import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useDescuentos } from '../hooks/useDescuentos'
import { FormDescuentos } from '../components/modals/FormDescuentos'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre', name: 'Guardia' },
  { key: 'tipo_descuento', name: 'Tipo de descuento' },
  { key: 'monto_format', name: 'Monto del descuento' },
  { key: 'observaciones_format', name: 'Observaciones' },
  { key: 'fecha_descuento_format', name: 'Fecha del descuento' }
]

export default function DescuentosPage() {
  const {
    modalType,
    add,
    closeModal,
    formData,
    openModal,
    currentItem,
    view,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useDescuentos()

  const { loadOptionsTodosGuardias, loadOptionsModuloDescuento } =
    useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Descuentos'
        loading={isLoading}
        openModal={openModal}
      />

      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          view={view}
          add={add}
          closeModal={closeModal}
          Inputs={
            <FormDescuentos
              view={view}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsTodosGuardias={loadOptionsTodosGuardias}
              loadOptionsModuloDescuento={loadOptionsModuloDescuento}
            />
          }
        />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete
          handleDelete={handleDelete}
          closeModal={closeModal}
          formData={formData}
        />
      )}
    </div>
  )
}
