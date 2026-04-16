import { apiClient } from './configAxios'

// Crear un registro
export const createTipoDocumento = async (data) => {
  try {
    const response = await apiClient.post('tipos-documentos', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getTipoDocumento = async () => {
  try {
    const response = await apiClient.get('tipos-documentos')
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateTipoDocumento = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`tipos-documentos/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeTipoDocumento = async (id) => {
  try {
    const response = await apiClient.delete(`tipos-documentos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
