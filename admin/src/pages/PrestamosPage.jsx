import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { usePrestamos } from '../hooks/usePrestamos'
import { FormPrestamos } from '../components/modals/FormPrestamos'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre', name: 'Guardia' },
  { key: 'monto_total_format', name: 'Monto prestado' },
  { key: 'saldo_restante_format', name: 'Saldo restante' },
  { key: 'fecha_prestamo_format', name: 'Fecha del préstamo' },
  { key: 'cuotas', name: 'Abonos pagados' },
  { key: 'fecha_pagado_format', name: 'Fecha prestamo liquidado' },
  { key: 'estatus', name: 'Estatus' }
]

export default function PrestamosPage() {
  const {
    modalType,
    add,
    closeModal,
    view,
    document,
    openModal,
    formData,
    currentItem,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    usePrestamos()

  const {
    loadOptionsTodosGuardias,
    loadOptionsModuloPrestamo,
    loadOptionsBancos
  } = useCatalogLoaders()

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Préstamos'
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
            <FormPrestamos
              view={view}
              document={document}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsTodosGuardias={loadOptionsTodosGuardias}
              loadOptionsModuloPrestamo={loadOptionsModuloPrestamo}
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
