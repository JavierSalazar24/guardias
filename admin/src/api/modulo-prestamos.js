import { apiClient } from './configAxios'

// Crear un registro
export const createModuloPrestamo = async (data) => {
  try {
    const response = await apiClient.post('modulo-prestamos', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getModuloPrestamo = async () => {
  try {
    const response = await apiClient.get('modulo-prestamos')
    return response.data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateModuloPrestamo = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`modulo-prestamos/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeModuloPrestamo = async (id) => {
  try {
    const response = await apiClient.delete(`modulo-prestamos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
