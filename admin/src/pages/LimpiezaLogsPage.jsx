import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { useModal } from '../hooks/useModal'
import { useLimpiezaLogs } from '../hooks/useLimpiezaLogs'
import { FormLimpiezaLogs } from '../components/modals/FormLimpiezaLogs'

const columns = [
  { key: 'tabla_format', name: 'Tabla' },
  { key: 'fecha_ejecucion_format', name: 'Fecha de ejecución' },
  { key: 'registros_eliminados', name: 'Cantidad registros eliminados' },
  { key: 'archivos_eliminados', name: 'Cantidad archivos eliminados' }
]

export default function LimpiezaLogsPage() {
  const {
    modalType,
    view,
    formData,
    openModal,
    add,
    closeModal,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error } = useLimpiezaLogs()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Registros limpiados que fueron programados'
        loading={isLoading}
        openModal={openModal}
      />

      {modalType === 'view' && (
        <BaseForm
          view={view}
          add={add}
          closeModal={closeModal}
          Inputs={
            <FormLimpiezaLogs
              view={view}
              formData={formData}
              handleInputChange={handleInputChange}
            />
          }
        />
      )}
    </div>
  )
}
