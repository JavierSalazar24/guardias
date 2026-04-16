import { apiClient } from './configAxios'

// Crear un registro
export const createTipoServicio = async (data) => {
  try {
    const response = await apiClient.post('tipos-servicios', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getTipoServicio = async () => {
  try {
    const response = await apiClient.get('tipos-servicios')
    return response.data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateTipoServicio = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`tipos-servicios/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeTipoServicio = async (id) => {
  try {
    const response = await apiClient.delete(`tipos-servicios/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
