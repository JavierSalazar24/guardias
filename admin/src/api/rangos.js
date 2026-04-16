import { apiClient } from './configAxios'

// Crear un registro
export const createRango = async (data) => {
  try {
    const response = await apiClient.post('rangos', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getRango = async () => {
  try {
    const response = await apiClient.get('rangos')
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateRango = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`rangos/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeRango = async (id) => {
  try {
    const response = await apiClient.delete(`rangos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
