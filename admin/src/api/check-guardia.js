import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getCheckGuardia = async () => {
  try {
    const response = await apiClient.get('check-guardia')
    const { data } = response
    return data.map((check) => {
      const guardia =
        check.tipo_guardia === 'Empleado'
          ? `${check.guardia.nombre} ${check.guardia.apellido_p} (${check.guardia.numero_empleado})`
          : check.nombre_guardia

      const fecha_salida_format = check.fecha_salida
        ? dayjs(check.fecha_salida).format('DD/MM/YYYY hh:mm:ss A')
        : 'Sin checkout'

      const latitud_longitud = `${check.latitude}, ${check.longitude}`
      const latitud_longitud_salida = `${check.latitude_salida}, ${check.longitude_salida}`

      return {
        ...check,
        nombre: guardia,
        orden: check.orden_servicio.codigo_orden_servicio,
        fecha_entrada_format: dayjs(check.fecha_entrada).format(
          'DD/MM/YYYY hh:mm:ss A'
        ),
        fecha_salida_format,
        latitud_longitud,
        latitud_longitud_salida
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeCheckGuardia = async (id) => {
  try {
    const response = await apiClient.delete(`check-guardia/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
