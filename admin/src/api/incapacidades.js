import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createIncapacidad = async (data) => {
  try {
    const response = await apiClient.post('incapacidades', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getIncapacidad = async () => {
  try {
    const response = await apiClient.get('incapacidades')
    const { data } = response

    return data.map((incapacidad) => {
      const guardia = `${incapacidad.guardia.nombre} ${incapacidad.guardia.apellido_p} ${incapacidad.guardia.apellido_m}`
      const fecha_inicio_format = dayjs(incapacidad.fecha_inicio).format(
        'DD/MM/YYYY'
      )
      const fecha_fin_format = dayjs(incapacidad.fecha_fin).format('DD/MM/YYYY')
      const pago_empresa_format = `$${incapacidad.pago_empresa}`
      const guardia_id = { label: guardia, value: incapacidad.guardia.id }

      return {
        nombre: guardia,
        guardia_id,
        fecha_inicio_format,
        fecha_fin_format,
        pago_empresa_format,
        ...incapacidad
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateIncapacidad = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`incapacidades/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeIncapacidad = async (id) => {
  try {
    const response = await apiClient.delete(`incapacidades/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
