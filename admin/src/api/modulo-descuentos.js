import { apiClient } from './configAxios'

// Crear un registro
export const createModuloDescuento = async (data) => {
  try {
    const response = await apiClient.post('modulo-descuentos', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getModuloDescuento = async () => {
  try {
    const response = await apiClient.get('modulo-descuentos')
    return response.data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateModuloDescuento = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`modulo-descuentos/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeModuloDescuento = async (id) => {
  try {
    const response = await apiClient.delete(`modulo-descuentos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
