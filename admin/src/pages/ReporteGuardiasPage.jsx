import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useReportesGuardia } from '../hooks/useReportesGuardia'
import { FormReporteGuardia } from '../components/modals/FormReporteGuardia'
import { ModalDelete } from '../components/ModalDelete'

const columns = [
  { key: 'orden', name: 'Orden de servicio' },
  { key: 'nombre', name: 'Guardia' },
  { key: 'punto_vigilancia', name: 'Punto de vigilancia' },
  { key: 'turno', name: 'Turno' },
  { key: 'fecha_format', name: 'Fecha' }
]

export default function ReporteGuardiasPage() {
  const {
    modalType,
    add,
    closeModal,
    view,
    openModal,
    formData,
    currentItem,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleDelete } = useReportesGuardia()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Reporte de guardias'
        loading={isLoading}
        openModal={openModal}
      />

      {modalType === 'view' && (
        <BaseForm
          view={view}
          add={add}
          closeModal={closeModal}
          Inputs={
            <FormReporteGuardia
              view={view}
              formData={formData}
              handleInputChange={handleInputChange}
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
