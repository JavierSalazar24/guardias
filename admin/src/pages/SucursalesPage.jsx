import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormSucursales } from '../components/modals/FormSucursales'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'
import { useEstadosMunicipios } from '../hooks/useEstadosMunicipios'
import { useModal } from '../hooks/useModal'
import { useSucursales } from '../hooks/useSucursales'

const columns = [
  { key: 'empresa', name: 'Empresa' },
  { key: 'nombre_empresa', name: 'Sucursal' },
  { key: 'rfc', name: 'RFC' },
  { key: 'razon_social', name: 'Razón social' },
  { key: 'nombre_contacto', name: 'Nombre contacto' },
  { key: 'telefono_contacto', name: 'Teléfono contacto' }
]

export default function SucursalesPage() {
  const {
    modalType,
    add,
    edit,
    closeModal,
    view,
    openModal,
    formData,
    currentItem,
    setFormData,
    handleInputChange,
    handleFileChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useSucursales()

  const { loadOptionsClientes } = useCatalogLoaders()

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
        title='Sucursales de clientes'
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
            <FormSucursales
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              opcionesEstados={opcionesEstados}
              municipios={municipios}
              loadOptionsClientes={loadOptionsClientes}
              handleFileChange={handleFileChange}
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
