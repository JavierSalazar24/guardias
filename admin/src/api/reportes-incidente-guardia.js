import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getReporteIncidenteGuardia = async () => {
  try {
    const response = await apiClient.get('reporte-incidente-guardia')
    const { data } = response
    return data.map((check) => {
      const guardia = `${check.guardia.nombre} ${check.guardia.apellido_p} (${check.guardia.numero_empleado})`

      return {
        ...check,
        nombre: guardia,
        orden: check.orden_servicio.codigo_orden_servicio,
        fecha_format: dayjs(check.fecha).format('DD/MM/YYYY hh:mm:ss A')
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateReporteIncidenteGuardia = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(
      `reporte-incidente-guardia/${id}`,
      data
    )
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeReporteIncidenteGuardia = async (id) => {
  try {
    const response = await apiClient.delete(`reporte-incidente-guardia/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
