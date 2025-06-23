import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createDescuento = async (data) => {
  try {
    const response = await apiClient.post('descuentos', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getDescuento = async () => {
  try {
    const response = await apiClient.get('descuentos')
    const { data } = response

    return data.map((descuento) => {
      const guardia = `${descuento.guardia.nombre} ${descuento.guardia.apellido_p} ${descuento.guardia.apellido_m}`
      const monto_format = `$${descuento.monto}`
      const guardia_id = { label: guardia, value: descuento.guardia.id }
      const fecha_descuento_format = dayjs(descuento.fecha).format('DD/MM/YYYY')
      const modulo_descuento_id = {
        label: descuento.modulo_descuento.nombre,
        value: descuento.modulo_descuento.id
      }
      const observaciones_format = descuento.observaciones || 'Ninguna'
      const tipo_descuento = descuento.modulo_descuento.nombre

      return {
        nombre: guardia,
        guardia_id,
        monto_format,
        fecha_descuento_format,
        modulo_descuento_id,
        observaciones_format,
        tipo_descuento,
        ...descuento
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateDescuento = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`descuentos/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeDescuento = async (id) => {
  try {
    const response = await apiClient.delete(`descuentos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
