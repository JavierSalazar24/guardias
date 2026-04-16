import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createPrestamo = async (data) => {
  try {
    const response = await apiClient.post('prestamos', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getPrestamo = async () => {
  try {
    const response = await apiClient.get('prestamos')
    const { data } = response

    return data.map((prestamo) => {
      const guardia = `${prestamo.guardia.nombre} ${prestamo.guardia.apellido_p} ${prestamo.guardia.apellido_m}`
      const monto_total_format = `$${prestamo.monto_total}`
      const saldo_restante_format = `$${prestamo.saldo_restante}`
      const guardia_id = { label: guardia, value: prestamo.guardia.id }
      const fecha_prestamo_format = dayjs(prestamo.fecha_prestamo).format(
        'DD/MM/YYYY'
      )
      const fecha_pagado_format = prestamo.fecha_pagado
        ? dayjs(prestamo.fecha_pagado).format('DD/MM/YYYY')
        : 'No ha pagado'

      const cuotas = `${prestamo.abonos?.length || 0}/${prestamo.numero_pagos}`
      const modulo_prestamo_id = {
        label: prestamo.modulo_prestamo.nombre,
        value: prestamo.modulo_prestamo.id
      }
      const banco_id = {
        label: prestamo.banco.nombre,
        value: prestamo.banco.id
      }

      return {
        nombre: guardia,
        guardia_id,
        monto_total_format,
        saldo_restante_format,
        fecha_prestamo_format,
        fecha_pagado_format,
        cuotas,
        modulo_prestamo_id,
        banco_id,
        ...prestamo
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getPrestamoPendiente = async () => {
  try {
    const response = await apiClient.get('prestamos-pendientes')
    const { data } = response

    return data.map((prestamo) => {
      const guardia = `${prestamo.guardia.nombre} ${prestamo.guardia.apellido_p} ${prestamo.guardia.apellido_m}`
      const monto_total_format = `$${prestamo.monto_total}`
      const guardia_id = { label: guardia, value: prestamo.guardia.id }
      const banco_id = {
        label: prestamo.banco.nombre,
        value: prestamo.banco.id
      }

      return {
        nombre: guardia,
        guardia_id,
        monto_total_format,
        banco_id,
        ...prestamo
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updatePrestamo = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`prestamos/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removePrestamo = async (id) => {
  try {
    const response = await apiClient.delete(`prestamos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
