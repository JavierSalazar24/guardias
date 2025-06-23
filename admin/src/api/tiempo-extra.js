import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createTiempoExtra = async (data) => {
  try {
    const response = await apiClient.post('tiempo-extra', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getTiempoExtra = async () => {
  try {
    const response = await apiClient.get('tiempo-extra')
    const { data } = response

    return data.map((incapacidad) => {
      const guardia = `${incapacidad.guardia.nombre} ${incapacidad.guardia.apellido_p} ${incapacidad.guardia.apellido_m}`
      const fecha_inicio_format = dayjs(incapacidad.fecha_inicio).format(
        'DD/MM/YYYY'
      )
      const fecha_fin_format = dayjs(incapacidad.fecha_fin).format('DD/MM/YYYY')
      const monto_hora_format = `$${incapacidad.monto_por_hora}`
      const monto_total_format = `$${incapacidad.monto_total}`
      const guardia_id = { label: guardia, value: incapacidad.guardia.id }

      return {
        nombre: guardia,
        guardia_id,
        fecha_inicio_format,
        fecha_fin_format,
        monto_hora_format,
        monto_total_format,
        ...incapacidad
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateTiempoExtra = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`tiempo-extra/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeTiempoExtra = async (id) => {
  try {
    const response = await apiClient.delete(`tiempo-extra/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
