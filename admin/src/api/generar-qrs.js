import { apiClient } from './configAxios'

// Crear un registro
export const createGenerarQR = async (data) => {
  try {
    const response = await apiClient.post('generar-qr', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getGenerarQR = async () => {
  try {
    const response = await apiClient.get('generar-qr')
    const { data } = response

    return data.map((generador) => ({
      ...generador,
      orden: generador.orden_servicio.codigo_orden_servicio,
      notas_format: generador.notas ? generador.notas : 'Sin notas'
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateGenerarQR = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`generar-qr/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeGenerarQR = async (id) => {
  try {
    const response = await apiClient.delete(`generar-qr/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
