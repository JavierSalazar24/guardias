import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createRecorridoGuardia = async (data) => {
  try {
    const response = await apiClient.post('recorridos-guardia', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getRecorridoGuardia = async () => {
  try {
    const response = await apiClient.get('recorridos-guardia')
    const { data } = response
    return data.map((recorrido) => ({
      orden: recorrido.punto.qr_generado.orden_servicio.codigo_orden_servicio,
      nombre: `${recorrido.guardia.nombre} ${recorrido.guardia.apellido_p} (${recorrido.guardia.numero_empleado})`,
      fecha_format: dayjs(recorrido.fecha_escaneo).format(
        'DD/MM/YYYY hh:mm:ss A'
      ),
      nombre_punto: recorrido.punto.nombre_punto,
      ...recorrido
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateRecorridoGuardia = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`recorridos-guardia/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeRecorridoGuardia = async (id) => {
  try {
    const response = await apiClient.delete(`recorridos-guardia/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
