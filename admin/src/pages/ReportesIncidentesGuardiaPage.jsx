import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useReportesInicidenteGuardia } from '../hooks/useReportesInicidenteGuardia'
import { FormReportesIncidentesGuardia } from '../components/modals/FormReportesIncidentesGuardia'
import { ModalDelete } from '../components/ModalDelete'

const columns = [
  { key: 'orden', name: 'Orden servicio' },
  { key: 'nombre', name: 'Guardia' },
  { key: 'incidente', name: 'Incidente' },
  { key: 'causa', name: 'Causa' },
  { key: 'turno', name: 'Turno' },
  { key: 'estado', name: 'Estado de incidente' },
  { key: 'fecha_format', name: 'Fecha' }
]

export default function ReportesIncidentesGuardiaPage() {
  const {
    modalType,
    add,
    closeModal,
    view,
    openModal,
    edit,
    formData,
    currentItem,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useReportesInicidenteGuardia()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Reporte de incidentes de guardias'
        loading={isLoading}
        openModal={openModal}
      />

      {(modalType === 'view' || modalType === 'edit') && (
        <BaseForm
          handleSubmit={handleSubmit}
          view={view}
          add={add}
          closeModal={closeModal}
          Inputs={
            <FormReportesIncidentesGuardia
              view={view}
              edit={edit}
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
