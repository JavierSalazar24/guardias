import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalCancel } from '../components/ModalCancel'
import { ModalDelete } from '../components/ModalDelete'
import { FormVentas } from '../components/modals/FormVentas'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'
import { useModal } from '../hooks/useModal'
import { useVentas } from '../hooks/useVentas'

const columns = [
  { key: 'sucursal', name: 'Sucursal' },
  { key: 'numero_factura', name: 'Número factura' },
  { key: 'fecha_vencimiento_format', name: 'Limite de pago' },
  { key: 'tipo_pago', name: 'Tipo pago' },
  { key: 'subtotal', name: 'subtotal' },
  { key: 'nota_credito_format', name: 'Monto nota crédito' },
  { key: 'total_format', name: 'Total' },
  { key: 'estatus', name: 'Estatus' }
]

export default function VentasPage() {
  const {
    modalType,
    add,
    closeModal,
    openModal,
    view,
    edit,
    formData,
    currentItem,
    handleInputChange
  } = useModal()

  const {
    data,
    isLoading,
    isError,
    error,
    handleSubmit,
    handleDelete,
    handleCancel
  } = useVentas()

  const { loadOptionsCotizaciones, loadOptionsBancos } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Ventas'
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
            <FormVentas
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsCotizaciones={loadOptionsCotizaciones}
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

      {modalType === 'cancelar' && currentItem && (
        <ModalCancel
          handleCancel={handleCancel}
          closeModal={closeModal}
          formData={formData}
          handleInputChange={handleInputChange}
        />
      )}
    </div>
  )
}
