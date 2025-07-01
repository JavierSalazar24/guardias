import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormSucursalesEmpresa } from '../components/modals/FormSucursalesEmpresa'
import { useEstadosMunicipios } from '../hooks/useEstadosMunicipios'
import { useModal } from '../hooks/useModal'
import { useSucursalesEmpresa } from '../hooks/useSucursalesEmpresa'

const columns = [
  { key: 'nombre_sucursal', name: 'Sucursal' },
  { key: 'direccion', name: 'Dirección' },
  { key: 'telefono_sucursal', name: 'Teléfono' },
  { key: 'nombre_contacto', name: 'Nombre contacto' }
]

export default function SucursalesEmpresaPage() {
  const {
    modalType,
    add,
    closeModal,
    view,
    formData,
    openModal,
    currentItem,
    setFormData,
    handleInputChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useSucursalesEmpresa()

  const { municipios, opcionesEstados } = useEstadosMunicipios({
    estadoSeleccionado: formData.estado,
    setFormData,
    add
  })

  if (isError) return <div>{error.message}</div>

  return (
    <div className='md:p-4 bg-gray-100'>
      <BaseTable
        columns={columns}
        data={data || []}
        title='Sucursales de la empresa'
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
            <FormSucursalesEmpresa
              view={view}
              formData={formData}
              handleInputChange={handleInputChange}
              opcionesEstados={opcionesEstados}
              municipios={municipios}
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
