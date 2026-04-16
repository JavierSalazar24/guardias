import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useAbonosPrestamo } from '../hooks/useAbonosPrestamo'
import { FormAbonosPrestamo } from '../components/modals/FormAbonosPrestamo'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'prestamo', name: 'Préstamo' },
  { key: 'monto_format', name: 'Monto abonado' },
  { key: 'fecha_format', name: 'Fecha del pago' },
  { key: 'metodo_pago', name: 'Método del pago' }
]

export default function AbonosPrestamosPage() {
  const {
    add,
    view,
    document,
    formData,
    modalType,
    currentItem,
    closeModal,
    openModal,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useAbonosPrestamo()

  const { loadOptionsPrestamos, loadOptionsBancos } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Abonos de los préstamos'
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
            <FormAbonosPrestamo
              view={view}
              document={document}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsPrestamos={loadOptionsPrestamos}
              loadOptionsBancos={loadOptionsBancos}
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
