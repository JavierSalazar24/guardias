import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getReporteGuardia = async () => {
  try {
    const response = await apiClient.get('reporte-guardia')
    const { data } = response
    return data.map((check) => {
      const guardia = `${check.guardia.nombre} ${check.guardia.apellido_p} (${check.guardia.numero_empleado})`

      const equipo = []
      Object.entries(check.equipo).forEach(([key, value]) => {
        if (value) equipo.push(key)
      })

      return {
        ...check,
        nombre: guardia,
        quien_entrega: guardia,
        orden: check.orden_servicio.codigo_orden_servicio,
        fecha_format: dayjs(check.fecha).format('DD/MM/YYYY hh:mm:ss A'),
        equipo_entregado: equipo.join(', ')
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeReporteGuardia = async (id) => {
  try {
    const response = await apiClient.delete(`reporte-guardia/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
