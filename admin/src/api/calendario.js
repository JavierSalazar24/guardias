import { apiClient } from './configAxios'

// Crear un registro
export const createCalendario = async (data) => {
  try {
    const response = await apiClient.post('calendario', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getCalendario = async () => {
  try {
    const response = await apiClient.get('calendario')
    const { data } = response

    return data.map((calendario) => ({
      ...calendario,
      invitado_id: {
        label: calendario.nombre_invitado,
        value: calendario.invitado_id
      }
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateCalendario = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`calendario/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeCalendario = async (id) => {
  try {
    const response = await apiClient.delete(`calendario/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
