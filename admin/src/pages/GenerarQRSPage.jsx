import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useGenerarQRS } from '../hooks/useGenerarQRS'
import { FormGenerarQRS } from '../components/modals/FormGenerarQRS'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'orden', name: 'Orden de servicio' },
  { key: 'cantidad', name: 'Cantidad de QRs generados' },
  { key: 'notas_format', name: 'Notas' }
]

export default function GenerarQRSPage() {
  const {
    modalType,
    closeModal,
    view,
    openModal,
    add,
    document,
    formData,
    currentItem,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useGenerarQRS()

  const { loadOptionsOrdenServicio } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Generar códigos QR'
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
            <FormGenerarQRS
              view={view}
              add={add}
              document={document}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsOrdenServicio={loadOptionsOrdenServicio}
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
