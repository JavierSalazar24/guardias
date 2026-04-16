import { apiClient } from './configAxios'

// Crear un registro
export const createModuloConcepto = async (data) => {
  try {
    const response = await apiClient.post('modulo-conceptos', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getModuloConcepto = async () => {
  try {
    const response = await apiClient.get('modulo-conceptos')
    return response.data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateModuloConcepto = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`modulo-conceptos/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeModuloConcepto = async (id) => {
  try {
    const response = await apiClient.delete(`modulo-conceptos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
