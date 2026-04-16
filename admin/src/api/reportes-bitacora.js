import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getReporteBitacora = async () => {
  try {
    const response = await apiClient.get('reporte-bitacoras')
    const { data } = response
    return data.map((bitacora) => {
      const guardia = `${bitacora.guardia.nombre} ${bitacora.guardia.apellido_p} (${bitacora.guardia.numero_empleado})`

      const fechaHoraInicio = `2019-10-24T${bitacora.hora_inicio_recorrido}`
      const fechaHoraFin = `2019-10-24T${bitacora.hora_fin_recorrido}`

      return {
        ...bitacora,
        nombre: guardia,
        orden: bitacora.orden_servicio.codigo_orden_servicio,
        fecha_format: dayjs(bitacora.fecha).format('DD/MM/YYYY'),
        hora_inicio_format: dayjs(fechaHoraInicio).format('hh:mm:ss A'),
        hora_fin_format: dayjs(fechaHoraFin).format('hh:mm:ss A')
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeReporteBitacora = async (id) => {
  try {
    const response = await apiClient.delete(`reporte-bitacoras/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
