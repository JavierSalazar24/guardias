import { apiClient, apiClientForm } from './configAxios'

// Crear un registro
export const createDocumento = async (data) => {
  try {
    const formData = new FormData()
    formData.append('tipo_documento_id', data.tipo_documento_id)
    formData.append('guardia_id', data.guardia_id)
    formData.append('documento', data.documento)

    const response = await apiClientForm.post('documentos', formData)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getDocumento = async () => {
  try {
    const response = await apiClient.get('documentos')
    const { data } = response

    return data.map((documento) => ({
      ...documento,
      tipo_documento_id: {
        label: documento.tipo_documento.nombre,
        value: documento.tipo_documento.id
      },
      nombre_documento: documento.tipo_documento.nombre,
      guardia_id: {
        label: `${documento.guardia.nombre} ${documento.guardia.apellido_p} ${documento.guardia.apellido_m} (${documento.guardia.numero_empleado})`,
        value: documento.guardia.id
      },
      nombre_guardia: `${documento.guardia.nombre} ${documento.guardia.apellido_p} ${documento.guardia.apellido_m} (${documento.guardia.numero_empleado})`
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateDocumento = async (data) => {
  try {
    const { id } = data

    const formData = new FormData()
    formData.append('_method', 'PUT')
    formData.append('tipo_documento_id', data.tipo_documento_id)
    formData.append('guardia_id', data.guardia_id)
    if (data.documento instanceof File) {
      formData.append('documento', data.documento)
    }

    const response = await apiClientForm.post(`documentos/${id}`, formData)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeDocumento = async (id) => {
  try {
    const response = await apiClient.delete(`documentos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
