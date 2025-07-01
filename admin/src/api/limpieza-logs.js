import dayjs from 'dayjs'
import { apiClient } from './configAxios'
import { getLabelByValue } from '../utils/obtenerTablaEstilizada'

// Leer registros
export const getLimpiezaLog = async () => {
  try {
    const response = await apiClient.get('limpieza-logs')
    const { data } = response

    return data.map((log) => {
      const detalles = log.detalles ? JSON.stringify(log.detalles, null, 3) : ''

      return {
        ...log,
        fecha_ejecucion_format: dayjs(log.fecha_ejecucion).format(
          'DD/MM/YYYY hh:mm:ss A'
        ),
        fecha_ejecucion: dayjs(log.fecha_ejecucion).format(
          'YYYY-MM-DD HH:mm:ss'
        ),
        tabla_format: getLabelByValue(log.tabla),
        detalles
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}
