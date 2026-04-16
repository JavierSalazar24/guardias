import { apiClient } from './configAxios'

// Crear un registro
export const createTaller = async (data) => {
  try {
    const response = await apiClient.post('talleres', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getTaller = async () => {
  try {
    const response = await apiClient.get('talleres')
    return response.data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateTaller = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`talleres/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeTaller = async (id) => {
  try {
    const response = await apiClient.delete(`talleres/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
