import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createVacacion = async (data) => {
  try {
    const response = await apiClient.post('vacaciones', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getVacacion = async () => {
  try {
    const response = await apiClient.get('vacaciones')
    const { data } = response

    return data.map((vacacion) => {
      const guardia = `${vacacion.guardia.nombre} ${vacacion.guardia.apellido_p} ${vacacion.guardia.apellido_m}`
      const fecha_inicio_format = dayjs(vacacion.fecha_inicio).format(
        'DD/MM/YYYY'
      )
      const fecha_fin_format = dayjs(vacacion.fecha_fin).format('DD/MM/YYYY')
      const prima_vacacional_format = `$${vacacion.prima_vacacional}`
      const guardia_id = { label: guardia, value: vacacion.guardia.id }

      return {
        nombre: guardia,
        guardia_id,
        fecha_inicio_format,
        fecha_fin_format,
        prima_vacacional_format,
        ...vacacion
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateVacacion = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`vacaciones/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeVacacion = async (id) => {
  try {
    const response = await apiClient.delete(`vacaciones/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
