import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createAbonoPrestamo = async (data) => {
  try {
    const response = await apiClient.post('abonos-prestamo', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getAbonoPrestamo = async () => {
  try {
    const response = await apiClient.get('abonos-prestamo')
    const { data } = response

    return data.map((abono) => {
      const guardia = `${abono.prestamo.guardia.nombre} ${abono.prestamo.guardia.apellido_p} ${abono.prestamo.guardia.apellido_m}`
      const monto_format = `$${abono.monto}`
      const guardia_id = { label: guardia, value: abono.prestamo.guardia.id }
      const fecha_format = dayjs(abono.fecha).format('DD/MM/YYYY')
      const prestamo_id = {
        label: `${guardia} (${abono.prestamo.monto_total})`,
        value: abono.prestamo.id
      }
      const banco_id = {
        label: abono.banco.nombre,
        value: abono.banco.id
      }
      const prestamo = `${guardia} (${monto_format})`

      return {
        ...abono,
        nombre: guardia,
        guardia_id,
        banco_id,
        monto_format,
        fecha_format,
        prestamo_id,
        prestamo
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateAbonoPrestamo = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`abonos-prestamo/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeAbonoPrestamo = async (id) => {
  try {
    const response = await apiClient.delete(`abonos-prestamo/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
