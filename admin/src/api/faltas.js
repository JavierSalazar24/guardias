import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createFalta = async (data) => {
  try {
    const response = await apiClient.post('faltas', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getFalta = async () => {
  try {
    const response = await apiClient.get('faltas')
    const { data } = response

    return data.map((faltas) => {
      const guardia = `${faltas.guardia.nombre} ${faltas.guardia.apellido_p} ${faltas.guardia.apellido_m}`
      const fecha_inicio_format = dayjs(faltas.fecha_inicio).format(
        'DD/MM/YYYY'
      )
      const fecha_fin_format = dayjs(faltas.fecha_fin).format('DD/MM/YYYY')
      const monto_format = `$${faltas.monto}`
      const guardia_id = { label: guardia, value: faltas.guardia.id }

      return {
        nombre: guardia,
        guardia_id,
        fecha_inicio_format,
        fecha_fin_format,
        monto_format,
        ...faltas
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateFalta = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`faltas/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeFalta = async (id) => {
  try {
    const response = await apiClient.delete(`faltas/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
