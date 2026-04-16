import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getReportePatrullas = async () => {
  try {
    const response = await apiClient.get('reporte-patrullas')
    const { data } = response

    return data.map((patrulla) => {
      const guardia = `${patrulla.guardia.nombre} ${patrulla.guardia.apellido_p} (${patrulla.guardia.numero_empleado})`

      return {
        ...patrulla,
        nombre: guardia,
        orden: patrulla.orden_servicio.codigo_orden_servicio,
        fecha_format: dayjs(patrulla.created_at).format(
          'DD/MM/YYYY hh:mm:ss A'
        ),
        fecha: dayjs(patrulla.created_at).format('YYYY-MM-DDTHH:mm:ss')
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeReportePatrullas = async (id) => {
  try {
    const response = await apiClient.delete(`reporte-patrullas/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
