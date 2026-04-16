import { apiClient } from './configAxios'

// Crear un registro
export const createMotivoActa = async (data) => {
  try {
    const response = await apiClient.post('motivos-actas', data)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getMotivoActa = async () => {
  try {
    const response = await apiClient.get('motivos-actas')
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateMotivoActa = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`motivos-actas/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeMotivoActa = async (id) => {
  try {
    const response = await apiClient.delete(`motivos-actas/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
