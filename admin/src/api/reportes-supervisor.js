import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getReporteSupervisor = async () => {
  try {
    const response = await apiClient.get('reporte-supervisor')
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

// Eliminar un registro
export const removeReporteSupervisor = async (id) => {
  try {
    const response = await apiClient.delete(`reporte-supervisor/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
