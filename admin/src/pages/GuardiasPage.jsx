import { BaseForm } from '../components/BaseForm'
import { BaseTable } from '../components/BaseTable'
import { ModalDelete } from '../components/ModalDelete'
import { useModal } from '../hooks/useModal'
import { useGuardias } from '../hooks/useGuardias'
import { FormGuardias } from '../components/modals/FormGuardias'
import { ModalBlackList } from '../components/ModalBlackList'
import { useEstadosMunicipios } from '../hooks/useEstadosMunicipios'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'

const columns = [
  { key: 'nombre_completo', name: 'Nombre' },
  { key: 'nombre_sucursal', name: 'Sucursal dado de alta' },
  { key: 'numero_empleado', name: 'Número de empleado' },
  { key: 'rango', name: 'Rango' },
  { key: 'estatus', name: 'Estatus' }
]

export default function GuardiasPage() {
  const {
    modalType,
    closeModal,
    view,
    add,
    openModal,
    document,
    formData,
    currentItem,
    setFormData,
    handleInputChange,
    handleFileChange
  } = useModal()

  const {
    data,
    isLoading,
    isError,
    error,
    handleSubmit,
    handleDelete,
    handleBlackList,
    handleCheckBlackList
  } = useGuardias()

  const { loadOptionsSucursalesEmpresa } = useCatalogLoaders()

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
        title='Guardias'
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
            <FormGuardias
              view={view}
              add={add}
              document={document}
              formData={formData}
              handleInputChange={handleInputChange}
              handleFileChange={handleFileChange}
              loadOptionsSucursalesEmpresa={loadOptionsSucursalesEmpresa}
              opcionesEstados={opcionesEstados}
              municipios={municipios}
              handleCheckBlackList={handleCheckBlackList}
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

      {modalType === 'blacklist' && currentItem && (
        <ModalBlackList
          handleBlackList={handleBlackList}
          closeModal={closeModal}
          formData={formData}
          handleInputChange={handleInputChange}
        />
      )}
    </div>
  )
}
