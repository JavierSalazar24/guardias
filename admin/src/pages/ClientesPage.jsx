import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { FormClientes } from '../components/modals/FormClientes'
import { useClientes } from '../hooks/useClientes'
import { useEstadosMunicipios } from '../hooks/useEstadosMunicipios'
import { useModal } from '../hooks/useModal'

const columns = [
  { key: 'nombre_empresa', name: 'Nombre empresa' },
  { key: 'rfc', name: 'RFC' },
  { key: 'razon_social', name: 'Razón social' },
  { key: 'nombre_contacto', name: 'Nombre contacto' },
  { key: 'telefono_contacto', name: 'Teléfono contacto' }
]

export default function ClientesPage() {
  const {
    modalType,
    add,
    edit,
    closeModal,
    formData,
    currentItem,
    openModal,
    view,
    setFormData,
    handleInputChange,
    handleFileChange
  } = useModal()

  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useClientes()

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
        title='Clientes'
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
            <FormClientes
              view={view}
              edit={edit}
              formData={formData}
              handleInputChange={handleInputChange}
              opcionesEstados={opcionesEstados}
              municipios={municipios}
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
